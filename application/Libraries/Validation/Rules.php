<?php namespace App\Libraries\Validation;
/**
 * Sonic - The open-source application development framework.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package Sonic
 * @author Ekin Karadeniz <iamdual@protonmail.com>
 * @copyright 2018-2019 Ekin Karadeniz
 * @license Apache License 2.0
 */
class Rules
{
    public $input;

    public function min_length(int $length): bool
    {
        return strlen($this->input) > $length;
    }

    public function max_length(int $length): bool
    {
        return strlen($this->input) < $length;
    }

    public function exact_length(int $length): bool
    {
        return strlen($this->input) == $length;
    }

    public function not_empty(): bool
    {
        return strlen(trim($this->input)) > 0;
    }

    public function numeric(): bool
    {
        return is_numeric($this->input);
    }

    public function range(string $range): bool
    {
        $arr_range = explode(",", $range, 2);
        if (! is_numeric($this->input)) { return false; }
        return $this->input >= $arr_range[0] && $this->input <= $arr_range[1];
    }

    public function min(int $number): bool
    {
        if (! is_numeric($this->input)) { return false; }
        return $this->input >= $number;
    }

    public function max(int $number): bool
    {
        if (! is_numeric($this->input)) { return false; }
        return $this->input <= $number;
    }

    public function contains(string $contains): bool
    {
        $arr_contains = explode(",", $contains);
        return in_array($this->input, $arr_contains);
    }

    public function not_contains(string $contains): bool
    {
        $arr_contains = explode(",", $contains);
        return !in_array($this->input, $arr_contains);
    }

    public function starts_with(string $text): bool
    {
        return $this->input[0] === $text[0] ? strncmp($this->input, $text, strlen($text)) === 0 : false;
    }

    public function ends_with(string $text): bool
    {
        return strcmp(substr($this->input, strlen($this->input) - strlen($text)), $text) === 0;
    }

    public function alphanumeric(): bool
    {
        return ctype_alnum($this->input);
    }

    public function alpha(): bool
    {
        return ctype_alpha($this->input);
    }

    public function email(): bool
    {
        return filter_var($this->input, FILTER_VALIDATE_EMAIL);
    }

    public function hostname(): bool
    {
        return filter_var($this->input, FILTER_FLAG_HOSTNAME);
    }

    public function url(): bool
    {
        return filter_var($this->input, FILTER_VALIDATE_URL);
    }

    public function ip(): bool
    {
        return filter_var($this->input, FILTER_VALIDATE_IP);
    }

    public function mac(): bool
    {
        return filter_var($this->input, FILTER_VALIDATE_MAC);
    }

    public function regex(): bool
    {
        return filter_var($this->input, FILTER_VALIDATE_REGEXP);
    }

    public function match(string $exp): bool
    {
        return preg_match($exp, $this->input);
    }

    public function unique(string $table_row): bool
    {
        $sides = explode(".", $table_row, 2);
        $db = \Sonic\Database::getInstance();
        $state = $db->prepare("SELECT count(`{$sides[1]}`) as total FROM {$sides[0]} WHERE `{$sides[1]}`=? LIMIT 1");
        $state->execute([$this->input]);
        return empty($state->fetchColumn(0));
    }
}