<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Carona
{

    private $id_carona;
    private $id_frota;
    private $id_endereco_origem;
    private $id_endereco_destino;
    private $data_partida;
    private $hora_partida;
    private $valor_carona;
    private $qtde_assento;
    private $status_carona;

    public function get_id_carona()
    {
        return $this->id_carona;
    }

    public function set_id_carona($id_carona)
    {
        $this->id_carona = $id_carona;
    }

    public function get_id_frota()
    {
        return $this->id_frota;
    }

    public function set_id_frota(String $id_frota)
    {
        $this->id_frota = $id_frota;
    }

    public function get_id_endereco_origem()
    {
        return $this->id_endereco_origem;
    }

    public function set_id_endereco_origem($id_endereco_origem)
    {
        $this->id_endereco_origem = $id_endereco_origem;
    }

    public function get_id_endereco_destino()
    {
        return $this->id_endereco_destino;
    }

    public function set_id_endereco_destino($id_endereco_destino)
    {
        $this->id_endereco_destino = $id_endereco_destino;
    }

    public function get_data_partida()
    {
        return $this->data_partida;
    }

    public function set_data_partida($data_partida)
    {
        $this->data_partida = $data_partida;
    }

    public function get_hora_partida()
    {
        return $this->hora_partida;
    }

    public function set_hora_partida($hora_partida)
    {
        $this->hora_partida = $hora_partida;
    }

    public function get_valor_carona()
    {
        return $this->valor_carona;
    }

    public function set_valor_carona($valor_carona)
    {
        $this->valor_carona = $valor_carona;
    }

    public function get_qtde_assento()
    {
        return $this->qtde_assento;
    }

    public function set_qtde_assento($qtde_assento)
    {
        $this->qtde_assento = $qtde_assento;
    }

    public function get_status_carona()
    {
        return $this->status_carona;
    }

    public function set_status_carona($status_carona)
    {
        $this->status_carona = $status_carona;
    }

    public function to_array()
    {
        $data = new Data();

        return [
            'id_carona' => $this->get_id_carona(),
            'id_frota' => $this->get_id_frota(),
            'id_endereco_origem' => $this->get_id_endereco_origem(),
            'id_endereco_destino' => $this->get_id_endereco_destino(),
            'data_partida' => $data->get_formatData($this->get_data_partida(), "DMA"),
            'hora_partida' => $data->get_formatHora($this->get_hora_partida(), "HM"),
            'valor_carona' => $this->get_valor_carona(),
            'qtde_assento' => $this->get_qtde_assento(),
            'status_carona' => $this->get_status_carona()
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
