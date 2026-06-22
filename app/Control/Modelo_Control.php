<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Modelo_Control extends Control
{

    private object $modelo_dao;
    private object $marca_control;

    public function __construct(array $post_request)
    {
        $this->modelo_dao = new Modelo_DAO();
        $this->marca_control = new Marca_Control($post_request);

        parent::__construct($post_request, $this->modelo_dao);
    }

    public function Modelo_Gerencia($busca = null)
    {
        try {
            //CONFIGURE A CONDIÇÃO DE BUSCA  
            $condicao = " and status_modelo = 'A'";
            if ($busca != null) {
                $condicao .= $busca;
            }
            
            //INICIALIZA A PÁGINA		
            $pagina = isset($this->post_request['pagina']) && $this->post_request['pagina'] > 0 ? $this->post_request['pagina'] : 1;

            //PEGA TOTAL DE REGISTROS
            $total_reg = $this->modelo_dao->get_Total($condicao);

            //CONFIGURE O NUMERO DE REGISTROS POR PAGINA
            $pag_views = 10;

            //CALCULA OS PARAMETROS DE PAGINACAO
            $inicio = ($pagina - 1) * $pag_views;

            //CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
            $ordem = " descricao_modelo asc";

            $objetos = $this->modelo_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
            $objMarca = $this->marca_control->Marca_Gerencia(" and id_marca = " . $objetos[0]->get_id_marca());

            $dataArray = array_map(function ($u) use ($objMarca) {
                $item = $u->to_array();
                $item['marca'] = $objMarca['data'][0] ?? null;
                return $item;
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

    public function Modelo_Add()
    {
        try {
            $obj = new Modelo();

            $obj->set_descricao_modelo($this->post_request['descricao_modelo']);
            $obj->set_status_modelo("A");

            $id_modelo = $this->modelo_dao->Save($obj);

            return [
                "message" => "Novo modelo cadastrado com sucesso",
                "id_modelo" => $id_modelo
            ];
        } catch (Exception $e) {

            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function Modelo_Alt()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->modelo_dao->load_objeto($this->post_request['id_modelo']);

            $obj->set_descricao_modelo($this->post_request['descricao_modelo']);

            $this->modelo_dao->Save($obj);

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

    public function Modelo_Desativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->modelo_dao->load_objeto($this->post_request['id_modelo']);

            $obj->set_status_modelo("D");

            $this->modelo_dao->Save($obj);

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

    public function Modelo_Ativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->modelo_dao->load_objeto($this->post_request['id_modelo']);

            $obj->set_status_modelo("A");

            $this->modelo_dao->Save($obj);

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
