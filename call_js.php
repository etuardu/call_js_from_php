<?php

  class JsCaller {
    private $dir;
    private $module;

    public function __construct($dir, $module) {
      $this->dir = $dir; # module's directory
      $this->module = $module; # js source file without extension
    }

    private function create_run_script($function) {
      $run_script = tempnam(sys_get_temp_dir(), 'js');

      $run_script_handle = fopen($run_script, 'w');
      fwrite($run_script_handle, "
        const js_module = require('$this->dir/$this->module');
        var fs = require('fs');
        console.log(
          JSON.stringify(
            js_module.$function(
              JSON.parse(
                fs.readFileSync(0).toString()
              )
            )
          )
        );
      ");

      fclose($run_script_handle);
      return $run_script;
    }

    public function call($function, $input) {

      $descriptorspec = array(
         0 => array("pipe", "r"),
         1 => array("pipe", "w")
      );

      $jsobj = json_encode($input);

      $run_script = $this->create_run_script($function);

      $process = proc_open("node $run_script", $descriptorspec, $pipes, null, null);
      fwrite($pipes[0], $jsobj);
      fclose($pipes[0]);
      $ret = fgets($pipes[1], 4096);
      fclose($pipes[1]);
      proc_close($process);

      unlink($run_script);

      return $ret;

    }

  };

?>
