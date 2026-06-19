<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class UsuarioFrota
{

    private $id_usuario_frota;
    private $id_usuario;
    private $id_frota;

    public function get_id_usuario_frota()
    {
        return $this->id_usuario_frota;
    }

    public function set_id_usuario_frota($id_usuario_frota)
    {
        $this->id_usuario_frota = $id_usuario_frota;
    }

    public function get_id_usuario()
    {
        return $this->id_usuario;
    }

    public function set_id_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function get_id_frota()
    {
        return $this->id_frota;
    }

    public function set_id_frota(String $id_frota)
    {
        $this->id_frota = $id_frota;
    }


    public function to_array()
    {
        return [
            'id_usuario' => $this->get_id_usuario(),
            'id_frota' => $this->get_id_frota()
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
