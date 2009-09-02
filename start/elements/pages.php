<?php include("./elements/load_project.php"); ?>
<h1>P&aacute;ginas</h1>

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
		                        ?>&amp;c=c&amp;module=<?php echo $moduleselected; ?>&amp;page=<?php echo $page; ?>">
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
                                        ?>&amp;c=v&amp;module=<?php echo $moduleselected; ?>&amp;page=<?php
                                        echo $page; ?>">
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