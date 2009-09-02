<?php
    spl_autoload_register(array("Doctrine", "autoload"));
    //$conn=Doctrine_Manager::connection();
    $dirdb=dirname(__FILE__)."/../../../tmp/db/".$project;
    if (file_exists($dirdb)) {
      Oraculum_Scaffolding::rmdirrec($dirdb);
    }
    mkdir($dirdb);
    if (Doctrine::generateModelsFromDb($dirdb)):
        $dirdbdest=dirname(__FILE__)."/../../../apps/".$project."/models/entidades";
        if (file_exists($dirdbdest)) {
          Oraculum_Scaffolding::rmdirrec($dirdbdest);
        }
        if (rename(dirname(__FILE__)."/../../../tmp/db/".$project, $dirdbdest)):
            echo "Classes geradas com sucesso!";
        else:
            echo "Classes geradas com sucesso!";
            echo "<br />Por&eacute;m n&atilde;o foi poss&iacute;vel move-las para a pasta do projeto";
            echo "<br />Copie o conte&uacute;do da pasta <code>./tmp/db/".$project."</code> para ";
            echo "<code>./apps/".$project."/models/entidades</code>";
        endif;
    else:
            echo "N&atilde;o foi poss&iacute;vel gerar as classes da camada de modelo do projeto!";
    endif;
