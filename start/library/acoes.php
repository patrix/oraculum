<?php
  if (post("send")=="Criar Projeto") {
      $acao="criar_projeto";
  } else {
  	if (!is_null(get("a"))) {
        $acao=get("a");
  	} else {
        $acao=null;

  	}
  }
  switch ($acao) {
  	case "geral":
  		include("./elements/geral.php");
        break;
    case "databases":
        include("./elements/databases.php");
        break;
    case "pages":
        include("./elements/pages.php");
        break;
    case "edit_page":
        include("./elements/edit_page.php");
        break;
    case "crud":
        include("./elements/crud.php");
        break;
  	default:
        include("./elements/geral.php");
        break;
  }