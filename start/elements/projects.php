<?php include("./elements/load_project.php"); ?>
    <div class="block">
        <h2>Projetos</h2>
        <?php if (sizeof($projects)>0): ?>
        <ul>
        <?php foreach ($projects as $project): ?>
        <li>
        <a href="?a=geral&amp;project=<?php echo $project; ?>"><?php echo strtoupper($project); ?></a>
        </li>
        <?php endforeach; ?>
        </ul>
        <?php else: ?>
        Nenhum projeto encontrado!
        <?php endif; ?>
    </div>
    <?php if (false): ?>
        <div class="block">
            <h2>Project: <?php echo $projectselected; ?> </h2>
            <strong>Nome do projeto:</strong> <?php echo PROJECT; ?><br />
            <strong>Diretorio do servidor:</strong> <?php echo DIR_SERVER; ?><br />
            <strong>Diretorio de logs:</strong> <?php echo DIR_LOGS; ?><br />
            <strong>Diretorio temporario/secoes:</strong> <?php echo DIR_TMP; ?><br />
            <strong>Servidor SMTP:</strong> <?php echo SMTP_HOST; ?><br />
            <strong>Usu&aacute;rio SMTP:</strong> <?php echo SMTP_USER; ?><br />
            <strong>Senha SMPT:</strong> ******<br />
            <strong>Idioma:</strong> <?php echo LANG; ?><br />
        </div>
    <?php endif; ?>

    <?php if ($projectselected): ?>
    <div class="block">
        <h2>Workspaces</h2>
        <?php if (sizeof($workspaces)>0): ?>
        <ul>
        <?php foreach ($workspaces as $workspacemail=>$workspace): ?>
        <li>
        <a href="?a=geral&amp;project=<?php echo $projectselected; ?>&amp;workspace=<?php echo $workspace;
        ?>"><?php echo ucwords($workspace); ?></a>
        (<?php echo $workspacemail; ?>)
        <?php if ($workspaceselected): ?>
            <div style="border:1px solid #aaa;">
                <?php highlight_file("../apps/".$projectselected."/config/workspaces/".$workspaceselected.".php"); ?>
            </div>
        <?php endif; ?>
        </li>
        <?php endforeach; ?>
        </ul>
        <?php else: ?>
        Nenhum workspace encontrado!
        <?php endif; ?>
    </div>
    <?php endif; ?>
<?php
