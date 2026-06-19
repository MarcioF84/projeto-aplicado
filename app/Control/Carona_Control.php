<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Carona_Control extends Control
{

    private object $carona_dao;
    private object $endereco_control;
    private object $frota_control;

    public function __construct(array $post_request)
    {
        $this->carona_dao = new Carona_DAO();
        $this->endereco_control = new Endereco_Control($post_request);
        $this->frota_control = new Frota_Control($post_request);

        parent::__construct($post_request, $this->carona_dao);
        
    }

    public function Carona_Gerencia()
    {
        try {
            //CONFIGURE A CONDIÇÃO DE BUSCA  
            $condicao = " and status_carona = 'A'";
            if (isset($this->post_request['id_carona'])) {
                $condicao = "and id_carona = " . $this->post_request['id_carona'] . "";
            }

            //INICIALIZA A PÁGINA		
            $pagina = isset($this->post_request['pagina']) && $this->post_request['pagina'] > 0 ? $this->post_request['pagina'] : 1;

            //PEGA TOTAL DE REGISTROS
            $total_reg = $this->carona_dao->get_Total($condicao);

            //CONFIGURE O NUMERO DE REGISTROS POR PAGINA
            $pag_views = 10;

            //CALCULA OS PARAMETROS DE PAGINACAO
            $inicio = ($pagina - 1) * $pag_views;

            //CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
            $ordem = " id_carona asc";

            $objetos = $this->carona_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
            $objEndereco = $this->endereco_control->Endereco_Gerencia($objetos[0]->get_id_endereco_origem());
            $objFrota = $this->frota_control->Frota_Gerencia($objetos[0]->get_id_frota());


            $dataArray = array_map(function ($u)  use ($objEndereco) {
                $endereco = $objEndereco['data'][0]['cep']." - ".$objEndereco['data'][0]['rua']." - ". $objEndereco['data'][0]['cidade']." / ". $objEndereco['data'][0]['estado'];
                $item = $u->to_array();      
                $item['endereco'] = $endereco ?? null;
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

    public function Carona_Add()
    {
        try {

            
            $result = $this->endereco_control->Endereco_Add();

            $obj = new Carona();

            $obj->set_id_frota($this->post_request['id_frota']);
            $obj->set_id_endereco_origem($result['id_endereco']);
            $obj->set_id_endereco_destino($result['id_endereco']);
            $obj->set_data_partida($this->data->get_formatData($this->post_request['data_partida'], 'BD'));
            $obj->set_hora_partida($this->post_request['hora_partida']);
            $obj->set_valor_carona($this->post_request['valor_carona']);
            $obj->set_qtde_assento($this->post_request['qtde_assento']);
            $obj->set_status_carona("A");

            $id_carona = $this->carona_dao->Save($obj);

            return [
                "message" => "Nova carona cadastrada com sucesso",
                "id_carona" => $id_carona
            ];
        } catch (Exception $e) {

            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function Carona_Alt()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->carona_dao->load_objeto($this->post_request['id_carona']);

            $obj->set_id_frota($this->post_request['id_frota']);
            $obj->set_id_endereco_origem($this->post_request['id_endereco_origem']);
            $obj->set_id_endereco_destino($this->post_request['id_endereco_destino']);
            $obj->set_data_partida($this->post_request['data_partida']);
            $obj->set_hora_partida($this->post_request['hora_partida']);
            $obj->set_valor_carona($this->post_request['valor_carona']);
            $obj->set_qtde_assento($this->post_request['qtde_assento']);

            $this->carona_dao->Save($obj);

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

    public function Carona_Desativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->carona_dao->load_objeto($this->post_request['id_carona']);

            $obj->set_status_carona("D");

            $this->carona_dao->Save($obj);

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

    public function Carona_Ativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->carona_dao->load_objeto($this->post_request['id_carona']);

            $obj->set_status_carona("A");

            $this->carona_dao->Save($obj);

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
