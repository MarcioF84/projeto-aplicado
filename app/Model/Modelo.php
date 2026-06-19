<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Modelo
{

    private $id_modelo;
    private $id_marca;
    private $descricao_modelo;
    private $status_modelo;

    public function get_id_modelo()
    {
        return $this->id_modelo;
    }

    public function set_id_modelo($id_modelo)
    {
        $this->id_modelo = $id_modelo;
    }

    public function get_id_marca()
    {
        return $this->id_marca;
    }

    public function set_id_marca($id_marca)
    {
        $this->id_marca = $id_marca;
    }

    public function get_descricao_modelo()
    {
        return $this->descricao_modelo;
    }

    public function set_descricao_modelo(String $descricao_modelo)
    {
        $this->descricao_modelo = $descricao_modelo;
    }

    public function get_status_modelo()
    {
        return $this->status_modelo;
    }

    public function set_status_modelo($status_modelo)
    {
        $this->status_modelo = $status_modelo;
    }

    public function to_array()
    {
        return [
            'id_modelo' => $this->get_id_modelo(),
            'id_marca' => $this->get_id_marca(),
            'descricao_modelo' => $this->get_descricao_modelo(),
            'status_modelo' => $this->get_status_modelo()
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
