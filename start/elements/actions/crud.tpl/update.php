<?php
class Editar[TABLE]
{
	private $_table="[TABLE]"; // Tabela
	private $_sysurl="[lTABLE]"; // URL
	public function editar($codigo=null)
	{
		$codigo=getvar("editar");
		$table=Doctrine::getTable($this->_table);
		if ((!is_null($codigo))&&(floor($codigo)!=0)) {
			$registro=$table->find($codigo);
			if ($registro) {
				if (post("send")=="Alterar") {
					$registro->descricao=post("descricao");
					$registro->save();
					redirect(URL.'/'.$this->_sysurl);
				} else if (post("send")=="Excluir") {
					$registro->delete();
					redirect(URL.'/'.$this->_sysurl);
				}
			}
			return $registro;
		} else if (post("send")=="Salvar") {
			$registro=new $this->_table;
			$registro->descricao=post("descricao");
			$registro->save();
			redirect(URL.'/'.$this->_sysurl);
		} else {
			return null;
		}
	}
}