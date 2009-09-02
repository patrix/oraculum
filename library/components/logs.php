<?php
/**
 * Componente de Logs
 *
 *
 *    @filesource
 *    @category       Components
 *    @package        oraculum
 *    @subpackage     oraculum.components.Logs
 *    @required       Permissao de escrita pelo usuario do servidor Web na pasta /logs
 */
  // Verifica se e pra exibir os logs quando ocorrer algum erro em algum script
	if ((NLOGS==1)||(NLOGS==3)) {
	    set_error_handler('gravalog');
	    //set_exception_handler('Oraculum_Logs::showException');
	}
  // Funcao para gravar logs
  function gravalog($numero,$texto,$pagina=null,$linha=null,$contexto=null)
  {
    $ddf=fopen(DIR_LOGS.date('Y.M.d').".log", 'a');
    if ($ddf) {
      $datalog=date('d.m.Y H:i:s');
      $txt="::[".$datalog."]--|".ip()."|----------------------\n";
      $txt.="(".$numero.") ".$texto."\n";
      if (!is_null($pagina)) {
        $txt.="Pagina: ".$pagina."\n";
      }
      if (!is_null($linha)) {
        $txt.="Linha: ".$linha."\n";
      }
      $txt.="\n";
      if (fwrite($ddf, $txt)) {
        return true;
        if (DEBUG) {
          alert('Arquivo gravado com sucesso', false);
        }
      }
    } else if (DEBUG) {
      alert('Erro ao gravar arquivo', false);
    }
    fclose($ddf);
  }