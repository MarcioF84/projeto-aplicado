<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Anexo
{

    private $id_anexo;
    private $id_tipo_anexo;
    private $id_usuario;
    private $data_upload;
    private $arquivo_nome;
    private $arquivoextensao;
    private $status_anexo;

    public function get_id_anexo()
    {
        return $this->id_anexo;
    }

    public function set_id_anexo($id_anexo)
    {
        $this->id_anexo = $id_anexo;
    }

    public function get_id_tipo_anexo()
    {
        return $this->id_tipo_anexo;
    }

    public function set_id_tipo_anexo($id_tipo_anexo)
    {
        $this->id_tipo_anexo = $id_tipo_anexo;
    }

    public function get_id_usuario()
    {
        return $this->id_usuario;
    }

    public function set_id_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function get_data_upload()
    {
        return $this->data_upload;
    }

    public function set_data_upload($data_upload)
    {
        $this->data_upload = $data_upload;
    }

    public function get_arquivo_nome()
    {
        return $this->arquivo_nome;
    }

    public function set_arquivo_nome($arquivo_nome)
    {
        $this->arquivo_nome = $arquivo_nome;
    }

    public function get_arquivoextensao()
    {
        return $this->arquivoextensao;
    }

    public function set_arquivoextensao($arquivoextensao)
    {
        $this->arquivoextensao = $arquivoextensao;
    }

    public function get_status_anexo()
    {
        return $this->status_anexo;
    }

    public function set_status_anexo($status_anexo)
    {
        $this->status_anexo = $status_anexo;
    }

    public function to_array()
    {
        return [
            'id_anexo' => $this->get_id_anexo(),
            'id_tipo_anexo' => $this->get_id_tipo_anexo(),
            'id_usuario' => $this->get_id_usuario(),
            'data_upload' => $this->get_data_upload(),
            'arquivo_nome' => $this->get_arquivo_nome(),
            'arquivoextensao' => $this->get_arquivoextensao(),
            'status_anexo' => $this->get_status_anexo()
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
