<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Modelo_DAO extends Generic_DAO
{

    public function __construct($factory = 'AF_Bd_Mysql')
    {
        parent::__construct($factory);

        $this->chave = 'id_modelo';
        $this->tabela = 'tb_modelo';
    }

    public function get_descricoes()
    {
        $desc = array();

        $sql = "select * from tb_marca where status_marca = 'A'";
        $result = $this->con->fetch_array($this->con->query($sql));
        foreach ($result as $dados) {
            $desc[$dados['id_marca']] = $dados['descricao_marca'];
        }

        return $desc;
    }
}
