<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class TipoUsuario_Control extends Control
{

    private object $tipo_usuario_dao;

    public function __construct(array $post_request)
    {
        $this->tipo_usuario_dao = new TipoUsuario_DAO();
        parent::__construct($post_request, $this->tipo_usuario_dao);
    }

    public function TipoUsuario_Gerencia()
    {
        try {
            //CONFIGURE A CONDIÇÃO DE BUSCA  
            $condicao = " and status_tipo = 'A'";
            if (isset($this->post_request['id_tipo_usuario'])) {
                $condicao = "and id_tipo_usuario = " . $this->post_request['id_tipo_usuario'] . "";
            }

            //INICIALIZA A PÁGINA		
            $pagina = isset($this->post_request['pagina']) && $this->post_request['pagina'] > 0 ? $this->post_request['pagina'] : 1;

            //PEGA TOTAL DE REGISTROS
            $total_reg = $this->tipo_usuario_dao->get_Total($condicao);

            //CONFIGURE O NUMERO DE REGISTROS POR PAGINA
            $pag_views = 10;

            //CALCULA OS PARAMETROS DE PAGINACAO
            $inicio = ($pagina - 1) * $pag_views;

            //CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
            $ordem = " descricao_tipo asc";

            $objetos = $this->tipo_usuario_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);

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

    public function TipoUsuario_Add()
    {
        try {
            $obj = new TipoUsuario();

            $obj->set_descricao_tipo($this->post_request['descricao_tipo']);
            $obj->set_status_tipo("A");

            $id_tipo_usuario = $this->tipo_usuario_dao->Save($obj);

            return [
                "message" => "Novo tipo de usuário criado com sucesso",
                "id_tipo_usuario" => $id_tipo_usuario
            ];
        } catch (Exception $e) {

            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function TipoUsuario_Alt()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->tipo_usuario_dao->load_objeto($this->post_request['id_tipo_usuario']);

            $obj->set_descricao_tipo($this->post_request['descricao_tipo']);

            $this->tipo_usuario_dao->Save($obj);

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

    public function TipoUsuario_Desativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->tipo_usuario_dao->load_objeto($this->post_request['id_tipo_usuario']);

            $obj->set_status_tipo("D");

            $this->tipo_usuario_dao->Save($obj);

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

    public function TipoUsuario_Ativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->tipo_usuario_dao->load_objeto($this->post_request['id_tipo_usuario']);

            $obj->set_status_tipo("A");

            $this->tipo_usuario_dao->Save($obj);

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
