<?php
  function load_workspace()
  {
    include("list.php");
    $workspace=(isset($workspacelist[$_SERVER['SERVER_ADMIN']])?$workspacelist[$_SERVER['SERVER_ADMIN']]:'arquivo');
    if (file_exists(DIR_SERVER."apps/".PROJECT."/config/workspaces/".$workspace.".php")) {
      include(DIR_SERVER."apps/".PROJECT."/config/workspaces/".$workspace.".php");
    }
  }
  load_workspace();
