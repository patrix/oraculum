<?php
  define("IP_EXT", "");
  define("IP_INT", "127.0.0.1");
  ini_set("display_errors", false);
  define("DEBUG", 0); // Debug
  define("PROFILER", 0); // Profiler
  error_reporting(E_ALL|E_STRICT); // Reportando todos os erros e alertas (STRICT)
  define("URL", "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/"); // URL Absoluta do sistema
  define("BASE", count(explode("/", URL))-3); // Numeros de diretorios na URL
  define("BASE_URL", URL); // URL Absoluta do sistema
