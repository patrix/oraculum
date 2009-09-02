<?php
class Oraculum_Scaffolding
{
    /* Projects */
	public static function load_projects()
	{
		$list=array();
		$ponteiro=opendir("../apps/");
		while ($readprojects=readdir($ponteiro)) {
			$projects[]=$readprojects;
		}
		sort($projects);
		foreach ($projects as $project) {
			if ((strpos($project, "."))===false) {
				if (is_dir("../apps/".$project)) {
					$list[]=$project;
				}
			}
		}
		return $list;
	}
	public static function validate_project($project=null)
	{
		if (!is_null($project)) {
			if (is_dir("../apps/".$project)) {
				return $project;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public static function allow_project($project=null)
	{
		if (!is_null($project)) {
			if (file_exists("../apps/".$project."/config/workspaces/list.php")) {
				include("../apps/".$project."/config/workspaces/list.php");
				$email=$_SERVER['SERVER_ADMIN'];
				if (!isset($workspacelist[$email])) {
					die("Nenhum Workspace configurado para esta esta&ccedil;&atilde;o (<strong>".$email."</strong>).");
				} else {

				$arquivo=$workspacelist[$email];
					if (file_exists("../apps/".$project."/config/workspaces/".$arquivo.".php")) {
						include_once("../apps/".$project."/config/workspaces/".$arquivo.".php");
						$ip=$_SERVER['REMOTE_ADDR'];
						if (($ip!=IP_INT)&&($ip!=IP_EXT)) {
							ob_clean();
							die("Voc&ecirc; n&atilde;o possui permiss&atilde;o para acessar este diret&oacute;rio.");
						}
					}
				}
			}
		}
	}
	public static function load_workspaces($project=null)
	{
		if (!is_null($project)) {
			if (file_exists("../apps/".$project."/config/workspaces/list.php")) {
				include("../apps/".$project."/config/workspaces/list.php");
				return $workspacelist;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public static function load_project($project=null)
	{
		if (!is_null($project)) {
			if (file_exists("../apps/".$project."/config/init.php")) {
				$content=file_get_contents("../apps/".$project."/config/init.php");
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
		public static function criar_projeto($project=null)
		{
				if (Oraculum_Scaffolding::validate_project($project)) {
						return "Este j&aacute; existe!";
				}
		}

		/* Databases */
		public static function permissao($folder)
		{
			if (file_exists($folder)) {
				return is_writable($folder);
			} else {
				return false;
			}
		}
		public function listtables()
		{
				$conn=Doctrine_Manager::connection();
				$tables=$conn->import->listTables();
				return $tables;
		}
		public function verifytable($table, $project)
		{
				$table=str_replace(" ", "", ucwords(preg_replace('/[\s_]+/', ' ', $table)));
				return file_exists("../apps/".$project."/models/entidades/".$table.".php");
		}
		public function listfields($table)
		{
			$conn=Doctrine_Manager::connection();
			$fields=$conn->import->listTableColumns($table);
			return $fields;
		}

		/* Pages */
		public static function load_modulos($project, $camada="c")
		{
			if ($camada=="c") {
					$camada="controllers";
			} else {
					$camada="views";
			}
			$list=array();
			$ponteiro=opendir("../apps/".$project."/".$camada."/modulos");
			while ($readmodulos=readdir($ponteiro)) {
				if ((strpos($readmodulos, "."))===false)
						$list[]=$readmodulos;
			}
			sort($list);
			return $list;
		}

		public static function load_pages($project, $camada="c", $modulo=null)
		{
			if ($camada=="c") {
				$camada="controllers";
			} else {
					$camada="views";
			}
			$list=array();
			$ponteiro=opendir("../apps/".$project."/".$camada."/modulos/".$modulo);
			while ($readpages=readdir($ponteiro)) {
				if (($readpages!=".svn")&&($readpages!="..")&&($readpages!="."))
						$list[]=$readpages;
			}
			sort($list);
			return $list;
		}
		public static function load_page($project, $camada, $module, $page)
		{
			$camadacod=$camada;
			if ($camada=="c") {
				$camada="controllers";
			} else {
					$camada="views";
			}
			$file="../apps/".$project."/".$camada."/modulos/".$module."/".$page;
			if (file_exists($file)) {
				echo "<div class=\"code\">\n";
				echo "<em>\n";
				echo $file;
				echo "</em>\n";
				echo "<a href=\"?a=edit_page&amp;project=".$project."&amp;c=";
				echo $camadacod."&amp;module=".$module."&amp;page=".$page."\">\n";
				echo "Editar\n";
				echo "</a><br />\n";
				highlight_file($file);
				echo "</div>\n";
				return true;
			} else {
				return false;
			}
		}
		public static function savefile($file, $conteudo=null, $new=false)
		{
			if ((post("file_content", "h"))||(!is_null($conteudo))) {
				$conteudo=(is_null($conteudo))?post("file_content", "h"):$conteudo;
				if ((Oraculum_Scaffolding::permissao($file))||($new)) {
					$fp=fopen_recursive($file, "w");
					fwrite($fp, $conteudo);
					fclose($fp);
					return true;
				}
			}
			return false;
		}
		public static function rmdirrec($dir) 
    {
      $dirc=scandir($dir); 
      if ($dirc!==FALSE) {
        foreach ($dirc as $entry) 
        {
          if (!in_array($entry, array('.', '..'))) { 
            $entry=$dir.'/'.$entry;  
            if (!is_dir($entry)) { 
              unlink($entry); 
            } else { 
              Oraculum_Scaffolding::rmdirrec($entry); 
            } 
          } 
        } 
      }
      rmdir($dir); 
    }
}
