<?php namespace App\Config;
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
final class Autoload
{
    public $enabled = false;

    public $helpers = [];
    public $libraries = [];
    public $languages = ["validation"];
}
