<?php
class Excluir[TABLE]
{
    private $_codigo=null;
    private $_table="[TABLE]";

    public function excluir($gets=array())
    {
        $this->_codigo=Oraculum_Request::getlast();
        $table=Doctrine::getTable($this->_table);
        if ((!is_null($this->_codigo))&&(floor($this->_codigo)!=0)) {
            $registro=$table->find($this->_codigo);
            if ($registro) {
                $registro->delete();
                Oraculum_HTTP::redirect(BASE_URL."[lTABLE]/listar");
                return true;
            } else {
                Oraculum_HTTP::redirect(BASE_URL."[lTABLE]/listar");
                return false;
            }
        } else {
            Oraculum_HTTP::redirect(BASE_URL."[lTABLE]/listar");
            return false;
        }
    }
}