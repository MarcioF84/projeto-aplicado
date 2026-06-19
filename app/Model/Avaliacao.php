<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Avaliacao
{

    private $id_avaliacao;
    private $id_usuario;
    private $id_carona;
    private $pontuacao;
    private $comentario;
    private $data_avaliacao;

    public function get_id_avaliacao()
    {
        return $this->id_avaliacao;
    }

    public function set_id_avaliacao($id_avaliacao)
    {
        $this->id_avaliacao = $id_avaliacao;
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

    public function get_pontuacao()
    {
        return $this->pontuacao;
    }

    public function set_pontuacao($pontuacao)
    {
        $this->pontuacao = $pontuacao;
    }

    public function get_comentario()
    {
        return $this->comentario;
    }

    public function set_comentario($comentario)
    {
        $this->comentario = $comentario;
    }

    public function get_data_avaliacao()
    {
        return $this->data_avaliacao;
    }

    public function set_data_avaliacao($data_avaliacao)
    {
        $this->data_avaliacao = $data_avaliacao;
    }

    public function to_array()
    {
        return [
            'id_avaliacao' => $this->get_id_avaliacao(),
            'id_usuario' => $this->get_id_usuario(),
            'id_carona' => $this->get_id_carona(),
            'pontuacao' => $this->get_pontuacao(),
            'comentario' => $this->get_comentario(),
            'data_avaliacao' => $this->get_data_avaliacao()
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
