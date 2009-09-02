<?php if ($acao=="criar_projeto"): ?>
    <?php $criarprojeto=post("project"); ?>
    <?php if (Oraculum_Scaffolding::validate_project($criarprojeto)): ?>
        Este j&aacute; existe!
    <?php else: ?>
    <form method="post" action="?">
        <label for="">
            Projeto
        </label>
        <br />
        <input type="text" name="project" id="project" value="<?php echo $criarprojeto; ?>" />
        <br />

        <label for="">
            Diret&oacute;rio do Servidor
        </label>
        <br />
        <input type="text" name="dir_server" id="dir_server" value="<?php echo dirname(__FILE__)."/../"; ?>" />
        <br />

        <label for="">
            Banco de Dados
        </label>
        <br />
	    <select name="db_type" id="db_type">
	        <option value="nenhum">Nenhum</option>
	        <option value="mysql">MySQL</option>
	    </select>
        <br />

        <label for="">
            Servidor
        </label>
        <br />
        <input type="text" name="db_host" id="db_host" value="localhost" />
        <br />

        <label for="">
            Usu&aacute;rio
        </label>
        <br />
        <input type="text" name="db_user" id="db_host" value="" />
        <br />

        <label for="">
            Senha
        </label>
        <br />
        <input type="password" name="db_pass" id="db_host" value="" />
        <br />

        <input type="submit" name="send" id="send" value="Criar" />
    </form>
    <?php endif; ?>
<?php else: ?>
	<form method="post" action="?">
	<input type="text" name="project" id="project" />
	<input type="submit" name="send" id="send" value="Criar Projeto" />
	</form>
<?php endif; ?>
<?php
