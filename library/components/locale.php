<?php
/**
 * Componente de Internacionalizacao
 *
 *
 *    @filesource
 *    @category       Components
 *    @package        oraculum
 *    @subpackage     oraculum.components.I18N
 */
class I18N
{
  public static function load($lang=null)
  {
  	if (!is_null($lang)) {
        $langfile="./apps/".PROJECT."/models/locale/".$lang."/lang.php";
        $altlangfile="./models/locale/".$lang."/lang.php";
  	} else {
	    $langfile="./apps/".PROJECT."/models/locale/".LANG."/lang.php";
	    $altlangfile="./models/locale/".LANG."/lang.php";
  	}
    if (file_exists($langfile)) {
      include($langfile);
      return true;
    } else if (file_exists($altlangfile)) {
      include($altlangfile);
      return true;
    } else {
      // Se não houver o arquivo PHP de idiomas, e gerado um atraves de um arquivo CSV
      if (!is_null($lang)) {
	      $csvlangfile="./apps/".PROJECT."/models/locale/".$lang."/lang.csv";
	      $altcsvlangfile="./models/locale/".$lang."/lang.csv";
      } else {
	      $csvlangfile="./apps/".PROJECT."/models/locale/".LANG."/lang.csv";
	      $altcsvlangfile="./models/locale/".LANG."/lang.csv";
      }
      if (file_exists($csvlangfile)) {
        $handle=fopen($csvlangfile, "r");
      } else if (file_exists($altcsvlangfile)) {
        $handle=fopen($altcsvlangfile, "r");
      }
      if (isset($handle)) {
        $phplangfile="<?php\n";
        while (($linhas=(fgetcsv($handle, 1000, ",")))!==FALSE) {
          $num=(count($linhas)); // Número de campos
          if ($num>1) {
            for ($c=1;$c<$num;$c++) {
              $linhas[$c]=str_replace("\"", "", $linhas[$c]);
              $linhas[$c]=str_replace("\'", "", $linhas[$c]);
              if ($linhas[$c]!="") {
                $phplangfile.="  define(\"LANG_".strtoupper($linhas[$c])."\", \"";
                $phplangfile.=strtolower(htmlentities(utf8_decode($linhas[0])))."\");\n";
              }
            }
          }
        }
        fclose($handle);
        if ((is_writable($langfile))||(!file_exists($langfile))) {
          $file=fopen($langfile, 'w');
          fwrite($file, $phplangfile);
          I18N::load(); // Tenta recarregar o arquivo de Idioma (php) novamente
          fclose($file);
          if (DEBUG) {
            alert("Arquivo de idioma gerado atraves de um arquivo CSV<br /><u>".$langfile."</u>");
          }
          return true;
        } else {
          if (DEBUG) {
            alert("Sem permissao para gerar arquivo de idioma<br /><u>".$langfile."</u>");
          }
          return false;
        }
      } else {
        if (DEBUG) {
          alert("Arquivo referente ao idioma <u>".LANG."</u> nao encontrado!");
        }
        return false;
      }
    }
  }
}
//I18N::load();