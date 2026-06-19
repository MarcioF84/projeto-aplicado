<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Usuario
{

    private $id_usuario;
    private $id_tipo_usuario;
    private $nome;
    private $email;
    private $senha;
    private $telefone;
    private $sexo;
    private $bio;
    private $data_criacao;
    private $status_usuario;

    public function get_id_usuario()
    {
        return $this->id_usuario;
    }

    public function set_id_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function get_id_tipo_usuario()
    {
        return $this->id_tipo_usuario;
    }

    public function set_id_tipo_usuario($id_tipo_usuario)
    {
        $this->id_tipo_usuario = $id_tipo_usuario;
    }

    public function get_nome()
    {
        return $this->nome;
    }

    public function set_nome(String $nome)
    {
        $this->nome = $nome;
    }

    public function get_email()
    {
        return $this->email;
    }

    public function set_email($email)
    {
        $this->email = $email;
    }

    public function get_senha()
    {
        return $this->senha;
    }

    public function set_senha($senha)
    {
        $this->senha = $senha;
    }

    public function get_telefone()
    {
        return $this->telefone;
    }

    public function set_telefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function get_sexo()
    {
        return $this->sexo;
    }

    public function set_sexo($sexo)
    {
        $this->sexo = $sexo;
    }

    public function get_bio()
    {
        return $this->bio;
    }

    public function set_bio($bio)
    {
        $this->bio = $bio;
    }

    public function get_data_criacao()
    {
        return $this->data_criacao;
    }

    public function set_data_criacao($data_criacao)
    {
        $this->data_criacao = $data_criacao;
    }

    public function get_status_usuario()
    {
        return $this->status_usuario;
    }

    public function set_status_usuario($status_usuario)
    {
        $this->status_usuario = $status_usuario;
    }

    public function to_array()
    {
        return [
            'id_usuario' => $this->get_id_usuario(),
            'id_tipo_usuario' => $this->get_id_tipo_usuario(),
            'nome' => $this->get_nome(),
            'email' => $this->get_email(),
            'telefone' => $this->get_telefone(),
            'sexo' => $this->get_sexo(),
            'bio' => $this->get_bio(),
            'data_criacao' => $this->get_data_criacao(),
            'status_usuario' => $this->get_status_usuario()
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
