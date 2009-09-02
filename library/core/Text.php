<?php
/**
 * Tratamento de informacoes textuais
 *
 *
 *    @filesource     $HeadURL:  $
 *    @category       Framework
 *    @package        oraculum
 *    @subpackage     oraculum.core.text
 *    @license        http://www.opensource.org/licenses/lgpl-3.0.html (LGPLv3)
 *    @version        $Revision: 268 $
 *    @modifiedby     $LastChangedBy: Patrick $
 *    @lastmodified   $Date: 2009-04-17 15:58:09 -0300 (Sex, 17 Abr 2009) $
 *
 */

class Oraculum_Text extends Oraculum
{
  // Converter moeda
  public static function moeda($string,$cifrao=TRUE)
  {
    $string=round($string, 2);
    $string=number_format($string, 2, ",", ".");
    if ($cifrao) {
      $string=MOEDA." ".$string;
    }
    return $string;
  }

  // Converter moeda para formato SQL
  public static function moedasql($string)
  {
    $string=str_replace(",", ".", $string);
    $string=round($string, 2);
    $string=number_format($string, 2, ".", ",");
    $string=round($string, 2);
    return $string;
  }

  // Fornecer/Converter data em formato brasileiro
  public static function data($data=null,$notnull=true)
  {
    if (!is_null($data)) {
      return date("d/m/Y", strtotime($data));
    } else if ($notnull) {
      return date("d/m/Y");
    } else {
      return null;
    }
  }

  // Fornecer/Converter data do formato brasileiro para o formato do sql
  public static function data_sql($data=null,$notnull=true)
  {
    if (!is_null($data)) {
      $data=implode("-", array_reverse(explode("/", $data)));
      return $data;
    } else if ($notnull) {
      return date("Y-m-d");
    } else {
      return null;
    }
  }

  // Fornecer/Converter data do formato brasileiro para o formato do mysql
  public static function data_mysql($data=null, $notnull=true)
  {
  	return Oraculum_Text::data_sql($data, $notnull);
  }

  // Determinar o saudacao do dia
  public static function saudacao()
  {
    $hora=date('H');
    if (($hora>=6)&&($hora<12)) {
      $saudacao="Bom Dia";
    } else if (($hora>=12)&&($hora<18)) {
      $saudacao="Bom Tarde";
    } else if (($hora>=18)||($hora<6)) {
      $saudacao="Bom Noite";
    }
    return $saudacao;
  }

  public static function getpwd($estrutura=array())
  {
    $pwd="<span class=\"url_pwd\">/<a href=\"".BASE_URL."/\">home</a>";
    $total=sizeof($estrutura);
    $contador=0;
    foreach ($estrutura as $link => $descricao) {
      $pwd.="/";
      if (($contador+1)==$total) {
        $pwd.="<a href=\"".BASE_URL."/".$link."\" ";
        $pwd.="style=\"font-weight: bold;\">\n";
        $pwd.=$descricao;
        $pwd.="</a>";
      } else {
        $pwd.="<a href=\"".BASE_URL."/".$link."\">\n";
        $pwd.=$descricao;
        $pwd.="</a>";
      }
      $contador++;
    }
    $pwd.="</span><br />";
    return $pwd;
  }

  public static function inflector($palavra,$n=1,$return=true,$addnumber=true)
  {
    $palavra=$n>1?plural($palavra):$palavra;
    if ($addnumber) {
        $str=$n." ".$palavra;
    } else {
        $str=$palavra;
    }
    if ($return) {
      echo $str;
      return null;
    } else {
    return $str;
    }
  }

  public static function plural($palavra)
  {
    if (preg_match('/[sz]$/', $palavra)||
    (preg_match('/[^aeioudgkprt]h$/', $palavra))) {
      $palavra.="es";
    } else if (preg_match('/[^aeiou]y$/', $palavra)) {
      $palavra=substr_replace($palavra, 'ies', -1);
    } else if (preg_match('/[x]$/', $palavra)) {
      $palavra=$palavra;
    } else if (preg_match('/[m]$/', $palavra)) {
      $palavra=substr_replace($palavra, 'ns', -1);
    } else if ((preg_match('/[til]$/', $palavra))||
    (preg_match('/[ssil]$/', $palavra))) {
      $palavra=substr_replace($palavra, 'eis', -2);
    } else if (preg_match('/[il]$/', $palavra)) {
      $palavra=substr_replace($palavra, 's', -1);
    } else if (preg_match('/[l]$/', $palavra)) {
      $palavra=substr_replace($palavra, 'is', -1);
    } else if (preg_match('/[rnsz]$/', $palavra)) {
      $palavra.="es";
    } else {
      $palavra.='s';
    }
    return $palavra;
  }


    public static function removeacentos($string)
    {
	    $acentos=array(
	        "A"=>"/[".chr(194).chr(192).chr(193).chr(196).chr(195)."]/",
	        "E"=>"/[".chr(202).chr(200).chr(201).chr(203)."]/",
	        "I"=>"/[".chr(206).chr(205).chr(204).chr(207)."]/",
	        "O"=>"/[".chr(212).chr(213).chr(210).chr(211).chr(214)."]/",
	        "U"=>"/[".chr(219).chr(217).chr(218).chr(220)."]/",
	        "C"=>"/[".chr(199)."]/",
	        "N"=>"/[".chr(209)."]/",
	        "a"=>"/[".chr(226).chr(227).chr(224).chr(225).chr(228)."]/",
	        "e"=>"/[".chr(234).chr(232).chr(233).chr(235)."]/",
	        "i"=>"/[".chr(238).chr(237).chr(236).chr(239)."]/",
	        "o"=>"/[".chr(244).chr(245).chr(242).chr(243).chr(246)."]/",
	        "u"=>"/[".chr(251).chr(250).chr(249).chr(252)."]/",
	        "c"=>"/[".chr(231)."]/",
	        "n"=>"/[".chr(241)."]/"
	    );
        return preg_replace(array_values($acentos), array_keys($acentos), $string);
    }
    public static function t($constant)
    {
        echo constant($constant);
    }
    public static function lang($constant)
    {
        Oraculum_Text::t("LANG_".strtoupper($constant));
    }
}