<h1>Painel Geral</h1>

<div class="block">
	<h2>Permiss&otilde;es</h2>
	Criar novos projetos:
	<?php
	   echo Oraculum_Scaffolding::permissao("../apps")?
	   "<span class=\"yes\">Sim</span>":"<span class=\"no\">N&atilde;o</span>";
	?>
	<br />
	Armazenar logs:
    <?php
        echo Oraculum_Scaffolding::permissao("../logs")?
        "<span class=\"yes\">Sim</span>":"<span class=\"yes\">N&atilde;o</span>";
    ?>
    <br />
	Armazenar arquivos tempor&aacute;rios:
	<?php
	   echo Oraculum_Scaffolding::permissao("../tmp")?
	   "<span class=\"yes\">Sim</span>":"<span class=\"yes\">N&atilde;o</span>";
	 ?>
	 <br />
</div>

<?php include("./elements/projects.php");