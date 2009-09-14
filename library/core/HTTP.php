<?php
/**
 * Tratamento de parametros HTTP
 *
 *
 *    @filesource     $HeadURL:  $
 *    @category       Framework
 *    @package        oraculum
 *    @subpackage     oraculum.core.http
 *    @license        http://www.opensource.org/licenses/lgpl-3.0.html (LGPLv3)
 *    @version        $Revision: 247 $
 *    @modifiedby     $LastChangedBy: Patrick $
 *    @lastmodified   $Date: 2009-04-16 11:44:46 -0300 (Qui, 16 Abr 2009) $
 *
 */

class Oraculum_HTTP extends Oraculum
{
  // Redirecionar
  public static function redirect($url) {
    if (isset($url)) {
      header("Location: ".$url);
      echo "<script type=\"text/javascript\">\n";
      echo "  document.location.href='".$url."';\n";
      echo "</script>\n";
      exit;
    }
  }

  // Capturar endereco IP
  public static function ip()
  {
    $ip=$_SERVER['REMOTE_ADDR'];
    return $ip;
  }

  // Capturar HOST
  public static function host()
  {
    $host=isset($_SERVER['REMOTE_HOST'])?$_SERVER['REMOTE_HOST']:null;
    if ((is_null($host))||($host=="")) {
      $host=ip();
    }
    return $host;
  }
}