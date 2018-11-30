<?php namespace App\Libraries;
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
final class Validation extends \App\Libraries\Validation\Rules
{
    const ITEM_FIELD_NAME = 0;
    const ITEM_VALIDATIONS = 1;

    private $items = [];
    private $success = false;
    private $error = null;

    public function add(string $id, string $field_name, array $validations = [])
    {
        $this->items[$id] = [$field_name, $validations];
    }

    public function run(): bool
    {
        foreach ($this->items as $id => $data) {
            if (! isset($_POST[$id])) {
                $this->error = sprintf(__("validation_required"), $data[self::ITEM_FIELD_NAME]);
                break;
            }
            foreach ($data[self::ITEM_VALIDATIONS] as $validation) {
                $this->input = &$_POST[$id];
                if (! is_array($this->input)) {
                    $sides = explode(":", $validation, 2);
                    if (method_exists($this, $sides[0])) {
                        if (isset($sides[1])) {
                            $this->success = $this->{$sides[0]}($sides[1]);
                            if (! $this->success) {
                                $this->error = sprintf(__("validation_{$sides[0]}"), $data[self::ITEM_FIELD_NAME], $sides[1]);
                                break 2;
                            }
                        } else {
                            $this->success = $this->{$sides[0]}();
                            if (! $this->success) {
                                $this->error = sprintf(__("validation_{$sides[0]}"), $data[self::ITEM_FIELD_NAME]);
                                break 2;
                            }
                        }
                    } else if (is_callable($sides[0])) {
                        $this->input = $sides[0]($this->input);
                    }
                }
            }
        }

        return $this->success;
    }

    public function error(): ?string
    {
        return $this->error;
    }
}