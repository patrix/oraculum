<?php
/**
 * Componente de Contato
 *
 *
 *    @filesource
 *    @category       Components
 *    @package        oraculum
 *    @subpackage     oraculum.components.contato
 *    @required       PHPMailer 2.3 ou superior
 */
  $nome=(!isset($nome))?null:$nome;
  $email=(!isset($email))?null:$email;
  $telefone=(!isset($telefone))?null:$telefone;
  $mensagem=(!isset($mensagem))?null:$mensagem;
  $titulo=(!isset($titulo))?"Contato":$titulo;
  $origem=(!isset($origem))?"contato":$origem;
  $msg=null;
  $gatilho=(!isset($this->gatilho))?"send":$this->gatilho;
  if (post($gatilho)) {
    $nome=(!is_null($nome))?$nome:post("nome");
    $email=(!is_null($email))?$email:post("email");
    $telefone=(!is_null($telefone))?$telefone:post("telefone");
    $mensagem=(!is_null($mensagem))?$mensagem:post("mensagem");
    if ((!is_null($nome))&&(!is_null($email))&&(!is_null($mensagem))) {
      if ((isset($_SESSION['contato_of']))&&((time()-$_SESSION['contato_of'])<180)) {
        $msg="Sua mensagem j&aacute; foi enviada,<br />";
        $msg.="aguarde alguns minutos para enviar uma nova mensagem!";
        $msgtype=0;
        $retorno['bloqueio']=true;
      } else {
        $retorno['bloqueio']=false;
        // Verifica se o e-mail e valido
        if (strpos($email, "@")) {
          $e=explode("@", $email); // Transforma o email em array.
          if (count($e)==2) {
            if (strpos($e[1], ".")) {
              $emailhost="www.".@$e[1]; // Gera o dominio do email.
              $iph=@gethostbyname($emailhost); // Verifica o Nome do Servidor
              $iph=@gethostbyaddr($iph); // E o IP
            } else {
              $iph=false;
            }
          } else {
            $iph=false;
          }
        } else {
          $iph=false;
        }
        if ($iph) {
          $texto="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" ";
          $texto.="\"http://www.w3.org/TR/html4/loose.dtd\">\n";
          $texto.="<html>\n";
          $texto.="  <head>\n";
          $texto.="    <title>\n";
          $texto.="      ".$titulo."\n";
          $texto.="    </title>\n";
          $texto.="    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
          $texto.="  </head>\n";
          $texto.="  <body>\n";
          $texto.="  <div style=\"margin: auto; text-align: left; width: 75%; background-color: #fff; ";
          $texto.="border: 0px solid #777; margin-top: 5px; padding: 15px; font: 15px Verdana, Arial, ";
          $texto.="Helvetica, sans-serif; color: #444;\">\n";
          $texto.="    <h3 style=\"border-bottom: 1px solid #000;\">";
          $texto.="      ".$titulo.":";
          $texto.="    </h3>";
          $texto.="    <div style=\"text-align: justify; line-height:150%; margin: 25px; ";
          $texto.="margin-top: 5px; margin-bottom: 5px;\">";
          if ($origem=="sistema") {
            $texto.="      <br />".$mensagem."<br /><br />";
            $texto.="      <strong>Data:</strong> ".date('d/m/Y H:i:s')."<br />";
            $texto.="      <strong>IP:</strong> ".ip()." (".host().")<br />";
          } else {
            $texto.="      <strong>Nome:</strong> ".$nome."<br />";
            $texto.="      <strong>E-mail:</strong> ".$email."<br />";
            $texto.="      <strong>Data:</strong> ".date('d/m/Y H:i:s')."<br />";
            $texto.="      <strong>Mensagem:</strong><br />".$mensagem."<br />";
            $texto.="      <strong>IP:</strong> ".ip()." (".host().")<br />";
          }
          $texto.="      <br />";
          $texto.="    </div>";
          $texto.="    <div style=\"border-top: 1px solid #000; color: #000; text-align: center; ";
          $texto.="padding-top: 5px;font-size: 12px;\">\n";
          $texto.="      ".NOME_SITE."\n";
          $texto.="    </div>\n";
          $texto.="    <div style=\"color: #000; text-align: center; font-size: 10px;\">\n";
          $texto.="      ".SITE_URL."\n";
          $texto.="    </div>\n";
          $texto.="  </body>\n";
          $texto.="</html>";

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
          foreach ($this->destino as $to) {
            $mail->AddAddress($to);
          }
          $mail->From=$this->from;
          $mail->FromName=$this->fromname;
          $mail->AddReplyTo($this->replyto); // Responder para
          $mail->Subject=$this->subject;
          $mail->Body=$texto;
          $mail->AltBody=strip_tags($texto);

          if ((isset($arquivo))&&(!is_null($arquivo))) {
	          if (is_uploaded_file($arquivo['tmp_name'])) {
	            $mail->AddAttachment($arquivo['tmp_name'], $arquivo['name']);
	          }
          }

          if ($mail->Send()) {
            $msg="Mensagem enviada com sucesso!";
            $msgtype=1;
            $nome="";
            $email="";
            $telefone="";
            $assunto="";
            $mensagem="";
            $_SESSION['contato_of']=time();
          } else {
            $msg="Ocorreu algum problema ao enviar a mensagem!";
            $msg.="<br />Se desejar entre em contato diretamente com:<br /> ";
            $msg.="webmaster<img src=\"./layout/".PROJECT."/img/ico/a.jpg\">".$this->dominio;
            $msgtype=0;
          }
        } else {
          $msg="O e-mail informado n&atilde;o &eacute; um e-mail v&aacute;lido\n";
          $msgtype=0;
        }
      }
    } else {
      $retorno['bloqueio']=false;
      $msg="Voc&ecirc; deixou algum campo em branco!";
      $msgtype=0;
    }
  }
  if (!is_null($msg)) {
    if ($msgtype==0) {
      $msg="style=\"vertical-align: middle;\">\n".$msg;
      $msg="<img src=\"./layout/".PROJECT."/img/ico/alert.gif\" alt=\"Mensagem\" title=\"Mensagem\" ".$msg;
    } else if ($msgtype==1) {
      $msg="style=\"vertical-align: middle;\">\n".$msg;
      $msg="<img src=\"./layout/".PROJECT."/img/ico/sucesso.gif\" alt=\"Mensagem\" title=\"Mensagem\" ".$msg;
    }
  } else {
    $msg="Utilize o formul&aacute;rio abaixo para entrar em contato conosco.";
  }

  $msg="<p id=\"msg_contato\">\n".$msg."\n</p>\n";
  $retorno['nome']=$nome;
  $retorno['email']=$email;
  $retorno['mensagem']=$mensagem;
  $retorno['telefone']=$telefone;
  $retorno['msg']=$msg;
  $retorno['status']=$msgtype;