<?php
  ob_start();
  include("./library/fs.php");
  include("./elements/views/header.php");
  include("./library/scaffolding.php");
  include("./library/acoes.php");
  /*$projects=Oraculum_Scaffolding::load_projects();
  $projectselected=get("project");
  $projectselected=Oraculum_Scaffolding::validate_project($projectselected);
  $workspaces=Oraculum_Scaffolding::load_workspaces($projectselected);
  $projectinfo=Oraculum_Scaffolding::load_project($projectselected);
  include("criar.php");
  if (is_null($acao)) {
      include("show_info.php");
  }*/
  include("./elements/views/footer.php");