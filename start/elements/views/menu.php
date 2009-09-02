<div id="menu" class="vmenu">
	<ul>
	    <li>
	        <a href="?a=geral" <?php if ((get("a")=="geral")||(is_null(get("a")))) {
	        	echo "class=\"selected\"";
} ?>>
	            Painel Geral
	        </a>
	    </li>
	    <li>
	        <a href="?a=databases" <?php if (get("a")=="databases") {
	        	echo "class=\"selected\"";
} ?>>
	            Bases de Dados
	        </a>
	    </li>
        <li>
            <a href="?a=crud" <?php if (get("a")=="crud") {
            	echo "class=\"selected\"";
} ?>>
                CRUD
            </a>
        </li>
	    <li>
	        <a href="?a=pages" <?php if (get("a")=="pages") {
	        	echo "class=\"selected\"";
} ?>>
	            P&aacute;ginas
	        </a>
	    </li>
	</ul>
</div>