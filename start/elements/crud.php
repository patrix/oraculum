<?php include("./elements/load_project.php"); ?>
<?php
    if (file_exists("../models/doctrine/".$projectselected.".php"))
       include("../models/doctrine/".$projectselected.".php");
    if (post("sendcrud"))
        include("./elements/actions/generate_crud.php");
?>
<h1>CRUD</h1>
<em style="font-size:10px;">Create, Retrieve, Update and Delete</em>

<div class="block">
	<h2>Projetos</h2>
	<?php if (sizeof($projects)>0): ?>
		<ul>
			<?php foreach ($projects as $project): ?>
			<li>
			  <a href="?a=crud&amp;project=<?php echo $project; ?>"><?php echo strtoupper($project); ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
	<?php else: ?>
	   Nenhum projeto encontrado!
	<?php endif; ?>
</div>
<?php if ($projectselected): ?>
<div class="block">
	<h3>Gerador de C&oacute;digos</h3>
	<?php $appdir=dirname(__FILE__)."/../../apps/".$projectselected."/"; ?>
	Permiss&atilde;o para gerar c&oacute;digos do projeto:<br />
	<strong>Controllers: </strong>
	<?php echo Oraculum_Scaffolding::permissao($appdir."controllers")?
	"<span class=\"yes\">Sim</span>":"<span class=\"no\">N&atilde;o</span>"; ?>
	<br />
	<strong>Views: </strong>
	<?php echo Oraculum_Scaffolding::permissao($appdir."views")?
	"<span class=\"yes\">Sim</span>":"<span class=\"no\">N&atilde;o</span>"; ?>

	<?php if ((!Oraculum_Scaffolding::permissao($appdir."controllers"))||
	(!Oraculum_Scaffolding::permissao($appdir."views"))): ?>
	    <br />
	    Voc&ecirc; precisa alterar as permiss&otilde;es das pastas abaixo:<br />
        <?php
			if (!Oraculum_Scaffolding::permissao($appdir."controllers")):
			     echo "<code>./apps/".$projectselected."/controllers</code>\n";
			endif;
			echo "<br />\n";
			if (!Oraculum_Scaffolding::permissao($appdir."views")):
			     echo "<code>./apps/".$projectselected."/views</code>\n";
			endif;
		?>
	<?php else: ?>
	<?php if (class_exists("Doctrine_Manager")): ?>
	   <form method="post" action="?a=crud&amp;project=<?php echo $projectselected; ?>">
	        Entidade:<br />
            <select name="table" id="table">
                <?php $oldtable=null; ?>
                <?php $crudtable=(isset($crudtable))?$crudtable:'null'; ?>
				<?php foreach (Oraculum_Scaffolding::listtables() as $table): ?>
					    <?php if ($oldtable==$crudtable): ?>
						   <option value="<?php echo $table; ?>" selected="selected">
						<?php else: ?>
						   <option value="<?php echo $table; ?>">
	                    <?php endif; ?>
					   <?php echo $table; ?>
					</option>
                    <?php $oldtable=$table; ?>
				<?php endforeach; ?>
            </select>
            <br />
			<select name="crud[]" id="crud" multiple="multiple" style="height:100px;">
				<optgroup label="A&ccedil;&otilde;es">
				<option value="u" selected="selected">Criar (Create) / Atualizar (Update)</option>
				<option value="r" selected="selected">Listar (Retrieve)</option>
				<!--<option value="u">Atualizar (Update)</option>-->
				<option value="d" selected="selected">Excluir (Delete)</option></optgroup>
			</select><br />
			<input type="submit" name="sendcrud" id="sendcrud" value="Executar" />
		</form>
	<?php else: ?>
		Nenhuma base de dados relacionada ao projeto
	<?php endif; ?>
  <?php endif; ?>
</div>
<?php endif;