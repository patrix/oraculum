<?php
/**
 * Tratamento de criptografia
 *
 *
 *    @filesource     $HeadURL: $
 *    @category       Framework
 *    @package        oraculum
 *    @subpackage     oraculum.core.crypt
 *    @license        http://www.opensource.org/licenses/lgpl-3.0.html (LGPLv3)
 *    @version        $Revision: 247 $
 *    @modifiedby     $LastChangedBy: Patrick $
 *    @lastmodified   $Date: 2009-04-16 11:44:46 -0300 (Qui, 16 Abr 2009) $
 *
 */

class Oraculum_Crypt extends Oraculum
{
  // Criptografar string
  public static function strcrypt($str)
  {
    $str=base64_encode($str);
    $str=base64_decode($str);
    $str=str_rot13($str);
    $str=base64_encode($str);
    $str=str_rot13($str);
    return $str;
  }

  // Descriptografar string
  public static function strdcrypt($str)
  {
    $str=str_rot13($str);
    $str=base64_decode($str);
    $str=str_rot13($str);
    $str=base64_encode($str);
    $str=base64_decode($str);
    return $str;
  }
}