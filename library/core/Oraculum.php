<?php
/**
 * Oraculum's Core
 *
 *
 *    @filesource     $HeadURL:  $
 *    @category       Framework
 *    @package        oraculum
 *    @subpackage     oraculum.core
 *    @license        http://www.opensource.org/licenses/lgpl-3.0.html (LGPLv3)
 *    @version        $Revision: 247 $
 *    @modifiedby     $LastChangedBy: Patrick $
 *    @lastmodified   $Date: 2009-04-16 11:44:46 -0300 (Qui, 16 Abr 2009) $
 *
 */
class Oraculum
{
  public static function start()
  {
    include_once("./library/components/logs.php");
    include_once("./library/components/locale.php");
    Oraculum_Routes::check();
    if (!function_exists('checkdnsrr')) {
      function checkdnsrr($host,$type='MX')
      {
          $host=gethostbyname($host); // Verifica o Nome do Servidor
          $host=gethostbyaddr($host); // E o IP
          return $host;
      }
    }
  }
  public static function load_all()
  {
    include_once("./library/core/Crypt.php");
    include_once("./library/core/Files.php");
    include_once("./library/core/Forms.php");
    include_once("./library/core/HTTP.php");
    include_once("./library/core/Logs.php");
    include_once("./library/core/Request.php");
    include_once("./library/core/Routes.php");
    include_once("./library/core/Test.php");
    include_once("./library/core/Text.php");
    include_once("./library/core/Views.php");
  }
  public static function load($modulo)
  {
      $modulos=array("Crypt","Files","Forms","HTTP","Logs","Request","Test","Text","Views");
      if (in_array($modulo, $modulos)) {
          $arquivo="./library/core/".$modulo.".php";
          if (file_exists($arquivo)) {
              include_once($arquivo);
          }
      }
  }
}