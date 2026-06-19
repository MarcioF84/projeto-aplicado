<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Usuario_Control extends Control
{

    private object $usuario_dao;

    public function __construct(array $post_request)
    {
        $this->usuario_dao = new Usuario_DAO();
        parent::__construct($post_request, $this->usuario_dao);
    }

    public function Usuario_Gerencia()
    {
        try {
            //CONFIGURE A CONDIÇÃO DE BUSCA  
            $condicao = " and status_usuario = 'A'";
            if (isset($this->post_request['id_usuario'])) {
                $condicao = "and id_usuario = " . $this->post_request['id_usuario'] . "";
            }

            //INICIALIZA A PÁGINA		
            $pagina = isset($this->post_request['pagina']) && $this->post_request['pagina'] > 0 ? $this->post_request['pagina'] : 1;

            //PEGA TOTAL DE REGISTROS
            $total_reg = $this->usuario_dao->get_Total($condicao);

            //CONFIGURE O NUMERO DE REGISTROS POR PAGINA
            $pag_views = 10;

            //CALCULA OS PARAMETROS DE PAGINACAO
            $inicio = ($pagina - 1) * $pag_views;

            //CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
            $ordem = " nome asc";

            $objetos = $this->usuario_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);

            $dataArray = array_map(function ($u) {
                return $u->to_array();
            }, $objetos);

            return [
                "data" => $dataArray,
                "pagination" => [
                    "pagina_atual" => $pagina,
                    "por_pagina" => $pag_views,
                    "total_registros" => $total_reg,
                    "total_paginas" => ceil($total_reg / $pag_views)
                ]
            ];
        } catch (Exception $e) {

            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function Usuario_Add()
    {
        try {
            $obj = new Usuario();

            $obj->set_id_tipo_usuario($this->post_request['id_tipo_usuario']);
            $obj->set_nome($this->post_request['nome']);
            $obj->set_email($this->post_request['email']);
            $obj->set_senha($this->post_request['senha']);
            $obj->set_telefone($this->post_request['telefone']);
            $obj->set_sexo($this->post_request['sexo']);
            $obj->set_bio($this->post_request['bio']);
            $obj->set_data_criacao($this->data->get_dataAtual('BD'));
            $obj->set_status_usuario("A");

            $id_usuario = $this->usuario_dao->Save($obj);

            return [
                "message" => "Usuário criado com sucesso",
                "id_usuario" => $id_usuario
            ];
        } catch (Exception $e) {

            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function Usuario_Alt()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->usuario_dao->load_objeto($this->post_request['id_usuario']);

            $obj->set_id_tipo_usuario($this->post_request['id_tipo_usuario']);
            $obj->set_nome($this->post_request['nome']);
            $obj->set_telefone($this->post_request['telefone']);
            $obj->set_sexo($this->post_request['sexo']);
            $obj->set_bio($this->post_request['bio']);

            $this->usuario_dao->Save($obj);

            return [
                "message" => "Dados alterados com sucesso!"
            ];
        } catch (Exception $e) {

            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function Usuario_Desativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->usuario_dao->load_objeto($this->post_request['id_usuario']);

            $obj->set_status_usuario("D");

            $this->usuario_dao->Save($obj);

            return [
                "message" => "Registro removido com sucesso!"
            ];
        } catch (Exception $e) {

            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function Usuario_Ativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->usuario_dao->load_objeto($this->post_request['id_usuario']);

            $obj->set_status_usuario("A");

            $this->usuario_dao->Save($obj);

            return [
                "message" => "Registro ativado com sucesso!"
            ];
        } catch (Exception $e) {

            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }
}
