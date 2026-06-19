<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Avaliacao_DAO extends Generic_DAO
{

    public function __construct($factory = 'AF_Bd_Mysql')
    {
        parent::__construct($factory);

        $this->chave = 'id_avaliacao';
        $this->tabela = 'tb_avaliacao';
    }

    public function get_descricoes(&$error)
    {

        $desc = array();
        return $desc;
    }
}
