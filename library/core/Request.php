<?php
/**
 * Tratamento de requisicoes
 *
 *
 *    @filesource     $HeadURL: $
 *    @category       Framework
 *    @package        oraculum
 *    @subpackage     oraculum.core.request
 *    @license        http://www.opensource.org/licenses/lgpl-3.0.html (LGPLv3)
 *    @version        $Revision: 247 $
 *    @modifiedby     $LastChangedBy: Patrick $
 *    @lastmodified   $Date: 2009-04-16 11:44:46 -0300 (Qui, 16 Abr 2009) $
 *
 */

class Oraculum_Request extends Oraculum
{
  // Receber variaveis por $_POST
  public static function post($indice,$tipo="s")
  {
    if ((isset($_POST[$indice]))&&($_POST[$indice]!="")) {
      $valor=$_POST[$indice];
      if ($tipo!="h") {
        $valor=strip_tags($valor);
        $valor=htmlentities($valor);
      } else if ($tipo=="n") {
      	$valor=floor($valor);
		if ($valor==0) {
			$valor=null;
		}
      }
    } else {
      $valor=null;
    }
    return $valor;
  }

  // Receber variaveis por $_GET
  public static function get($indice,$tipo="s")
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

  // Receber variaveis por $_FILES
  public static function file($indice, $atributo=null, $filter=null)
  {
    if ((isset($_FILES[$indice]))&&($_FILES[$indice]!="")) {
      $file=$_FILES[$indice];
      if (($file['error']==0)&&(!is_null($filter))) {
      	$filter=Oraculum_Files::file_filter($file['type'], $filter);
      	if (!$filter) {
      		return false;
      	}
      }
      if (is_null($atributo)) {
          return $file;
      } else {
          return $file[$atributo];
      }
    } else {
      return null;
    }
  }

  // Capturar sessao
  public static function sess($indice)
  {
    if (isset($_SESSION[$indice])) {
      $valor=$_SESSION[$indice];
    } else {
      $valor=null;
    }
    return $valor;
  }

  // Gravar sessao
  public static function setsess($indice,$valor)
  {
    if ((isset($indice))&&(isset($valor))) {
      $_SESSION[$indice]=$valor;
      return true;
    } else {
      return false;
    }
  }

  // Remover variavel de sessao
  public static function unsetsess($indice)
  {
    if (isset($indice)) {
      unset($_SESSION[$indice]);
      return true;
    } else {
      return false;
    }
  }

  // Inicializar sessao
  public static function init_sess()
  {
  	if (!isset($_SESSION)) {
	    if (ini_get('session.save_path')!=DIR_TMP) {
	      session_save_path(DIR_TMP);
	    }
	    session_start();
  	}
  }

  // Gravar cookie
  public static function set_cookie($nome,$valor,$expirar=null)
  {
    $expirar=(is_null($expirar))?(time()+604800):$expirar;
    $return=setcookie($nome, $valor, $expirar);
    return $return;
  }

  // Ler cookie
  public static function cookie($indice)
  {
    if (isset($_COOKIE[$indice])) {
      $valor=$_COOKIE[$indice];
    } else {
      $valor=null;
    }
    return $valor;
  }

  // Capturar pagina
  function getpagina($gets=null)
  {
  	if (is_null($gets)) {
  		$gets=Oraculum_Request::gets();
  	}
    $pagina=null;
    foreach ($gets as $chave=>$valor) {
      if ($chave>1) {
        if ($gets[$chave-1]=="page") {
          $pagina=$valor;
        }
      }
    }
    return $pagina;
  }

  // Capturar ID
  public static function getid($gets=null,$posicao=1)
  {
  	if (is_null($gets)) {
  		$gets=Oraculum_Request::gets();
  	}
    $id=(int)floor($gets[sizeof($gets)-$posicao]);
    return $id;
  }

  // Capturar ultimo parametro
  public static function getlast($gets=null)
  {
  	if (is_null($gets)) {
  		$gets=Oraculum_Request::gets();
  	}
    $acao=($gets[sizeof($gets)-1]);
    return $acao;
  }

  // Capturar parametro
  public static function getvar($index=1,$default=null)
  {
    $gets=Oraculum_Request::gets();
    if (is_string($index)) {
      if (($key=array_search($index, $gets))===FALSE)
        return $default;
      $index=$key+2;
    }
    $index=(int)$index-1;
    return isset($gets[$index])?$gets[$index]:$default;
  }
  // Capturar URI
  public static function gets()
  {
    $request=Oraculum_Request::request();
    //$gets=explode("/", str_replace(strrchr($request, "?"), "/", $request));
    $gets=explode("/", str_replace("?", "/", $request));
    return $gets;
  }
  public static function request()
  {
    return $_SERVER["REQUEST_URI"];
  }
  public static function referer()
  {
    return $_SERVER["HTTP_REFERER"];
  }
}
