<?php include("./elements/load_project.php"); ?>
<?php
    $camada=($c=="c")?"controllers":"views";
    if (post("savefile")) {
    	$dir="../apps/".$projectselected."/".$camada."/modulos/".$moduleselected."/".$pageselected;
    	if (Oraculum_Scaffolding::savefile($dir)) {
    		echo "Arquivo gravado com sucesso!";
    	} else {
            echo "N&atilde;o foi poss&iacute;vel salvar o arquivo!";
    	}
    }
?>


<h1>Editor</h1>
<?php if (($projectselected)&&($moduleselected)&&($c)&&($pageselected)): ?>
<?php
    $dir="../apps/".$projectselected."/".$camada."/modulos/".$moduleselected."/".$pageselected;
    if (!Oraculum_Scaffolding::permissao($dir)):
?>
<span class="no">Sem persmiss&atilde;o para alterar o arquivo</span>
<?php endif; ?>
<form method="post" action="?a=edit_page&amp;project=<?php echo $projectselected; ?>&amp;c=<?php echo $c;
?>&amp;module=<?php echo $moduleselected; ?>&amp;page=<?php echo $pageselected; ?>">
<textarea name="file_content" cols="100" rows="25" class="editor">
<?php
    echo file_get_contents("../apps/".$projectselected."/".$camada."/modulos/".$moduleselected."/".$pageselected);
?>
</textarea>
<input type="submit" name="savefile" id="savefile" value="Salvar">
</form>
<?php endif; ?>
<?php exit; ?>
		<div class="block">
				<h2>Projetos</h2>
				<?php if (sizeof($projects)>0): ?>
				<ul>
				<?php foreach ($projects as $project): ?>
				<li>
				<a href="?a=pages&amp;project=<?php echo $project; ?>"><?php echo strtoupper($project); ?></a>
				</li>
				<?php endforeach; ?>
				</ul>
				<?php else: ?>
				Nenhum projeto encontrado!
				<?php endif; ?>
		</div>
		<?php if ($projectselected): ?>
		<div class="block">
			<h3>M&oacute;dulos (Controladores)</h3>
			<ul>
			    <?php foreach (Oraculum_Scaffolding::load_modulos($projectselected, "c") as $module): ?>
					<li>
						<a href="?a=pages&amp;project=<?php echo $projectselected;
						?>&amp;c=c&amp;module=<?php echo $module; ?>">
						  <?php echo $module; ?>
						</a>
				        <?php if (($moduleselected==$module)&&($c=="c")): ?>
				        <div class="block">
				            <h4>P&aacute;ginas</h4>
				            <ul>
				                <?php foreach (Oraculum_Scaffolding::load_pages($projectselected, "c",
				                $moduleselected) as $page): ?>
				                    <li>
				                        <a href="?a=pages&amp;project=<?php echo $projectselected;
				                        ?>&amp;c=c&amp;module=<?php echo $moduleselected;
				                        ?>&amp;page=<?php echo $page; ?>">
				                          <?php echo $page; ?>
				                        </a>
				                        <?php
				                            if ($pageselected==$page):
				                                Oraculum_Scaffolding::load_page($projectselected, "c",
				                                $moduleselected, $pageselected);
				                            endif;
				                        ?>
				                    </li>
				                <?php endforeach; ?>
				            </ul>
				        </div>
				        <?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
        <div class="block">
            <h3>M&oacute;dulos (Views)</h3>
            <ul>
                <?php foreach (Oraculum_Scaffolding::load_modulos($projectselected, "v") as $module): ?>
                    <li>
                        <a href="?a=pages&amp;project=<?php echo $projectselected;
                        ?>&amp;c=v&amp;module=<?php echo $module; ?>">
                          <?php echo $module; ?>
                        </a>

                        <?php if (($moduleselected==$module)&&($c=="v")): ?>
                        <div class="block">
                            <h4>P&aacute;ginas</h4>
                            <ul>
                                <?php foreach (Oraculum_Scaffolding::load_pages($projectselected, "v",
                                $moduleselected) as $page): ?>
                                    <li>
                                        <a href="?a=pages&amp;project=<?php echo $projectselected;
                                        ?>&amp;c=v&amp;module=<?php echo $moduleselected;
                                        ?>&amp;page=<?php echo $page; ?>">
                                          <?php echo $page; ?>
                                        </a>
                                        <?php
                                            if ($pageselected==$page):
                                                Oraculum_Scaffolding::load_page($projectselected, "v",
                                                $moduleselected, $pageselected);
                                            endif;
                                        ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
		<?php endif;