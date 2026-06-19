<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Data
{

    public $seg;
    public $min;
    public $hora;
    public $dia;
    public $mes;
    public $ano;
    public $ts;

    /**
     * Carrega a data e hora atual na instancia��o.
     * 
     * @author Marcio Figueredo 
     * @return void
     */
    public function __construct()
    {
        $this->carregaDataAtual();
    }

    /**
     * Carrega a data e hora atual no objeto.
     * 
     * @author Marcio Figueredo
     * @return void 
     */
    private function carregaDataAtual()
    {

        date_default_timezone_set("America/Sao_Paulo");

        $agora = getdate();

        $this->set_seg($agora["seconds"]);
        $this->set_min($agora["minutes"]);
        $this->set_hora($agora["hours"]);
        $this->set_dia($agora["mday"]);
        $this->set_mes($agora["mon"]);
        $this->set_ano($agora["year"]);
        $this->set_ts($agora["0"]);
    }

    public function carregaData($data)
    {

        $aux = preg_split("/[-:\/ ]+/", $data);

        $hora = $minuto = $segundo = 0;

        if (strlen($aux[0]) == 2) {
            //DD/MM/YYYY
            $dia = $aux[0];
            $this->set_dia($dia);

            $mes = $aux[1];
            $this->set_mes($mes);

            $ano = $aux[2];
            $this->set_ano($ano);
        } else {
            //YYYY-MM-DD
            $dia = $aux[2];
            $this->set_dia($dia);

            $mes = $aux[1];
            $this->set_mes($mes);

            $ano = $aux[0];
            $this->set_ano($ano);
        }

        if (isset($aux[3])) {
            $hora = $aux[3];
            $this->set_hora($hora);
        }

        if (isset($aux[4])) {
            $minuto = $aux[4];
            $this->set_min($minuto);
        }

        if (isset($aux[5])) {
            $segundo = $aux[5];
            $this->set_seg($segundo);
        }

        $time = mktime($hora, $minuto, $segundo, $mes, $dia, $ano);
        $this->set_ts($time);
    }

    public function get_formatHora($hora, $destino)
    {
        $this->carregaHora($hora);

        if ($hora == null) {
            return null;
        }

        switch ($destino) {
            case 'HMS':
                $retorno = date('H:i:s', $this->get_ts());
                break;

            case 'HM':
                $retorno = date('H:i', $this->get_ts());
                break;

            case 'TIMESTAMP':
                $retorno = $this->get_ts();
                break;
        }

        return $retorno;
    }


    private function lpad($strString, $intTamanho, $strCompletaCom = '0')
    {
        return str_pad($strString, $intTamanho, $strCompletaCom, STR_PAD_LEFT);
    }

    private function carregaHora($horaCompleta)
    {
        $aux = explode(':', $horaCompleta);

        $hora = $aux[0];
        $this->set_hora($hora);

        $minuto = $aux[1];
        $this->set_min($minuto);

        $segundo = $aux[2];
        $this->set_seg($segundo);

        $time = mktime($hora, $minuto, $segundo);
        $this->set_ts($time);
    }

    public function get_formatData($data, $destino)
    {

        if ($data == 'NOW' || $data == NULL) {
            $this->carregaDataAtual();
        } else {
            $this->carregaData($data);
        }


        switch ($destino) {
            case 'BD':
                $retorno = date('Y-m-d H:i:s', $this->get_ts());
                break;

            case 'PADRAO':
                $retorno = date('d/m/Y H:i', $this->get_ts());
                break;

            case 'COMPLETO':
                $retorno = date('d/m/Y H:i:s', $this->get_ts());
                break;

            case 'DMA':
                $retorno = date('d/m/Y', $this->get_ts());
                break;

            case 'AMD':
                $retorno = date('Y-m-d', $this->get_ts());
                break;

            case 'HMS':
                $retorno = date('H:i:s', $this->get_ts());
                break;

            case 'HM':
                $retorno = date('H:i', $this->get_ts());
                break;

            case 'TIMESTAMP':
                $retorno = $this->get_ts();
                break;
        }

        return $retorno;
    }

    public function get_dataAtual($destino)
    {

        return $this->get_formatData(date('d/m/Y H:i:s'), $destino);
    }

    /**
     * @ignore
     */
    public function get_seg()
    {
        return $this->seg;
    }

    /**
     * @ignore
     */
    public function set_seg($seg)
    {
        $this->seg = $seg;
    }

    /**
     * @ignore
     */
    public function get_min()
    {
        return $this->min;
    }

    /**
     * @ignore
     */
    public function set_min($min)
    {
        $this->min = $min;
    }

    /**
     * @ignore
     */
    public function get_hora()
    {
        return $this->hora;
    }

    /**
     * @ignore
     */
    public function set_hora($hora)
    {
        $this->hora = $hora;
    }

    /**
     * @ignore
     */
    public function get_dia()
    {
        return $this->dia;
    }

    /**
     * @ignore
     */
    public function set_dia($dia)
    {
        $this->dia = $dia;
    }

    /**
     * @ignore
     */
    public function get_mes()
    {
        return $this->mes;
    }

    /**
     * @ignore
     */
    public function set_mes($mes)
    {
        $this->mes = $mes;
    }

    /**
     * @ignore
     */
    public function get_ano()
    {
        return $this->ano;
    }

    /**
     * @ignore
     */
    public function set_ano($ano)
    {
        $this->ano = $ano;
    }

    /**
     * @ignore
     */
    public function get_ts()
    {
        return $this->ts;
    }

    /**
     * @ignore
     */
    public function set_ts($ts)
    {
        $this->ts = $ts;
    }
}
