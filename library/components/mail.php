<?php
/**
 * Componente de Envio de E-mails
 *
 *
 *    @filesource
 *    @category       Components
 *    @package        oraculum
 *    @subpackage     oraculum.components.sendmail
 *    @required       PHPMailer 2.3 ou superior
 */
  function sendmail($para=array(),$assunto=null,$mensagem=null,$from=null,$fromname=null,$replyto=null)
  {
    if (!is_null($mensagem)) {
      $texto="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" ";
      $texto.="\"http://www.w3.org/TR/html4/loose.dtd\">\n";
      $texto.="<html>\n";
      $texto.="  <head>\n";
      $texto.="    <title>\n";
      $texto.="      ".$assunto."\n";
      $texto.="    </title>\n";
      $texto.="    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
      $texto.="  </head>\n";
      $texto.="  <body>\n";
      $texto.="  <div style=\"margin: auto; text-align: left; width: 75%; background-color: #fff; ";
      $texto.="border: 0px solid #777; margin-top: 5px; padding: 15px; ";
      $texto.="font: 15px Verdana, Arial, Helvetica, sans-serif; color: #444;\">\n";
      $texto.="    <h3 style=\"border-bottom: 1px solid #000;\">";
      $texto.="      ".$assunto.":";
      $texto.="    </h3>";
      $texto.="    <div style=\"text-align: justify; line-height:150%; margin: 25px; ";
      $texto.="margin-top: 5px; margin-bottom: 5px;\">";
      $texto.=$mensagem;
      $texto.="      <br />";
      $texto.="    </div>";
      $texto.="    <div style=\"border-top: 1px solid #000; color: #000; text-align: center; padding-top: 5px; ";
      $texto.="font-size: 12px;\">\n";
      $texto.="      ".NOME_SITE."\n";
      $texto.="    </div>\n";
      $texto.="    <div style=\"color: #000; text-align: center; font-size: 10px;\">\n";
      $texto.="      ".SITE_URL."\n";
      $texto.="    </div>\n";
      $texto.="  </body>\n";
      $texto.="</html>";
    }
    require_once("./library/components/phpmailer/class.phpmailer.php");
    $mail=new PHPMailer();
    $mail->SetLanguage("br");
    $mail->CharSet="utf-8";
    $mail->WordWrap=50; // Definicao de quebra de linha
    $mail->IsSMTP(); // send via SMTP
    $mail->SMTPAuth=true; // Habilitando a autenticacao
    //$mail->SMTPSecure="ssl"; // Definindo modo SSL
    $mail->Host=SMTP_HOST; //seu servidor SMTP
    $mail->Username=SMTP_USER; // Usuario Autenticador
    $mail->Password=SMTP_PASS; // Senha do usuario (nao usar ou divulgar).
    //$mail->IsMail();
    $mail->SMTPDebug=0;
    $mail->IsHTML(true);
    // Destino
    foreach ($para as $to) {
      $mail->AddAddress($to);
    }
    $mail->From=$from;
    $mail->FromName=$fromname;
    $mail->AddReplyTo($replyto); // Responder para
    $mail->Subject=$assunto;
    $mail->Body=$texto;
    $mail->AltBody=strip_tags($texto);
    if ($mail->Send()) {
      return true;
    } else {
      return false;
    }
  }