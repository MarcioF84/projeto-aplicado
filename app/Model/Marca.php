<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Marca
{

    private $id_marca;
    private $descricao_marca;
    private $status_marca;

    public function get_id_marca()
    {
        return $this->id_marca;
    }

    public function set_id_marca($id_marca)
    {
        $this->id_marca = $id_marca;
    }

    public function get_descricao_marca()
    {
        return $this->descricao_marca;
    }

    public function set_descricao_marca(String $descricao_marca)
    {
        $this->descricao_marca = $descricao_marca;
    }

    public function get_status_marca()
    {
        return $this->status_marca;
    }

    public function set_status_marca($status_marca)
    {
        $this->status_marca = $status_marca;
    }

    public function to_array()
    {
        return [
            'id_marca' => $this->get_id_marca(),
            'descricao_marca' => $this->get_descricao_marca(),
            'status_marca' => $this->get_status_marca()
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
