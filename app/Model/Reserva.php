<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Reserva
{

    private $id_reserva;
    private $id_usuario;
    private $id_carona;
    private $qtde_assentos;
    private $data_reserva;
    private $status_reserva;

    public function get_id_reserva()
    {
        return $this->id_reserva;
    }

    public function set_id_reserva($id_reserva)
    {
        $this->id_reserva = $id_reserva;
    }

    public function get_id_usuario()
    {
        return $this->id_usuario;
    }

    public function set_id_usuario(String $id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function get_id_carona()
    {
        return $this->id_carona;
    }

    public function set_id_carona($id_carona)
    {
        $this->id_carona = $id_carona;
    }

    public function get_qtde_assentos()
    {
        return $this->qtde_assentos;
    }

    public function set_qtde_assentos($qtde_assentos)
    {
        $this->qtde_assentos = $qtde_assentos;
    }

    public function get_data_reserva()
    {
        return $this->data_reserva;
    }

    public function set_data_reserva($data_reserva)
    {
        $this->data_reserva = $data_reserva;
    }

    public function get_status_reserva()
    {
        return $this->status_reserva;
    }

    public function set_status_reserva($status_reserva)
    {
        $this->status_reserva = $status_reserva;
    }

    public function to_array()
    {
        return [
            'id_reserva' => $this->get_id_reserva(),
            'id_usuario' => $this->get_id_usuario(),
            'id_carona' => $this->get_id_carona(),
            'qtde_assentos' => $this->get_qtde_assentos(),
            'data_reserva' => $this->get_data_reserva(),
            'status_reserva' => $this->get_status_reserva()
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
