<?php
/**
 * Tratamento de Views
 *
 *
 *    @filesource     $HeadURL: $
 *    @category       Framework
 *    @package        oraculum
 *    @subpackage     oraculum.core.views
 *    @license        http://www.opensource.org/licenses/lgpl-3.0.html (LGPLv3)
 *    @version        $Revision: 247 $
 *    @modifiedby     $LastChangedBy: Patrick $
 *    @lastmodified   $Date: 2009-04-16 11:44:46 -0300 (Qui, 16 Abr 2009) $
 *
 */

class Oraculum_Views extends Oraculum
{
  public static function layout($tipo, $autoreturn=true, $project=PROJECT)
  {
    $tipo=((($tipo=="css")||($tipo=="img")||($tipo=="js")||($tipo=="swf"))?
    $tipo:null);
    $layout=BASE_URL."layout/".$project."/".$tipo."/";
    if ($autoreturn) {
      echo $layout;
    } else {
      return $layout;
    }
  }
  public static function loadview($view=null, $modulo="index", $titulo=null, $vars=array())
  {
  	foreach ($vars as $key=>$value) {
  		$$key=$value;
  	}
    if (!is_null($view)) {
      $viewsdir="./apps/".PROJECT."/views/modulos/";
      $viewphp=$viewsdir.$modulo."/".$view.".php";
      $viewshtml=$viewsdir.$modulo."/".$view.".shtml";
      $viewhtml=$viewsdir.$modulo."/".$view.".html";
      if (file_exists($viewshtml)) {
        include($viewshtml);
        return true;
      } else if (file_exists($viewhtml)) {
        include($viewhtml);
        return true;
      } else if (file_exists($viewphp)) {
        include($viewphp);
        return true;
      } else {
      	return false;
      }
    } else {
    	return false;
    }
  }
}