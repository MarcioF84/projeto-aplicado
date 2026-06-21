<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Endereco_Control extends Control
{

    private object $endereco_dao;

    public function __construct(array $post_request)
    {
        $this->endereco_dao = new Endereco_DAO();
        parent::__construct($post_request, $this->endereco_dao);
    }

    public function Endereco_Gerencia($busca = null)
    {
        try {
            
            //CONFIGURE A CONDIÇÃO DE BUSCA  
            $condicao = " and status_endereco = 'A'";
            if (isset($this->post_request['id_endereco'])) {
                $condicao .= "and id_endereco = " . $this->post_request['id_endereco'] . "";
            }
            if ($busca != null) {
                $condicao .= $busca;
            }

            //INICIALIZA A PÁGINA		
            $pagina = isset($this->post_request['pagina']) && $this->post_request['pagina'] > 0 ? $this->post_request['pagina'] : 1;

            //PEGA TOTAL DE REGISTROS
            $total_reg = $this->endereco_dao->get_Total($condicao);

            //CONFIGURE O NUMERO DE REGISTROS POR PAGINA
            $pag_views = 10;

            //CALCULA OS PARAMETROS DE PAGINACAO
            $inicio = ($pagina - 1) * $pag_views;

            //CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
            $ordem = " id_endereco asc";

            $objetos = $this->endereco_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);

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

    public function Endereco_Add()
    {
        try {
            $obj = new Endereco();

            $obj->set_cep($this->post_request['cep']);
            $obj->set_rua($this->post_request['rua']);
            $obj->set_cidade($this->post_request['cidade']);
            $obj->set_bairro($this->post_request['bairro']);
            $obj->set_estado($this->post_request['estado']);
            $obj->set_latitude(isset($this->post_request['latitude']) ? $this->post_request['latitude'] : null);
            $obj->set_longitude(isset($this->post_request['longitude']) ? $this->post_request['longitude'] : null);
            $obj->set_status_endereco("A");

            $id_endereco = $this->endereco_dao->Save($obj);

            return [
                "message" => "Novo endereço cadastrado com sucesso",
                "id_endereco" => $id_endereco
            ];
        } catch (Exception $e) {

            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function Endereco_Alt()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->endereco_dao->load_objeto($this->post_request['id_endereco']);

            $obj->set_cep($this->post_request['cep']);
            $obj->set_rua($this->post_request['rua']);
            $obj->set_cidade($this->post_request['cidade']);
            $obj->set_bairro($this->post_request['bairro']);
            $obj->set_estado($this->post_request['estado']);
            $obj->set_latitude($this->post_request['latitude']);
            $obj->set_longitude($this->post_request['longitude']);

            $this->endereco_dao->Save($obj);

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

    public function Endereco_Desativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->endereco_dao->load_objeto($this->post_request['id_endereco']);

            $obj->set_status_endereco("D");

            $this->endereco_dao->Save($obj);

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

    public function Endereco_Ativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->endereco_dao->load_objeto($this->post_request['id_endereco']);

            $obj->set_status_endereco("A");

            $this->endereco_dao->Save($obj);

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
