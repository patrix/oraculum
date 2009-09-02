<?php
    $crudtable=post("table");
    $crud=post("crud", "h");
  if (($projectselected)&&($crudtable)) {

        $lcrudtable=str_replace("_", "", $crudtable);
        $lcrudtable=strtolower($lcrudtable);
        $ccrudtable=str_replace("_", " ", $crudtable);
        $ccrudtable=ucwords($ccrudtable);
        $ccrudtable=str_replace(" ", "", $ccrudtable);

        $fieldlist=Oraculum_Scaffolding::listfields($crudtable);
        $crudtable=str_replace("_", "", $crudtable);

        $top=file_get_contents("./elements/actions/crud.tpl/top.php");
        $bottom=file_get_contents("./elements/actions/crud.tpl/bottom.php");
        $constanteurl=file_get_contents("./elements/actions/crud.tpl/constante.url.php");

        if (in_array("r", $crud)) {
          /* Retrieve */
          $retrievec=file_get_contents("./elements/actions/crud.tpl/retrieve.php");
          $retrievec=str_replace("[TABLE]", $ccrudtable, $retrievec);
          $retrievec=str_replace("[lTABLE]", $lcrudtable, $retrievec);
          $retrievefilec=dirname(__FILE__)."/../../../apps/";
          $retrievefilec.=$projectselected."/controllers/modulos/".$crudtable."/listar.php";
          if (Oraculum_Scaffolding::savefile($retrievefilec, $retrievec, true)) {
            echo "Controlador de listagens da entidade ".$crudtable." gerado com sucesso<br />\n";
          } else {
            echo "N&atilde;o foi poss&iacute;vel gravar o arquivo ".$retrievefilec."<br />\n";
          }


            $retrievev="<?php if((sizeof(\$ofreturn))>0):    ?>\n";
            $retrievev.="<table>\n";
            $retrievev.="    <tr>\n";
            foreach ($fieldlist as $field) {
              $retrievev.="        <th>\n";
              $retrievev.=ucwords($field['name']);
              $retrievev.="        </th>\n";
            }
            $retrievev.="        <th colspan=\"2\">\n";
            $retrievev.="           A&ccedil;&otilde;es";
            $retrievev.="        </th>\n";
            $retrievev.="  </tr>\n";
            $retrievev.="  <?php foreach (\$ofreturn as \$registro): ?>\n";
            $retrievev.="        <tr>\n";
            foreach ($fieldlist as $field) {
                $retrievev.="        <td>\n";
                $retrievev.="                <?php echo \$registro->".$field['name']."; ?>\n";
                $retrievev.="        </td>\n";
            }
            $retrievev.="            <td>\n";
            $retrievev.="                <a href=\"<?php echo ".$constanteurl."; ?>".$lcrudtable."/editar/";
            $retrievev.="<?php echo \$registro->codigo; ?>\" class=\"btnedit\">\n";
            $retrievev.="                    Editar\n";
            $retrievev.="                </a>\n";
            $retrievev.="            </td>\n";
            $retrievev.="            <td>\n";
            $retrievev.="                <a href=\"<?php echo ".$constanteurl."; ?>".$lcrudtable."/excluir/";
            $retrievev.="<?php echo \$registro->codigo; ?>\" ";
            $retrievev.="onclick=\"if(confirm('Voce tem certeza que deseja excluir este registro?'))";
            $retrievev.="{return true;}else{return false;}\" class=\"btndel\">\n";
            $retrievev.="                    Excluir\n";
            $retrievev.="                </a>\n";
            $retrievev.="            </td>\n";
            $retrievev.="        </tr>\n";
            $retrievev.="   <?php endforeach; ?>\n";
            $retrievev.="</table>\n";
            $retrievev.="<div id=\"paginacao\">\n";
            $retrievev.="   <?php echo \$ofobj->paginacao(); ?>\n";
            $retrievev.="</div>\n";
            $retrievev.="<?php endif; ?>\n";
            $retrievev.="<div id=\"botoes\">\n";
            $retrievev.="  <a href=\"<?php echo ".$constanteurl."; ?>".$lcrudtable."/editar\">Novo</a>\n";
            $retrievev.="</div>\n";
            $retrievev=$top.$retrievev.$bottom;
            $retrievefilev=dirname(__FILE__)."/../../../apps/";
            $retrievefilev.=$projectselected."/views/modulos/".$crudtable."/listar.shtml";
            if (Oraculum_Scaffolding::savefile($retrievefilev, $retrievev, true)) {
                echo "View de listagem da entidade ".$crudtable." gerado com sucesso<br />\n";
            } else {
                echo "N&atilde;o foi poss&iacute;vel gravar o arquivo ".$retrievefilec."<br />\n";
            }
        }
        if (in_array("u", $crud)) {
          /* Update */
            $updatec="<?php\n";
            $updatec.="class Editar".$ccrudtable."\n";
            $updatec.="  {\n";
            $updatec.="    private \$_table=\"".$ccrudtable."\"; // Entidade\n";
            $updatec.="    private \$_sysurl=\"".$lcrudtable."\"; // URL\n";
            $updatec.="    public function editar(\$codigo=null)\n";
            $updatec.="    {\n";
            $updatec.="      \$codigo=(int)getvar(\"editar\");\n";
            $updatec.="      \$table=Doctrine::getTable(\$this->_table);\n";
            $updatec.="      if (\$codigo!=0) {\n";
            $updatec.="        \$registro=\$table->find(\$codigo);\n";
            $updatec.="        if (\$registro) {\n";
            $updatec.="          if (post(\"send\")==\"Alterar\") {\n";

            foreach ($fieldlist as $field) {
            	if (!$field['primary']) {
	            	if ($field['type']=="integer") {
	            	   $updatec.="            \$".$field['name']."=(int)post(\"".$field['name']."\");\n";
	            	} else if ($field['type']=="float") {
	                   $updatec.="            \$".$field['name']."=float(post(\"".$field['name']."\"));\n";
	                } else if (($field['type']=="timestamp")||($field['type']=="date")||($field['type']=="datetime")) {
	                    $updatec.="            \$".$field['name']."=";
	                    $updatec.="Oraculum_Text::data_sql(post(\"".$field['name']."\"), false);\n";
	                } else {
	                    $updatec.="            \$".$field['name']."=post(\"".$field['name']."\");\n";
	                    if ((int)$field['length']>0) { // Truncando string
	                        $updatec.="            \$".$field['name']."=substr(\$".$field['name'].", 0, ";
	                        $updatec.=$field['length'].");\n";
	                    }
	                }
            	}
            }

            $updatec.="            \$erromsg=null;\n";
            foreach ($fieldlist as $field) {
            	if ($field['notnull']) {
		            if ($field['name']=="cpf") {
		                $updatec.="            \$erromsg.=(!Oraculum_Forms::validar(\$".$field['name'].", \"c\", ";
		                $updatec.="true))?\"O campo <strong>".ucwords($field['name'])."</strong> ";
		                $updatec.="precisa ser um CPF v&aacute;lido<br />\":null;\n";
		            } else if ($field['name']=="email") {
		                $updatec.="            \$erromsg.=(!Oraculum_Forms::validar(\$".$field['name'].", \"E\", ";
		                $updatec.="true))?\"O campo <strong>".ucwords($field['name'])."</strong> ";
		                $updatec.="precisa ser um e-mail v&aacute;lido<br />\":null;\n";
		            } else if (($field['type']=="timestamp")||($field['type']=="date")||($field['type']=="datetime")) {
		                $updatec.="            \$erromsg.=(!Oraculum_Forms::validar(\$".$field['name'].", \"d\", ";
                        $updatec.="true))?\"O campo <strong>".ucwords($field['name'])."</strong> ";
                        $updatec.="precisa ser uma data v&aacute;lida<br />\":null;\n";
                    } else if ($field['type']=="integer") {
		                $updatec.="            \$erromsg.=(!Oraculum_Forms::validar(\$".$field['name'].", \"i\", ";
                        $updatec.="true))?\"O campo <strong>".ucwords($field['name'])."</strong> ";
                        $updatec.="precisa ser um n&uacute;mero inteiro<br />\":null;\n";
                    } else if (($field['type']=="decimal")||($field['type']=="float")||
		            ($field['type']=="real")||($field['type']=="double")) {
		                $updatec.="            \$erromsg.=(!Oraculum_Forms::validar(\$".$field['name'].", \"n\", ";
                        $updatec.="true))?\"O campo <strong>".ucwords($field['name'])."</strong> ";
                        $updatec.="precisa ser um n&uacute;mero<br />\":null;\n";
		            } else {
		                $updatec.="            \$erromsg.=(!Oraculum_Forms::validar(\$".$field['name'].", \"s\", ";
                        $updatec.="true))?\"O campo <strong>".ucwords($field['name'])."</strong> ";
                        $updatec.="precisa ser informado<br />\":null;\n";
		            }
            	}
            }

            $updatec.="            if (empty(\$erromsg)) {\n";
            foreach ($fieldlist as $field) {
                $updatec.="                \$registro->".$field['name']."=\$".$field['name'].";\n";
            }

            $updatec.="                \$registro->save();\n";
            $updatec.="                redirect(".$constanteurl.".\$this->_sysurl);\n";
            $updatec.="              } else {\n";
            $updatec.="                \$retorno=new stdClass;\n";
            foreach ($fieldlist as $field) {
            	if (($field['type']=="timestamp")||($field['type']=="date")||($field['type']=="datetime"))
                    $updatec.="                \$retorno->".$field['name']."=data(\$".$field['name'].");\n";
                else
                    $updatec.="                \$retorno->".$field['name']."=\$".$field['name'].";\n";
            }
            $updatec.="                \$retorno->msg=\$erromsg;\n";
            $updatec.="                return \$retorno;\n";
            $updatec.="              }\n";
            $updatec.="          } else if(post(\"send\")==\"Excluir\") {\n";
            $updatec.="              \$registro->delete();\n";
            $updatec.="              redirect(".$constanteurl.".\$this->_sysurl);\n";
            $updatec.="          }\n";
            $updatec.="        }\n";
            $updatec.="        return \$registro;\n";
            $updatec.="      } else if(post(\"send\")==\"Salvar\") {\n";

            foreach ($fieldlist as $field) {
                if (!$field['primary']) {
                    if ($field['type']=="integer") {
                       $updatec.="            \$".$field['name']."=(int)post(\"".$field['name']."\");\n";
                    } else if ($field['type']=="float") {
                       $updatec.="            \$".$field['name']."=float(post(\"".$field['name']."\"));\n";
                    } else if (($field['type']=="timestamp")||($field['type']=="date")||($field['type']=="datetime")) {
                        $updatec.="            \$".$field['name']."=";
                        $updatec.="Oraculum_Text::data_sql(post(\"".$field['name']."\"), false);\n";
                    } else {
                        $updatec.="            \$".$field['name']."=post(\"".$field['name']."\");\n";
                        if ((int)$field['length']>0) { // Truncando string
                            $updatec.="            \$".$field['name']."=substr(\$".$field['name'].", 0, ";
                            $updatec.=$field['length'].");\n";
                        }
                    }
                }
            }

            $updatec.="            \$erromsg=null;\n";
            foreach ($fieldlist as $field) {
                if ($field['notnull']) {
                    if ($field['name']=="cpf") {
                        $updatec.="            \$erromsg.=(!Oraculum_Forms::validar(\$".$field['name'].", \"c\", ";
                        $updatec.="true))?\"O campo <strong>".ucwords($field['name'])."</strong> precisa ser um CPF ";
                        $updatec.="v&aacute;lido<br />\":null;\n";
                    } else if ($field['name']=="email") {
                        $updatec.="            \$erromsg.=(!Oraculum_Forms::validar(\$".$field['name'].", \"E\", ";
                        $updatec.="true))?\"O campo <strong>".ucwords($field['name'])."</strong> precisa ser um ";
                        $updatec.="e-mail v&aacute;lido<br />\":null;\n";
                    } else if (($field['type']=="timestamp")||($field['type']=="date")||($field['type']=="datetime")) {
                        $updatec.="            \$erromsg.=(!Oraculum_Forms::validar(\$".$field['name'].", \"d\", ";
                        $updatec.="true))?\"O campo <strong>".ucwords($field['name'])."</strong> precisa ser uma ";
                        $updatec.="data v&aacute;lida<br />\":null;\n";
                    } else if ($field['type']=="integer") {
                        $updatec.="            \$erromsg.=(!Oraculum_Forms::validar(\$".$field['name'].", \"i\", ";
                        $updatec.="true))?\"O campo <strong>".ucwords($field['name'])."</strong> precisa ser um ";
                        $updatec.="n&uacute;mero inteiro<br />\":null;\n";
                    } else if (($field['type']=="decimal")||($field['type']=="float")||($field['type']=="real")||
                    ($field['type']=="double")) {
                        $updatec.="            \$erromsg.=(!Oraculum_Forms::validar(\$".$field['name'].", \"n\", ";
                        $updatec.="true))?\"O campo <strong>".ucwords($field['name'])."</strong> precisa ser um ";
                        $updatec.="n&uacute;mero<br />\":null;\n";
                    } else {
                        $updatec.="            \$erromsg.=(!Oraculum_Forms::validar(\$".$field['name'].", \"s\", ";
                        $updatec.="true))?\"O campo <strong>".ucwords($field['name'])."</strong> precisa ser ";
                        $updatec.="informado<br />\":null;\n";
                    }
                }
            }

            $updatec.="            if (empty(\$erromsg)) {\n";



            $updatec.="              \$registro=new \$this->_table;\n";
            foreach ($fieldlist as $field) {
                $updatec.="              \$registro->".$field['name']."=post(\"".$field['name']."\");\n";
            }

            $updatec.="              \$registro->save();\n";
            $updatec.="              redirect(".$constanteurl.".\$this->_sysurl);\n";
            $updatec.="            } else {\n";
            $updatec.="              \$retorno=new stdClass;\n";
            foreach ($fieldlist as $field) {
                if (($field['type']=="timestamp")||($field['type']=="date")||($field['type']=="datetime"))
                    $updatec.="              \$retorno->".$field['name']."=data(\$".$field['name'].");\n";
                else
                    $updatec.="              \$retorno->".$field['name']."=\$".$field['name'].";\n";
            }
            $updatec.="              \$retorno->msg=\$erromsg;\n";
            $updatec.="              return \$retorno;\n";
            $updatec.="            }\n";
            $updatec.="          } else {\n";

            foreach ($fieldlist as $field) {
            	$updatec.="            \$retorno->".$field['name']."=null;\n";
            }
            $updatec.="            \$retorno->msg=null;\n";
            $updatec.="            return \$retorno;\n";
            $updatec.="          }\n";
            $updatec.="      }\n";
            $updatec.="}\n";
            $updatefilec=dirname(__FILE__)."/../../../apps/".$projectselected;
            $updatefilec.="/controllers/modulos/".$crudtable."/editar.php";
            if (Oraculum_Scaffolding::savefile($updatefilec, $updatec, true)) {
                echo "View de listagem da entidade ".$crudtable." gerado com sucesso<br />\n";
            } else {
                echo "N&atilde;o foi poss&iacute;vel gravar o arquivo ".$updatefilec."<br />\n";
            }

            $updatev="<?php \$editar=((!is_null(getvar(\"editar\")))?((int)getvar(\"editar\")!=0):false); ?>\n";
            $updatev.="<form method=\"post\" action=\"<?php echo ".$constanteurl."; ?>".$lcrudtable."/editar/";
            $updatev.="<?php echo (\$editar)?((int)\$ofreturn->codigo):null; ?>\" class=\"form\" id=\"editarfrm\">\n";
            $updatev.=" <h2>\n";

            $updatev.="   <?php if (\$editar): ?>\n";
            $updatev.="     <span>Editar ".$ccrudtable."</span>\n";
            $updatev.="   <?php else: ?>\n";
            $updatev.="     <span>Cadastrar ".$ccrudtable."</span>\n";
            $updatev.="   <?php endif; ?>\n";
            $updatev.=" </h2>\n";
            $updatev.=" <fieldset>\n";
            $updatev.="     <?php if (!isset(\$ofreturn->msg)): ?>\n";
            $updatev.="         <p class=\"msg_alert\">Preencha os campos abaixo:</p>\n";
            $updatev.="     <?php else: ?>\n";
            $updatev.="         <p class=\"msg_alert\"><?php echo \$ofreturn->msg; ?></p>\n";
            $updatev.="     <?php endif; ?>\n";
            $updatev.="     <br />\n";
            foreach ($fieldlist as $field) {
	            $updatev.="    <label for=\"".$field['name']."\">\n";
	            $updatev.="      ".ucwords($field['name'])."\n";
	            $updatev.="    </label>\n";
	            if (($field['type']=="string")&&(!isset($field['length']))) {
	            	$updatev.="<textarea name=\"".$field['name']."\" id=\"".$field['name']."\">";
	            	$updatev.="<?php echo \$ofreturn->".$field['name']."; ?>";
	            	$updatev.="</textarea>\n";
	            } else if ($field['type']=="enum") {
	            	if ($field['length']=="1")
                        $updatev.="<select name=\"".$field['name']."\" id=\"".$field['name']."\">\n";
                    else
                        $updatev.="<select name=\"".$field['name']."\" id=\"".$field['name']."\" ";
                        $updatev.="multiple=\"multiple\">\n";
                    foreach ($field['values'] as $value)
                        $updatev.="<option value=\"".$value."\">".$value."</option>\n";
                    $updatev.="</select>\n";
                } else {
		            $updatev.="    <input type=\"text\" name=\"".$field['name']."\" id=\"".$field['name']."\" ";
                        $updatev.="value=\"<?php echo ";
		            if ($field['type']=="integer") {
		               $updatev.="(int)";
		            }
		            $updatev.="\$ofreturn->".$field['name']."; ?>\" maxlength=\"".$field['length']."\" />\n";
	            }
            }
            $updatev.="    <br />\n";
            $updatev.="    <?php if (\$editar): ?>\n";
            $updatev.="      <input type=\"hidden\" name=\"crypt\" id=\"crypt\" value=\"<?php echo ";
            $updatev.="strcrypt((int)\$ofreturn->codigo); ?>\" />\n";
            $updatev.="      <input type=\"submit\" name=\"send\" id=\"alt\" class=\"send\" value=\"Alterar\" />\n";
            $updatev.="      <input type=\"button\" name=\"send\" id=\"del\" class=\"send\" value=\"Excluir\" ";
            $updatev.="onclick=\"if(confirm('Voce tem certeza que deseja excluir este registro?')){";
            $updatev.="document.location.href='<?php echo ".$constanteurl."; ?>".$lcrudtable."/excluir/<?php echo ";
            $updatev.="(int)\$ofreturn->codigo; ?>';}\" /><br />\n";
            $updatev.="      <input type=\"button\" name=\"send\" id=\"new\" class=\"send\" value=\"Novo\" onclick=";
            $updatev.="\"document.location.href='<?php echo ".$constanteurl."; ?>".$lcrudtable."/editar';\" />\n";
            $updatev.="      <input type=\"button\" name=\"send\" id=\"cancel\" class=\"btndel\" value=\"Cancelar\" ";
            $updatev.="onclick=\"document.location.href='<?php echo ".$constanteurl."; ?>".$lcrudtable."';\" />\n";
            $updatev.="    <?php else: ?>\n";
            $updatev.="      <input type=\"submit\" name=\"send\" id=\"new\" class=\"send\" value=\"Salvar\" />\n";
            $updatev.="      <input type=\"button\" name=\"send\" id=\"del\" class=\"send\" value=\"Cancelar\" ";
            $updatev.="onclick=\"document.location.href='<?php echo ".$constanteurl."; ?>".$lcrudtable."';\" />\n";
            $updatev.="    <?php endif; ?>\n";
            $updatev.="  </fieldset>\n";
            $updatev.="</form>\n";
            $updatev.="<br />\n";
            $updatev=$top.$updatev.$bottom;
            $updatefilev=dirname(__FILE__)."/../../../apps/".$projectselected."/views/modulos/";
            $updatefilev.=$crudtable."/editar.shtml";
            if (Oraculum_Scaffolding::savefile($updatefilev, $updatev, true)) {
                echo "View de listagem da entidade ".$crudtable." gerado com sucesso<br />\n";
            } else {
                echo "N&atilde;o foi poss&iacute;vel gravar o arquivo ".$updatefilev."<br />\n";
            }







        }
        if (in_array("d", $crud)) {
            /* Delete */
          $deletec=file_get_contents("./elements/actions/crud.tpl/delete.php");
          $deletec=str_replace("[TABLE]", $ccrudtable, $deletec);
          $deletec=str_replace("[lTABLE]", $lcrudtable, $deletec);
            $deletefilec=dirname(__FILE__)."/../../../apps/".$projectselected."/controllers/modulos/".$crudtable;
            $deletefilec.="/excluir.php";
            if (Oraculum_Scaffolding::savefile($deletefilec, $deletec, true)) {
                echo "Controlador de exclus&atilde;o de registros da entidade ".$crudtable;
                echo " gerado com sucesso<br />\n";
            } else {
                echo "N&atilde;o foi poss&iacute;vel gravar o arquivo ".$retrievefilec."<br />\n";
            }
        }
          /* Home */
          $homec=file_get_contents("./elements/actions/crud.tpl/home.php");
          $homec=str_replace("[TABLE]", $ccrudtable, $homec);
          $homec=str_replace("[lTABLE]", $lcrudtable, $homec);
          $homefilec=dirname(__FILE__)."/../../../apps/".$projectselected;
          $homefilec.="/controllers/modulos/".$crudtable."/home.php";
          if (Oraculum_Scaffolding::savefile($homefilec, $homec, true)) {
            echo "Controlador da p&aacute;gina principal da entidade ".$crudtable." gerado com sucesso<br />\n";
          } else {
            echo "N&atilde;o foi poss&iacute;vel gravar o arquivo ".$homefilec."<br />\n";
          }
          /* Home */
          $homev=file_get_contents("./elements/actions/crud.tpl/home.shtml");
          $homev=str_replace("[TABLE]", $ccrudtable, $homev);
          $homev=str_replace("[lTABLE]", $lcrudtable, $homev);
          $homev=str_replace("[URL]", $constanteurl, $homev);
          $homev=$top.$homev.$bottom;
          $homefilev=dirname(__FILE__)."/../../../apps/".$projectselected."/views/modulos/".$crudtable."/home.shtml";
          if (Oraculum_Scaffolding::savefile($homefilev, $homev, true)) {
            echo "Controlador da p&aacute;gina principal da entidade ".$crudtable." gerado com sucesso<br />\n";
          } else {
            echo "N&atilde;o foi poss&iacute;vel gravar o arquivo ".$homefilev."<br />\n";
          }
  }
