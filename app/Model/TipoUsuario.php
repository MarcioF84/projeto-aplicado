<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class TipoUsuario
{

    private $id_tipo_usuario;
    private $descricao_tipo;
    private $status_tipo;

    public function get_id_tipo_usuario()
    {
        return $this->id_tipo_usuario;
    }

    public function set_id_tipo_usuario($id_tipo_usuario)
    {
        $this->id_tipo_usuario = $id_tipo_usuario;
    }

    public function get_descricao_tipo()
    {
        return $this->descricao_tipo;
    }

    public function set_descricao_tipo(String $descricao_tipo)
    {
        $this->descricao_tipo = $descricao_tipo;
    }

    public function get_status_tipo()
    {
        return $this->status_tipo;
    }

    public function set_status_tipo($status_tipo)
    {
        $this->status_tipo = $status_tipo;
    }

    public function to_array()
    {
        return [
            'id_tipo_usuario' => $this->get_id_tipo_usuario(),
            'descricao_tipo' => $this->get_descricao_tipo(),
            'status_tipo' => $this->get_status_tipo()
        ];
    }

    public function get_all_dados()
    {
        $classe = new ReflectionClass($this);
        $props = $classe->getProperties();
        $props_arr = array();
        foreach ($props as $prop) {
            $valor = null;
            $f = $prop->getName();
            // pra nao voltar a conexao
            if ($f != "conexao") {
                $exec = '$valor = $this->get_' . $f . '();';
                eval($exec);
                $props_arr[$f] = $valor;
            }
        }
        return $props_arr;
    }
}
