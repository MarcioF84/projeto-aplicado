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

    public function load_data($condicao) {

        $sql = "select U.*
                from {$this->tabela} as U
                left join tb_usuario_frota as UF on UF.id_usuario = U.id_usuario
                where 1 = 1 {$condicao}";  		
                
        $result = $this->con->fetch_array($this->con->query($sql), MYSQLI_ASSOC);
		
		return ($result != NULL) ? $result[0] : NULL;
    }

    public function get_descricoes(&$error)
    {
        $desc = array();
        return $desc;
    }
}
