<?php
/**
 * Tratamento de rotas
 *
 *
 *    @filesource     $HeadURL: $
 *    @category       Framework
 *    @package        oraculum
 *    @subpackage     oraculum.core.routes
 *    @license        http://www.opensource.org/licenses/lgpl-3.0.html (LGPLv3)
 *    @version        $Revision: 268 $
 *    @modifiedby     $LastChangedBy: Patrick $
 *    @lastmodified   $Date: 2009-04-17 15:58:09 -0300 (Sex, 17 Abr 2009) $
 *
 */

class Oraculum_Routes extends Oraculum
{
  private function __construct() {
  }
  public static function add($origem, $destino)
  {
    $request=Oraculum_Request::request();
    $_SERVER["REQUEST_URI"]=str_replace($origem, $destino, $request);
  }
  public static function check()
  {
    $rotas="./apps/".PROJECT."/controllers/routes.php";
    if (file_exists($rotas)) {
        include($rotas);
    }
    return null;
  }
}