<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Marca_Control extends Control
{

    private object $marca_dao;

    public function __construct(array $post_request)
    {
        $this->marca_dao = new Marca_DAO();
        parent::__construct($post_request, $this->marca_dao);
    }

    public function Marca_Gerencia()
    {
        try {
            //CONFIGURE A CONDIÇÃO DE BUSCA  
            $condicao = " and status_marca = 'A'";
            if (isset($this->post_request['id_marca'])) {
                $condicao = "and id_marca = " . $this->post_request['id_marca'] . "";
            }

            //INICIALIZA A PÁGINA		
            $pagina = isset($this->post_request['pagina']) && $this->post_request['pagina'] > 0 ? $this->post_request['pagina'] : 1;

            //PEGA TOTAL DE REGISTROS
            $total_reg = $this->marca_dao->get_Total($condicao);

            //CONFIGURE O NUMERO DE REGISTROS POR PAGINA
            $pag_views = 10;

            //CALCULA OS PARAMETROS DE PAGINACAO
            $inicio = ($pagina - 1) * $pag_views;

            //CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
            $ordem = " descricao_marca asc";

            $objetos = $this->marca_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);

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

    public function Marca_Add()
    {
        try {
            $obj = new Marca();

            $obj->set_descricao_marca($this->post_request['descricao_marca']);
            $obj->set_status_marca("A");

            $id_marca = $this->marca_dao->Save($obj);

            return [
                "message" => "Nova marca cadastrada com sucesso",
                "id_marca" => $id_marca
            ];
        } catch (Exception $e) {

            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function Marca_Alt()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->marca_dao->load_objeto($this->post_request['id_marca']);

            $obj->set_descricao_marca($this->post_request['descricao_marca']);

            $this->marca_dao->Save($obj);

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

    public function Marca_Desativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->marca_dao->load_objeto($this->post_request['id_marca']);

            $obj->set_status_marca("D");

            $this->marca_dao->Save($obj);

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

    public function Marca_Ativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->marca_dao->load_objeto($this->post_request['id_marca']);

            $obj->set_status_marca("A");

            $this->marca_dao->Save($obj);

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
