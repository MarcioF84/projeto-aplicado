<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Usuario_DAO extends Generic_DAO
{

    public function __construct($factory = 'AF_Bd_Mysql')
    {
        parent::__construct($factory);

        $this->chave = 'id_usuario';
        $this->tabela = 'tb_usuario';
    }

    public function get_descricoes(&$error)
    {

        $desc = array();
        return $desc;
    }
}
