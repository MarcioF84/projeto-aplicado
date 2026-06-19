<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Endereco
{

    private $id_endereco;
    private $cep;
    private $rua;
    private $cidade;
    private $bairro;
    private $estado;
    private $latitude;
    private $longitude;
    private $status_endereco;

    public function get_id_endereco()
    {
        return $this->id_endereco;
    }

    public function set_id_endereco($id_endereco)
    {
        $this->id_endereco = $id_endereco;
    }

    public function get_cep()
    {
        return $this->cep;
    }

    public function set_cep(String $cep)
    {
        $this->cep = $cep;
    }

    public function get_rua()
    {
        return $this->rua;
    }

    public function set_rua(String $rua)
    {
        $this->rua = $rua;
    }

    public function get_cidade()
    {
        return $this->cidade;
    }

    public function set_cidade($cidade)
    {
        $this->cidade = $cidade;
    }

    public function get_bairro()
    {
        return $this->bairro;
    }

    public function set_bairro($bairro)
    {
        $this->bairro = $bairro;
    }

    public function get_estado()
    {
        return $this->estado;
    }

    public function set_estado($estado)
    {
        $this->estado = $estado;
    }

    public function get_latitude()
    {
        return $this->latitude;
    }

    public function set_latitude($latitude)
    {
        $this->latitude = $latitude;
    }

    public function get_longitude()
    {
        return $this->longitude;
    }

    public function set_longitude($longitude)
    {
        $this->longitude = $longitude;
    }

    public function get_status_endereco()
    {
        return $this->status_endereco;
    }

    public function set_status_endereco($status_endereco)
    {
        $this->status_endereco = $status_endereco;
    }

    public function to_array()
    {
        return [
            'id_endereco' => $this->get_id_endereco(),
            'cep' => $this->get_cep(),
            'rua' => $this->get_rua(),
            'cidade' => $this->get_cidade(),
            'bairro' => $this->get_bairro(),
            'estado' => $this->get_estado(),
            'latitude' => $this->get_latitude(),
            'longitude' => $this->get_longitude(),
            'status_endereco' => $this->get_status_endereco()
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
