<?php
  header('P3P: CP="CAO PSA OUR"'); // Evitando possiveis problemas do IE com ob_start
  ob_start(); // Armazenando todo o conteudo em buffer

  /* Constantes do framework */
  define("PROJECT", "default"); // Nome do projeto
  define("DIR_SERVER", dirname(__FILE__)."/../../../"); // Diretorio de logs
  define("DIR_LOGS", realpath(DIR_SERVER."logs/".PROJECT."/")); // Diretorio de logs
  define("DIR_TMP", realpath(DIR_SERVER."tmp/")); // Diretorio temporario /secoes
  define("SMTP_HOST", "servidor"); // Servidor SMTP
  define("SMTP_USER", "email"); // Usuario SMTP
  define("SMTP_PASS", "senha"); // Senha SMTP
  define("LANG", "pt_br"); // Idioma
  define("NLOGS", 0); // Nivel de logs. 0: Nada. 1: Erros. 2: Alertas. 3: Tudo
  date_default_timezone_set("America/Sao_Paulo"); // Timezone
  include_once("./apps/".PROJECT."/config/workspaces/load.php"); // Carregando Workspaces
  include_once("./library/fs.php"); // Carregando funcoes gerais
  include_once("./library/core/Oraculum.php");
  Oraculum::load_all(); // Carregando Base do Oraculum
  Oraculum::start(); // Inicializando Oraculum
  
  /* Descomente a linha abaixo para carregar os arquivos de traducao */
  //I18N::load();
  
  /* Descomente a linha abaixo caso esteja utilizando algum Banco de Dados
     configurado com o Doctrine ORM */
  //include_once("./models/doctrine/".PROJECT.".php");
  
  include_once("./controllers/Controller.php");
  include_once("./apps/".PROJECT."/controllers/modulos/index/home.php");
  
  /* Descomente a linha abaixo caso esteja utilizando algum Banco de Dados
     configurado com o Doctrine ORM */
  //Doctrine::loadModels("./apps/".PROJECT."/models/entidades");
  
  // Inicializando sessao
  init_sess();
