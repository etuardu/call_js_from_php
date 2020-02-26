# call_js_from_php

This library is basically a php wrapper around nodejs.
It provides a class to run javascript functions from php.
The javscript source is loaded from a js file, and it is run executing
nodejs with `proc_open()`.

## Usage

In your javascript source, you have to export the functions you want
to access from php, e.g.:

```
function my_sum(obj) {
  return obj.n1 + obj.n2;
}

module.exports = {
  my_sum: my_sum
};
```
*./my_lib.js*

Then, you can call the function from php in this way:

```
<?php

include 'call_js.php';

$js_my_lib = new JsCaller(getcwd(), 'my_lib');

echo $js_my_lib->call('my_sum', [ 'n1' => 10, 'n2' => 5 ]);
# print 15

?>
```
*./demo.php*

## Dependencies

* nodejs

## Known issues

* For now, the javascript functions accepts a single argument.
  If you need to pass multiple arguments, you could use an object.
