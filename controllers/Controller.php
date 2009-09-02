<?php
/**
 *
 *    @filesource     $HeadURL: $
 *    @category       Framework
 *    @package        oraculum
 *    @subpackage     oraculum.controller
 *    @author         Patrick <patrick@sbsti.com.br>
 *    @license        http://www.opensource.org/licenses/lgpl-3.0.html (LGPL3)
 *    @link           http://code.google.com/p/oraculum-php/ Oraculum Framework
 *    @copyright      Copyright 2009, Patrick Kaminski.
 *    @since          Oraculum Framework v 0.3a
 *    @version        $Revision: $
 *    @modifiedby     $LastChangedBy:  $
 *    @lastmodified   $Date: 2009-04-16 12:41:47 -0300 (Qui, 16 Abr 2009) $
 *
 */

class Controller
{
  private $_control=null;
  private $_view=null;
  private $_viewphp=null;
  private $_viewshtml=null;

  public function __construct($gets=null,$return=true) // Constructor
  {
    if (DEBUG) {
      alert("Controlador instanciado");
    }
    if (is_null($gets)) {
      $gets=Oraculum_Request::gets();
      $modulo=(isset($gets[BASE])&&($gets[BASE]!=""))?$gets[BASE]:'index';
      $acao=(isset($gets[BASE+1])&&($gets[BASE+1]!=""))?$gets[BASE+1]:'home';
      // Carregando a classe de metodos que devem ser executados sempre
      new Controller(array('default', 'start'), false);
    } else {
      $modulo=(isset($gets[0])&&($gets[0]!=""))?$gets[0]:'index';
      $acao=(isset($gets[1])&&($gets[1]!=""))?$gets[1]:'home';
    }
    // Definicao dos arquivos das classes relacionadas aos modulos
    $controldir="./apps/".PROJECT."/controllers/modulos/";
    $viewsdir="./apps/".PROJECT."/views/modulos/";
    $this->_control=$controldir.$modulo."/".$acao.".php";
    $this->_view=$viewsdir.$modulo."/".$acao.".shtml (ou html, ou php)";
    $this->_viewphp=$viewsdir.$modulo."/".$acao.".php";
    $this->_viewshtml=$viewsdir.$modulo."/".$acao.".shtml";
    $this->_viewhtml=$viewsdir.$modulo."/".$acao.".html";
    $inccontrol=inc($this->_control);
    if ($inccontrol) {
     // Determina que a classe do controlador segue o padrao AcaoModulo
      $ofcontrol=ucwords($acao).ucwords($modulo);
      $ofobj=new $ofcontrol;
      $ofreturn=$ofobj->$acao($gets);
    } else {
      $inccontrol=inc($controldir."default/home.php");
      // Defermina que sera utilizada a classe padrao
      $ofcontrol="HomeDefault";
      $ofobj=new $ofcontrol;
      $ofreturn=$ofobj->home($gets);
    }
    // Incluindo view e fazendo verificacao se existe
    if ($return) {
      if (file_exists($this->_viewshtml)) {
        include($this->_viewshtml);
      } else if (file_exists($this->_viewhtml)) {
        include($this->_viewhtml);
      } else if (file_exists($this->_viewphp)) {
        include($this->_viewphp);
      } else if ($ofcontrol=="HomeDefault") {
        include("./apps/".PROJECT."/views/modulos/default/home.shtml");
      } else {
        if (DEBUG) {
          alert("Arquivo <u>".$this->_view."</u> nao encontrado");
        }
      }
    }
  }

  public function view()
  {
    if (file_exists($this->_viewshtml)) {
      include_once($this->_viewshtml);
    } else if (file_exists($this->_viewphp)) {
      include_once($this->_viewphp);
    } else {
      if (DEBUG) {
        alert("Arquivo <u>".$this->_view."</u> nao encontrado");
      }
    }
  }

  public function __destruct()
  {
    if (DEBUG) {
      alert("Instancia do Controlador finalizada");
    }
  }
}
