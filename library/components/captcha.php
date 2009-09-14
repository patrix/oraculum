<?php
/**
 * Captcha
 *
 *    @filesource     $HeadURL:  $
 *    @category       Components
 *    @package        oraculum
 *    @subpackage     oraculum.components.captcha
 *    @version        $Revision: 253 $
 *    @modifiedby     $LastChangedBy: Patrick $
 *    @lastmodified   $Date: 2009-04-16 12:50:21 -0300 (Qui, 16 Abr 2009) $
 */
class Captcha
{
  public function __construct($type=1,$string=null)
  {
    if (is_null(Oraculum_Request::sess("captcha"))) {
      if (($type==2)||($type==3)) {
        $aux=$string.time();
        $aux=(md5(base64_encode(str_rot13($aux))));
        $aux=str_rot13(base64_encode(str_rot13($aux)));
        if ($type==2) {
                  $aux=strtolower($aux);
        }
        $string=substr($aux, 0, 6);
      } else {
              $string=rand(1, 999999);
      }
      Oraculum_Request::setsess("captcha", $string);
    } else {
      $string=Oraculum_Request::sess("captcha");
    }
    $img=imagecreate(60, 25);
    $backcolor=imagecolorallocate($img, 255, 255, 255);
    $textcolor=imagecolorallocate($img, 000, 000, 000);
    imagefill($img, 0, 0, $backcolor);
    imagestring($img, 10, 5, 5, $string, $textcolor);
    header("Content-type: image/jpeg");
    imagejpeg($img);
  }
}
