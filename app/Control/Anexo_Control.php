<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Anexo_Control extends Control
{

    private object $anexo_dao;

    public function __construct(array $post_request)
    {
        $this->anexo_dao = new Anexo_DAO();
        parent::__construct($post_request, $this->anexo_dao);
    }

    public function Anexo_Gerencia()
    {
        try {
            //CONFIGURE A CONDIÇÃO DE BUSCA  
            $condicao = " and status_anexo = 'A'";
            if (isset($this->post_request['id_anexo'])) {
                $condicao = "and id_anexo = " . $this->post_request['id_anexo'] . "";
            }

            //INICIALIZA A PÁGINA		
            $pagina = isset($this->post_request['pagina']) && $this->post_request['pagina'] > 0 ? $this->post_request['pagina'] : 1;

            //PEGA TOTAL DE REGISTROS
            $total_reg = $this->anexo_dao->get_Total($condicao);

            //CONFIGURE O NUMERO DE REGISTROS POR PAGINA
            $pag_views = 10;

            //CALCULA OS PARAMETROS DE PAGINACAO
            $inicio = ($pagina - 1) * $pag_views;

            //CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
            $ordem = " id_anexo asc";

            $objetos = $this->anexo_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);

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

    public function Anexo_Add()
    {
        try {

            $fTamanho = ($this->post_request['arquivo']['size'] > 0) ? ($this->post_request['arquivo']['size']) / 1024 : 0;
            $msg_erro = 'A T E N Ç Ã O ! ! !\n\n';
            $erro = FALSE;

            if ($fTamanho > 6144) {
                $msg_erro .= "Tamanho maior que o permitido.\n";
                $erro = TRUE;
            }

            /* VERIFICA EXTENÇÃO DO ARQUIVO */
            $file_ext = substr($this->post_request['arquivo']['name'], (strripos($this->post_request['arquivo']['name'], '.') + 1));
            $ext = array('PDF', 'JPG', 'JPEG', 'PNG');
            if (!in_array(strtoupper($file_ext), $ext)) {
                $msg_erro .= "Extensão não permitida.\n";
                $erro = TRUE;
            }

            if (!$erro) {
                $arquivo_anexo = $this->post_request['arquivo']['tmp_name'];

                $file_name = $this->post_request['arquivo']['name'];
                $file_ext = substr($file_name, (strripos($file_name, '.') + 1));

                $obj = new Anexo();

                $obj->set_id_tipo_anexo($this->post_request['id_tipo_anexo']);
                $obj->set_id_usuario($this->post_request['id_usuario']);                                
                $obj->set_arquivo_nome($file_name);
                $obj->set_arquivoextensao($file_ext);
                $obj->set_status_anexo("A");

                $id_anexo = $this->anexo_dao->Save($obj);

                $dir = $_SERVER['DOCUMENT_ROOT'] . "/files/";

                $destino = $dir . 'cod_' . $id_anexo . '.' . $file_ext;

                if (!copy($arquivo_anexo, $destino)) {
                    $erro = "Ocorreu um erro ao enviar o arquivo!";
                }
            }

            if (!$erro) {
                return [
                    "message" => $erro
                ];
            }
            return [
                "message" => "Novo anexo cadastrado com sucesso",
                "id_anexo" => $id_anexo
            ];
        } catch (Exception $e) {

            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function Anexo_Alt()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->anexo_dao->load_objeto($this->post_request['id_anexo']);

            $obj->set_id_tipo_anexo($this->post_request['id_tipo_anexo']);
            $obj->set_arquivo_nome($this->post_request['arquivo_nome']);
            $obj->set_arquivoextensao($this->post_request['arquivoextensao']);

            $this->anexo_dao->Save($obj);

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

    public function Anexo_Desativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->anexo_dao->load_objeto($this->post_request['id_anexo']);

            $obj->set_status_anexo("D");

            $this->anexo_dao->Save($obj);

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

    public function Anexo_Ativar()
    {

        try {
            //CARREGA DAO, SETA STATUS e SALVA        
            $obj = $this->anexo_dao->load_objeto($this->post_request['id_anexo']);

            $obj->set_status_anexo("A");

            $this->anexo_dao->Save($obj);

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
