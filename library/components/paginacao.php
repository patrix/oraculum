<?php
/**
 * Componente de Paginacao
 *
 *
 *    @filesource
 *    @category       Components
 *    @package        oraculum
 *    @subpackage     oraculum.components.paginacao
 *    @required       Doctrine 1.0.6 ou superior
 */
  $retorno=null;
  if (isset($this->_table)) {
    // Metodo de paginacao
    $page=((isset($this->_page))?((floor($this->_page)>0)?(floor($this->_page)):1):1);
    $results=((isset($this->_results))?((floor($this->_results)>0)?(floor($this->_results)):10):10);
    $urlpager=(isset($urlpager))?$urlpager:(BASE_URL."/".strtolower($this->_table));
    if (!is_null($results)) {
      $where=((isset($where))?$where:null);
      if (!is_null($where)) {
        $pagerlayout=new Doctrine_Pager_Layout(
                      new Doctrine_Pager(Doctrine_Query::create()
                                            ->from($this->_table.' t')
                                            ->where($where)
                                            ->orderby('1'), $page, $results),
                      new Doctrine_Pager_Range_Sliding(array('chunk'=>5)), $urlpager.'page/{%page_number}');
      } else {
        $pagerlayout=new Doctrine_Pager_Layout(
                      new Doctrine_Pager(Doctrine_Query::create()
                                            ->from($this->_table.' t')
                                            ->orderby('1'), $page, $results),
                      new Doctrine_Pager_Range_Sliding(array('chunk'=>5)), $urlpager.'page/{%page_number}');
      }
      $pagerlayout->setTemplate('<a href="{%url}">{%page}</a>');
      $pagerlayout->setSelectedTemplate('<span>{%page}</span>');
      $pager=$pagerlayout->getPager();
      $users=$pager->execute();
      if ($pager->haveToPaginate()) {
        $retorno.="<div>\n";
        if ($pager->getFirstPage()!=$pager->getPage()) {
          $retorno.="<a href=\"".$urlpager."page/".$pager->getFirstPage()."\" class=\"btnxt\">&lt;&lt;</a>";
        } else {
          $retorno.="<span class=\"disabled\">&lt;&lt;</span>";
        }
        if ($pager->getPreviousPage()!=$pager->getPage()) {
          $retorno.="<a href=\"".$urlpager."page/".$pager->getPreviousPage()."\" class=\"btnxt\">&lt;</a>";
        } else {
          $retorno.="<span class=\"disabled\">&lt;</span>";
        }
        $retorno.=$pagerlayout->display(array(), true);
        if ($pager->getNextPage()!=$pager->getPage()) {
          $retorno.="<a href=\"".$urlpager."page/".$pager->getNextPage()."\" class=\"btnxt\">&gt;</a>";
        } else {
          $retorno.="<span class=\"disabled\">&gt;</span>";
        }
        if ($pager->getLastPage()!=$pager->getPage()) {
          $retorno.="<a href=\"".$urlpager."page/".$pager->getLastPage()."\" class=\"btnxt\">&gt;&gt;</a>";
        } else {
          $retorno.="<span class=\"disabled\">&gt;&gt;</span>";
        }
        $retorno.="</div>\n";
      }
    }
  }