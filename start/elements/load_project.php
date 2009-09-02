<?php
  $projects=Oraculum_Scaffolding::load_projects();
  $projectselected=get("project");
  $workspaceselected=get("workspace");
  $projectselected=Oraculum_Scaffolding::validate_project($projectselected);
  //Oraculum_Scaffolding::allow_project($projectselected); // Verificando permissao
  $workspaces=Oraculum_Scaffolding::load_workspaces($projectselected);
  $projectinfo=Oraculum_Scaffolding::load_project($projectselected);
  $tableselected=get("table");
  $fieldselected=get("field");
  $moduleselected=get("module");
  $pageselected=get("page");
  $c=get("c");