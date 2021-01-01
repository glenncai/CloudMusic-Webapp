# Cloud Music Webapp

- [X] login and register form
- [ ] completing the signup and login process
- [ ] styling the registration page
- [ ] now playing bar
- [ ] navigation menu
- [ ] music main page
- [ ] album page
- [ ] the music player
- [ ] seamless page transitions
- [ ] artist page
- [ ] serach music page
- [ ] playlists
- [ ] song options
- [ ] setting page
- [ ] upload to internet

<br><br>

## 1. login and register form
* Create `sanitize function` in register-handler.php file.
  * `strip_tags()` => strips a string. For example, "`Hello <b>world!</b>`" will return `Hello world`.
  * `str_replace()` => I use this in order to change the space into empty if user type.
  * `htmlspecialchars()` => converts some predefined characters to HTML entities in order to prevent XSS attack. (&"'<>).
  * `strtolower()` => make the string to lowercase.
  * `ucfirst()` => make the string's first letter to uppercase.

* In Account.php file, I make a class called Account which is including all the validate function.
  * I store the error message in errorArray, if the `class Account` is be defined in register.php, the errorArray array will be created.
  * `array_push` => append the error message to array.
  * `getError()` function is trying to judge if there are any error messages in array.
  * Also, I use the `static method` to define the error messages which is in `Constants.php`. This is a very good way to keep error message in sync if we change message.

* If user types error value in the input field and submit the form, keep data showing in the input field is needed.
  * I create a function called `keepValueLastTime($value)` in register.php, then call this function in the `attribute:value` of input.

* I use `empty()` in Account.php to check if there are any errors message in errorArray, if not, return `true`. Then `$wasSuccessed` which is in register-handler.php will receive the `true` value and be redirected to `index.php` by `header("Location: index.php")`. At the same time, the data will be inserted into database. Otherwise, showing the error message.

