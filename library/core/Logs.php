<?php
/**
 * Tratamento de logs
 *
 *
 *    @filesource     $HeadURL:  $
 *    @category       Framework
 *    @package        oraculum
 *    @subpackage     oraculum.core.logs
 *    @license        http://www.opensource.org/licenses/lgpl-3.0.html (LGPLv3)
 *    @version        $Revision: 269 $
 *    @modifiedby     $LastChangedBy: Patrick $
 *    @lastmodified   $Date: 2009-04-17 17:35:03 -0300 (Sex, 17 Abr 2009) $
 *
 */

class Oraculum_Logs extends Oraculum
{
  // Funcao de exibicao de mensagens de erro
  public static function alert($mensagem, $log=false)
  {
  	if (PROFILER) {
  		if (class_exists("Console")) {
  		    Console::log($mensagem);
  		}
  	} else {
	    $cod=time().rand();
	    echo "<div id=\"alert".$cod."\" style=\"";
	    echo "border:2px solid #456abc; background-color:#ffffe7; color:#000000; ";
	    echo "margin:auto; width:75%; margin-top:10px; text-align:center; ";
	    echo "padding:10px; padding-top:0px; font-family: 'Times New Roman', ";
	    echo "serif; font-style:italic;\">\n";
	    echo "<div style=\"float:right; width:100%; text-align:right; ";
	    echo "clear:both;\">\n";
	    echo "<a href=\"#alert".$cod."\" onclick=\"";
	    echo "document.getElementById('alert".$cod."').style.display='none';\" ";
	    echo "style=\"color: #aa0000; font-size: 1em; text-decoration: none;\" ";
	    echo "title=\"Fechar\">x</a></div>";
	    echo "\n".utf8_decode($mensagem)."\n";
	    echo "</div>\n";
  	}
    if ((NLOGS==2)||(NLOGS==3)||($log)) {
      gravalog('001', $mensagem); // Grava em log o Alerta
    }
  }

	/*
	 * função showException
	 * exibe a pilha de error
	 * de uma exceção
	 */
    public static function showException($e)
    {
    // obtém a pilha de erro
    $errorarray = $e->getTrace();
    // monta uma tabela
    echo '<table border=1>';
    echo '<tr>';
    echo '<td><b>General Error: ' . $e->getMessage(). '<br></td>';
    echo '</tr>';
    // percorre a pilha de erro
    foreach ($errorarray as $error) {
        echo '<tr>';
        echo '<td>';
        // arquivo e linha do erro
        echo 'File: '.$error['file']. ' : '. $error['line'];
        echo '</td>';

        $args = array();

        // transforma os argumentos
        if ($error['args']) {
            foreach ($error['args'] as $arg) {
                if (is_object($arg)) {
                    // objetos transformam-se no nome da classe
                    $args[] = get_class($arg). ' object';
                } else if (is_array($arg)) {
                    // arrays são convertidos para string
                    $args[] = implode(',', $arg);
                } else {
                    $args[] = (string) $arg;
                }
            }
        }
        // exibe os argumentos
        echo '<tr>';
        echo '<td>';
        echo '&nbsp;&nbsp;<i>'.'<font color=green>'.$error['class'].'</font>'.
             '<font color=olive>'.$error['type'].'</font>'.
             '<font color=darkblue>'.$error['function'].'</font>'.
             '('.'<font color=maroon>'.implode(',', $args).'</font>'.')</i>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
    }
}