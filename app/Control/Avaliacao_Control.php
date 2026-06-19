<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Avaliacao_Control extends Control
{

    private object $avaliacao_dao;

    public function __construct(array $post_request)
    {
        $this->avaliacao_dao = new Avaliacao_DAO();
        parent::__construct($post_request, $this->avaliacao_dao);
    }

    public function Avaliacao_Gerencia()
    {
        try {
            //CONFIGURE A CONDIÇÃO DE BUSCA  
            $condicao = " ";
            if (isset($this->post_request['id_avaliacao'])) {
                $condicao = "and id_avaliacao = " . $this->post_request['id_avaliacao'] . "";
            }

            //INICIALIZA A PÁGINA		
            $pagina = isset($this->post_request['pagina']) && $this->post_request['pagina'] > 0 ? $this->post_request['pagina'] : 1;

            //PEGA TOTAL DE REGISTROS
            $total_reg = $this->avaliacao_dao->get_Total($condicao);

            //CONFIGURE O NUMERO DE REGISTROS POR PAGINA
            $pag_views = 10;

            //CALCULA OS PARAMETROS DE PAGINACAO
            $inicio = ($pagina - 1) * $pag_views;

            //CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
            $ordem = " id_avaliacao asc";

            $objetos = $this->avaliacao_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);

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

    public function Avaliacao_Add()
    {
        try {
            $obj = new Avaliacao();

            $obj->set_id_usuario($this->post_request['id_usuario']);
            $obj->set_id_carona($this->post_request['id_carona']);
            $obj->set_pontuacao($this->post_request['pontuacao']);
            $obj->set_comentario($this->post_request['comentario']);
            $obj->set_data_avaliacao($this->post_request['data_avaliacao']);

            $id_avaliacao = $this->avaliacao_dao->Save($obj);

            return [
                "message" => "Nova avaliação cadastrada com sucesso",
                "id_avaliacao" => $id_avaliacao
            ];
        } catch (Exception $e) {

            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function Avaliacao_Alt()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->avaliacao_dao->load_objeto($this->post_request['id_avaliacao']);

            $obj->set_comentario($this->post_request['comentario']);

            $this->avaliacao_dao->Save($obj);

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

    public function Avaliacao_Desativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->avaliacao_dao->load_objeto($this->post_request['id_avaliacao']);

            $obj->set_status_carona("D");

            $this->avaliacao_dao->Save($obj);

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

    public function Avaliacao_Ativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->avaliacao_dao->load_objeto($this->post_request['id_avaliacao']);

            $obj->set_status_carona("A");

            $this->avaliacao_dao->Save($obj);

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
