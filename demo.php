<?php

include 'call_js.php';

$js_my_lib = new JsCaller(getcwd(), 'my_lib');

echo $js_my_lib->call('my_sum', [ 'n1' => 10, 'n2' => 5 ]);

var_dump(
  json_decode(
    $js_my_lib->call('hello', [
      "name" => "Edoardo",
      "age" => "99"
    ])
  )
);

?>
