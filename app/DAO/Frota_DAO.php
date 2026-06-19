<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Frota_DAO extends Generic_DAO
{

    public function __construct($factory = 'AF_Bd_Mysql')
    {
        parent::__construct($factory);

        $this->chave = 'id_frota';
        $this->tabela = 'tb_frota';
    }

    public function get_descricoes(&$error)
    {

        $desc = array();
        return $desc;
    }
}
