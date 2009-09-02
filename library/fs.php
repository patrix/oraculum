<?php
  /*
   * Arquivo com funcoes globais que na verdade chamam funcoes de
   * suas respectivas classes
   */


/**********************************
 * Tratamento de requisicoes
 **********************************/
  // Receber variaveis por $_POST
  function post($indice, $tipo="s")
  {
  	return Oraculum_Request::post($indice, $tipo);
  }
  // Receber variaveis por $_GET
  function get($indice, $tipo="s")
  {
  	return Oraculum_Request::get($indice, $tipo);
  }
  // Capturar sessao
  function sess($indice)
  {
    return Oraculum_Request::sess($indice);
  }
  // Gravar sessao
  function setsess($indice, $valor)
  {
    return Oraculum_Request::setsess($indice, $valor);
  }
  // Remover variavel de sessao
  function unsetsess($indice)
  {
    return Oraculum_Request::unsetsess($indice);
  }
  // Inicializar sessao
  function init_sess()
  {
    return Oraculum_Request::init_sess();
  }
  // Gravar cookie
  function set_cookie($nome, $valor, $expirar=null)
  {
    return Oraculum_Request::set_cookie($nome, $valor, $expirar);
  }
  // Ler cookie
  function cookie($indice)
  {
    return Oraculum_Request::set_cookie($indice);
  }
  // Capturar pagina
  function getpagina($gets)
  {
    return Oraculum_Request::getpagina($gets);
  }
  // Capturar ID
  function getid($gets=array(), $posicao=1)
  {
    return Oraculum_Request::getid($gets, $posicao);
  }
  // Capturar ultimo parametro
  function getlast($gets=array())
  {
    return Oraculum_Request::getlast($gets);
  }
  // Capturar parametro
  function getvar($index=1, $default=NULL)
  {
    return Oraculum_Request::getvar($index, $default);
  }
  // Capturar URI
  function gets()
  {
    return Oraculum_Request::gets();
  }

/**********************************
 * Tratamento de criptografia
 **********************************/
  // Criptografar string
  function strcrypt($str)
  {
    return Oraculum_Crypt::strcrypt($str);
  }
  // Descriptografar string
  function strdcrypt($str)
  {
    return Oraculum_Crypt::strdcrypt($str);
  }

/**********************************
 * Tratamento de parametros HTTP
 **********************************/
  // Redirecionar
  function redirect($url)
  {
    return Oraculum_HTTP::redirect($url);
  }
  // Capturar endereco IP
  function ip()
  {
    return Oraculum_HTTP::ip();
  }
  // Capturar HOST
  function host()
  {
    return Oraculum_HTTP::host();
  }

/**********************************
 * Tratamento de formularios
 **********************************/
  function validar($valor=null,$tipo="s",$notnull=false)
  {
    return Oraculum_Forms::validar($valor, $tipo, $notnull);
  }
  function verificaCPF($cpf)
  {
    return Oraculum_Forms::verificaCPF($cpf);
  }
  function verificaEmail($email)
  {
    return Oraculum_Forms::verificaEmail($email);
  }
/**********************************
 * Tratamento de Views
 **********************************/
  function layout($tipo, $autoreturn=true)
  {
    return Oraculum_Views::layout($tipo, $autoreturn);
  }
/**********************************
 * Tratamento de informacoes textuais
 **********************************/
  // Converter moeda
  function moeda($string, $cifrao=TRUE)
  {
    return Oraculum_Text::moeda($string, $cifrao);
  }
  // Converter moeda para formato SQL
  function moedasql($string)
  {
    return Oraculum_Text::moedasql($string);
  }
  // Fornecer/Converter data em formato brasileiro
  function data($data=null, $notnull=true)
  {
    return Oraculum_Text::data($data, $notnull);
  }
  // Fornecer/Converter data do formato brasileiro para o formato do mysql
  function data_mysql($data=null,$notnull=true)
  {
    return Oraculum_Text::data_mysql($data, $notnull);
  }
  // Determinar o saudacao do dia
  function saudacao()
  {
    return Oraculum_Text::saudacao();
  }
  function getpwd($estrutura=array())
  {
    return Oraculum_Text::getpwd($estrutura);
  }
  function inflector($palavra, $n=1, $return=true)
  {
    return Oraculum_Text::inflector($palavra, $n, $return);
  }
  function plural($palavra)
  {
    return Oraculum_Text::plural($palavra);
  }
/**********************************
 * Tratamento de inclusao de arquvos
 **********************************/
  // Funcao de Inclusao de Arquivos
  function inc($file)
  {
    return Oraculum_Files::inc($file);
  }
  // Funcao de Inclusao de Arquivos com short_tags desabilitada
  function load($arquivo, $return=false)
  {
    return Oraculum_Files::load($arquivo, $return);
  }

/**********************************
 * Tratamento de erros e logs
 **********************************/
  // Funcao de exibicao de mensagens de erro
  function alert($mensagem, $log=false)
  {
    return Oraculum_Logs::alert($mensagem, $log);
  }