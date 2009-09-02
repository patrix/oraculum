<?php
  // Receber variaveis por $_POST
  function post($indice,$tipo="s")
  {
    if ((isset($_POST[$indice]))&&($_POST[$indice]!="")) {
      $valor=$_POST[$indice];
      if ($tipo!="h") {
        $valor=strip_tags($valor);
        $valor=htmlentities($valor);
      } else if ($tipo=="n") {
      	$valor=floor($valor);
      }
    } else {
      $valor=null;
    }
    return $valor;
  }
  // Receber variaveis por $_GET
  function get($indice,$tipo="s")
  {
    if ((isset($_GET[$indice]))&&($_GET[$indice]!="")) {
      $valor=$_GET[$indice];
    } else {
      $valor=null;
    }
    $valor=strip_tags($valor);
    $valor=htmlentities($valor);
    $valor=addslashes($valor);
    if ($tipo=="n") {
      $valor=floor($valor);
      if ($valor==0) {
        $valor=null;
      }
    }
    return $valor;
  }

  function fopen_recursive($path, $mode, $chmod=0777)
  {
      $directory=dirname($path);
      $file=basename($path);
      if (!is_dir($directory)) {
          if (!mkdir($directory, $chmod, 1)) {
              return false;
          }
      }
      return fopen($path, $mode);
  }