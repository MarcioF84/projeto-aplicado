<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Frota
{

    private $id_frota;
    private $id_modelo;
    private $placa;
    private $cor;
    private $data_criacao;
    private $status_frota;

    public function get_id_frota()
    {
        return $this->id_frota;
    }

    public function set_id_frota($id_frota)
    {
        $this->id_frota = $id_frota;
    }

    public function get_id_modelo()
    {
        return $this->id_modelo;
    }

    public function set_id_modelo($id_modelo)
    {
        $this->id_modelo = $id_modelo;
    }

    public function get_placa()
    {
        return $this->placa;
    }

    public function set_placa($placa)
    {
        $this->placa = $placa;
    }

    public function get_cor()
    {
        return $this->cor;
    }

    public function set_cor($cor)
    {
        $this->cor = $cor;
    }

    public function get_data_criacao()
    {
        return $this->data_criacao;
    }

    public function set_data_criacao($data_criacao)
    {
        $this->data_criacao = $data_criacao;
    }

    public function get_status_frota()
    {
        return $this->status_frota;
    }

    public function set_status_frota($status_frota)
    {
        $this->status_frota = $status_frota;
    }

    public function to_array()
    {
        return [
            'id_frota' => $this->get_id_frota(),
            'id_modelo' => $this->get_id_modelo(),
            'placa' => $this->get_placa(),
            'cor' => $this->get_cor(),
            'data_criacao' => $this->get_data_criacao(),
            'status_frota' => $this->get_status_frota()

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
