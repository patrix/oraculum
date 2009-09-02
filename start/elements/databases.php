<?php include("./elements/load_project.php"); ?>
<h1>Bases de Dados</h1>

    <div class="block">
        <h2>Projetos</h2>
        <?php if (sizeof($projects)>0): ?>
        <ul>
        <?php foreach ($projects as $project): ?>
            <?php if ($projectselected==$project): ?>
                <li style="font-weight:bold;">
            <?php else: ?>
                <li>
            <?php endif; ?>
                <a href="?a=databases&amp;project=<?php echo $project; ?>"><?php echo strtoupper($project); ?></a>
            </li>
        <?php endforeach; ?>
        </ul>
        <?php else: ?>
        Nenhum projeto encontrado!
        <?php endif; ?>
    </div>
    <?php if ($projectselected): ?>
    <div class="block">
        <h3>Database</h3>
        <?php if (file_exists("../models/doctrine/".$projectselected.".php")): ?>
            <?php include("../models/doctrine/".$projectselected.".php"); ?>
                <?php $atualizar=false; ?>
                <ul>
                <?php foreach (Oraculum_Scaffolding::listtables() as $table): ?>
                    <li>
                        <a href="?a=databases&amp;project=<?php echo $project; ?>&amp;table=<?php echo $table; ?>" <?php
                        if (!Oraculum_Scaffolding::verifytable($table, $projectselected)) {
                        	echo "class=\"no\"";$atualizar=true;
                        } ?>>
                            <?php echo $table; ?>
                        </a>

                        <?php if ($tableselected==$table): ?>
                    <ul>
                    <?php foreach (Oraculum_Scaffolding::listfields($tableselected) as $field): ?>
                        <li>
                          <a href="?a=databases&amp;project=<?php echo $project; ?>&amp;table=<?php echo $table;
                          ?>&amp;field=<?php echo $field['name']; ?>">
                            <?php echo $field['name']; ?>
                          </a>
                          <?php if ($fieldselected==$field['name']): ?>
                          <ul>
                          <?php foreach ($field as $key=>$campo): ?>
                              <li>
                                <strong><?php echo $key; ?>:</strong>
                                <?php echo $campo; ?>
                              </li>
                          <?php endforeach; ?>
                          </ul>
                          <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                    </ul>


                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
                </ul>
                <?php
                  if (get("action")=="criar_classes") {
                     include("./elements/actions/generate.php");
                  }
                ?>
                    <div class="msg">
                    <?php if ($atualizar): ?>
                        Voc&ecirc; precisa atualizar as classes referentes ao seu banco de dados.
                    <?php endif; ?>
                    <?php
                        if (Oraculum_Scaffolding::permissao(dirname(__FILE__).
                        "/../../apps/".$projectselected."/models/entidades")): ?>
                        Para gerar as classes clique no link abaixo<br />
                         <a href="?a=databases&amp;project=<?php echo $projectselected; ?>&amp;table=<?php
                         echo $table; ?>&amp;action=criar_classes">
                            Gerar Classes
                         </a>
                    <?php else: ?>
                        Voc&ecirc; precisa ter permiss&atilde;o na pasta
                        <code>../apps/<?php echo $projectselected; ?>/models/entidades</code>
                        para gerar as classes do banco de dados
                    <?php endif; ?>
                    </div>
            <?php else: ?>
              Nenhuma base de dados relacionada ao projeto!<br />
              Copie o arquivo <code>/models/config.php</code> para <code>/models/<?php echo $projectselected; ?>.php</code><br />
              Ent&atilde;o configure na linha 46 os par&acirc;metros de conex&atilde;o com sua base de dados.
            <?php endif; ?>
    </div>
    <?php endif;
