<?php
class Listar[TABLE]
{
  private $_results=20; // Resultados por Pagina
  private $_page=null; // Variavel que determina a pagina inicial
  private $_table="[TABLE]"; // Tabela
  private $_sysurl="[lTABLE]"; // URL

  public function listar($gets=array())
  {
    $this->_page=getvar("page");
    $this->_page=is_null($this->_page)?0:(($this->_page-1)*$this->_results);
    $limit=is_null($this->_page)?$this->_results:$this->_results;
    $query=new Doctrine_Query();
    if (!is_null($limit)) {
      $query->from($this->_table.' t')
            ->orderby(1)
            ->limit($limit)
            ->offset($this->_page);
    } else {
      $query->from($this->_table.' t')
            ->orderby(1);
    }
    $registros=$query->execute();
    return $registros;
  }
  public function paginacao()
  {
    $where="true";
    $urlpager=URL_ADM.$this->_sysurl."/home/";
    include_once("./library/components/paginacao.php");
    return $retorno;
  }
}