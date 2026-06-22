<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Reserva_Control extends Control
{

    private object $reserva_dao;
    private object $carona_control;

    public function __construct(array $post_request)
    {
        $this->reserva_dao = new Reserva_DAO();
        $this->carona_control = new Carona_Control($post_request);
        parent::__construct($post_request, $this->reserva_dao);
    }

    public function Reserva_Gerencia($busca = null)
    {
        try {
            //CONFIGURE A CONDIÇÃO DE BUSCA  
            $condicao = " and status_reserva = 'A'";
            if (isset($this->post_request['id_usuario']) && $this->post_request['id_usuario'] > 0) {
                $condicao .= " and id_usuario = " . $this->post_request['id_usuario'];
            }
            if ($busca != null) {
                $condicao .= $busca;
            }

            //INICIALIZA A PÁGINA		
            $pagina = isset($this->post_request['pagina']) && $this->post_request['pagina'] > 0 ? $this->post_request['pagina'] : 1;

            //PEGA TOTAL DE REGISTROS
            $total_reg = $this->reserva_dao->get_Total($condicao);

            //CONFIGURE O NUMERO DE REGISTROS POR PAGINA
            $pag_views = 10;

            //CALCULA OS PARAMETROS DE PAGINACAO
            $inicio = ($pagina - 1) * $pag_views;

            //CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
            $ordem = " id_reserva asc";

            $objetos = $this->reserva_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
            $objCarona = $this->carona_control->Carona_Gerencia(" and id_carona = " . $objetos[0]->get_id_carona());

            $dataArray = array_map(function ($u) use ($objCarona) {
                $item = $u->to_array();
                $item['carona'] = $objCarona['data'][0] ?? null;
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

    public function Reserva_Add()
    {
        try {
            $obj = new Reserva();

            $obj->set_id_usuario($this->post_request['id_usuario']);
            $obj->set_id_carona($this->post_request['id_carona']);
            $obj->set_qtde_assentos($this->post_request['qtde_assentos']);
            $obj->set_data_reserva($this->data->get_formatData($this->post_request['data_reserva'], 'BD'));
            $obj->set_status_reserva("A");

            $id_reserva = $this->reserva_dao->Save($obj);

            return [
                "message" => "Nova reserva cadastrada com sucesso",
                "id_reserva" => $id_reserva
            ];
        } catch (Exception $e) {

            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function Reserva_Alt()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->reserva_dao->load_objeto($this->post_request['id_reserva']);

            $obj->set_id_usuario($this->post_request['id_usuario']);
            $obj->set_id_carona($this->post_request['id_carona']);
            $obj->set_qtde_assentos($this->post_request['qtde_assentos']);
            $obj->set_data_reserva($this->post_request['data_reserva']);

            $this->reserva_dao->Save($obj);

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

    public function Reserva_Desativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->reserva_dao->load_objeto($this->post_request['id_reserva']);

            $obj->set_status_reserva("D");

            $this->reserva_dao->Save($obj);

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

    public function Reserva_Ativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->reserva_dao->load_objeto($this->post_request['id_reserva']);

            $obj->set_status_reserva("A");

            $this->reserva_dao->Save($obj);

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
