## Form validation library for [🦔 Sonic](https://github.com/iamdual/sonic)

### Install
* Copy `Libraries/Validation.php` and `Libraries/Validation/Rules.php` files to the project folder.
* Copy `Languages` folder and its files to the project folder.
* Autoload the validation translates from `Config/Autoload.php` as below:
```php
final class Autoload
{
    public $enabled = false; # languages doesn't need the enabling.
    public $helpers = [];
    public $libraries = [];
    public $languages = ["validation"];
}
```

### Usage
```php
$validation = new \App\Libraries\Validation();
$validation->add("username", "Username", ["trim", "strtolower", "unique:users.username", "min_length:3"]);
$validation->add("email", "E-mail address", ["email", "unique:users.email"]);
$validation->add("name", "Your name"); // 'name' field will be required.
if ($validation->run()) {
  // Yeey!
} else {
  echo $validation->error();
}
```

### Rules
| Method       | Example        |
|--------------|----------------|
| min_length   | `min_length:2`   |
| max_length   | `max_length:12`  |
| exact_length | `exact_length:6` |
| not_empty | `not_empty` |
| numeric | `numeric` |
| range | `range:1,10` |
| min | `min:1` |
| max | `max:2` |
| contains | `contains:a,b,c,d` |
| not_contains | `not_contains:x,y,z` |
| starts_with | `starts_with:abc` |
| ends_with | `ends_with:xyz` |
| alphanumeric | `alphanumeric` |
| alpha | `alpha` |
| email | `email` |
| hostname | `hostname` |
| url | `url` |
| ip | `ip` |
| mac | `mac` |
| regex | `regex` |
| match | `match:/^[a-zA-Z_]$/` |
| unique | `unique:users.username` |

### Replacer functions
You can add the replacer functions as the validation rule such as `trim`, `strtolower`, `strtoupper`.. The callable functions that you have added as rule, also will replace the $_POST variables after the validation.

### Author
Ekin Karadeniz &lt;iamdual@protonmail.com&gt;
