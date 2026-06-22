<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Frota_Control extends Control
{

    private object $frota_dao;
    private object $usuario_frota_dao;
    private object $modelo_control;
    private object $usuario_control;

    public function __construct(array $post_request)
    {
        $this->frota_dao = new Frota_DAO();
        $this->usuario_frota_dao = new UsuarioFrota_DAO();
        $this->modelo_control = new Modelo_Control($post_request);
        $this->usuario_control = new Usuario_Control($post_request);

        parent::__construct($post_request, $this->frota_dao);
    }

    public function Frota_Gerencia($busca = null)
    {
        try {
            //CONFIGURE A CONDIÇÃO DE BUSCA  
            $condicao = " and status_frota = 'A'";
            if ($busca != null) {
                $condicao .= $busca;
            }

            //INICIALIZA A PÁGINA		
            $pagina = isset($this->post_request['pagina']) && $this->post_request['pagina'] > 0 ? $this->post_request['pagina'] : 1;

            //PEGA TOTAL DE REGISTROS
            $total_reg = $this->frota_dao->get_Total($condicao);

            //CONFIGURE O NUMERO DE REGISTROS POR PAGINA
            $pag_views = 10;

            //CALCULA OS PARAMETROS DE PAGINACAO
            $inicio = ($pagina - 1) * $pag_views;

            //CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
            $ordem = " id_frota asc";

            $objetos = $this->frota_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
            $objModelo = $this->modelo_control->Modelo_Gerencia(" and id_modelo = " . $objetos[0]->get_id_modelo());
            $objMotorista = $this->usuario_control->Usuario_Motorista(" and id_frota = " . $objetos[0]->get_id_frota());

            $dataArray = array_map(function ($u) use ($objModelo, $objMotorista) {
                $item = $u->to_array();
                $item['motorista'] = $objMotorista['data']['nome'] ?? null;
                $item['modelo'] = $objModelo['data'][0] ?? null;
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

    public function Frota_Add()
    {
        try {
            $obj = new Frota();

            $obj->set_id_modelo($this->post_request['id_modelo']);
            $obj->set_placa($this->post_request['placa']);
            $obj->set_cor($this->post_request['cor']);
            $obj->set_status_frota("A");

            $id_frota = $this->frota_dao->Save($obj);
            
            // VINCULA FROTA COM O USUÁRIO
            $obj = new UsuarioFrota();
            
            $obj->set_id_usuario($this->post_request['id_usuario']);
            $obj->set_id_frota($id_frota);

            $this->usuario_frota_dao->Save($obj);

            return [
                "message" => "Novo modelo cadastrado com sucesso",
                "id_frota" => $id_frota
            ];
        } catch (Exception $e) {

            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function Frota_Alt()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->frota_dao->load_objeto($this->post_request['id_frota']);

            $obj->set_id_marca($this->post_request['id_marca']);
            $obj->set_id_modelo($this->post_request['id_modelo']);
            $obj->set_placa($this->post_request['placa']);
            $obj->set_cor($this->post_request['cor']);

            $this->frota_dao->Save($obj);

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

    public function Frota_Desativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->frota_dao->load_objeto($this->post_request['id_frota']);

            $obj->set_status_frota("D");

            $this->frota_dao->Save($obj);

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

    public function Frota_Ativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->frota_dao->load_objeto($this->post_request['id_frota']);

            $obj->set_status_frota("A");

            $this->frota_dao->Save($obj);

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
