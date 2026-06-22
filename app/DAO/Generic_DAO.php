<?php

/**
 * @author Marcio Figueredo 
 * @copyright Copyright (c) 2026
 */
class Generic_DAO {

    protected $objeto_atual;
	protected $con;
	protected $sessao;
    protected $chave;
    protected $tabela;

	public function __construct($factory) {
        
		$banco = new $factory();
		$this->con = $banco->get_Instance();

        $objeto = substr(get_class($this), 0, (strlen(get_class($this)) - 4));
        $this->objeto_atual = $objeto;
    }
	
	function trata_valor_sql($valor){		
		return (!is_null($valor)) ? addslashes($valor) : $valor;		
	}

    public function Save($objeto) {                

        $arr_update = array();

        $metodos = get_class_methods($objeto);
        $get_id = $metodos[0];
        $set_id = $metodos[1];

        //Array de dados				
        $dados = array_map(array($this, 'trata_valor_sql'), $objeto->get_all_dados());
        
        //Array de [0 - n] com campos
        $campos = array_keys($dados);        

        //String com os dados para inserir ou alteraR        
        $str_insert = $str_column = "";
                
        $i = 0;
        while ($i < count($dados)) {
			
			$valor = $this->trata_vlr_sql($campos[$i], $dados[$campos[$i]]);

            if ($valor && ($campos[$i] != $this->chave)) {
                $str_column .= ($i > 0) ? ", " . trim($campos[$i]) : "";
                $str_insert .= ($i > 0) ? ", " . $valor . "" : $valor;
                $arr_update[] = $campos[$i] . " = " . $valor . "";
            }
			
            $i++;
        }
        
        if ($objeto->$get_id() == "") { 
            
            $sql = "select max({$this->chave}) as ultimo from {$this->tabela}";            			
            $result = $this->con->fetch_object($this->con->query($sql));			

            $id_new = $result[0]->ultimo;
            $id_new++;

            $objeto->$set_id($id_new);
            $str_insert = $id_new . $str_insert;

            $str_column = $campos[0] . $str_column;

            $insert = "insert into {$this->tabela} ({$str_column}) values({$str_insert});";            
            $this->con->query($insert);

            return $id_new;
        } else {
            
            $str_update = implode(", ", $arr_update);
            $update = "update {$this->tabela} set {$str_update} where {$this->chave} = " . $dados[$this->chave] . "";                        						
			
            $this->con->query($update);            
			
            return $dados[$this->chave];
        }
    }
	
    public function get_total($condicao) {

        $sql = "select count($this->chave) as total from {$this->tabela} where 1 = 1 {$condicao}";
		$result = $this->con->fetch_array($this->con->query($sql));
		
		return $result[0]['total'];
		
    }

    public function get_ids($condicao, $ordem, $inicio = "", $pag_views = "") {

        $limite = "limit 100 offset {$inicio}";
        if ($pag_views > 0) {
            $limite = "limit {$pag_views} offset {$inicio}";
        }

        $order = ($ordem != "") ? "order by {$ordem}" : "";

        $sql = "select {$this->chave} from {$this->tabela} where 1 = 1 {$condicao} {$order} {$limite}";
		return $this->con->fetch_array($this->con->query($sql));
    }

    public function get_objs($condicao, $ordem, $inicio, $pag_views) {

        $ret = $this->get_ids($condicao, $ordem, $inicio, $pag_views);
        
        $objs = Array();

        if (count($ret) > 0) {
            foreach ($ret as $valor) {
                $o = $this->load_objeto($valor[0]);
                Array_push($objs, $o);
            }
        }
        return $objs;
    }

    public function load_objeto($condicao) {

        $objeto = new $this->objeto_atual();

        $dados = $objeto->get_all_dados();

        $campos = array_keys($dados);
        $str_campos = implode(",", $campos);

        $limite = count($campos);

        $sql = "select {$str_campos} from {$this->tabela} where {$this->chave} = {$condicao};";                                        		
        $result = $this->con->query($sql);
        
        $row = array();
        while ($obj = $this->con->fetch_object($result)) {			
            array_push($row, $obj[0]);
        }

        $metodos = get_class_methods($objeto);
        unset($metodos[array_search('get_all_dados', $metodos, TRUE)]);
        $metodos = array_values($metodos);

        $j = 1;
        for ($i = 0; $i < $limite; $i++) {
			$invoque = $metodos[$j];										
			$campo = $campos[$i];			
			
            $param = $row[0]->$campo;			
            $objeto->$invoque($param);
            $j = $j + 2;
        }
        
        return $objeto;
    }

    public function trata_vlr_sql($coluna, $valor) {
        
        $sql = "select data_type, column_default from information_schema.columns where column_name = '{$coluna}' and table_name = '{$this->tabela}'";		
        $result = $this->con->fetch_object($this->con->query($sql));
		
        if (($this->chave != $coluna) && ($valor == '' || $valor == null)) {
            return (!empty($result[0]->column_default)) ? FALSE : 'null';
        }
        if (in_array($result[0]->data_type, array('decimal', 'numeric', 'float', 'real'))) {
            return (strpos($valor, ',')) ? str_replace(',', '.', str_replace('.', '', $valor)) : $valor;
        } else if (in_array($result[0]->data_type, array('bigint', 'smallint', 'integer'))) {
            return $valor;
        } else {            
            return "'{$valor}'";
        }
        
    }
	
	public function get_column_type($coluna){
		
		$sql = "select data_type, column_default from information_schema.columns where column_name = '{$coluna}'";		
		
        $result = $this->con->fetch_object($this->con->query($sql));
		
		return $result[0]->data_type;
		
	}

    /**
     * @ignore
     */
    public function get_con() {
        return $this->con;
    }
	
	/**
     * @ignore
     */
    public function set_con($con) {
        $this->con = $con;
    }
	
	/**
     * @ignore
     */
    public function get_chave() {
        return $this->chave;
    }

    /**
     * @ignore
     */
    public function set_chave($chave) {
        $this->chave = $chave;
    }

    /**
     * @ignore
     */
    public function get_tabela() {
        return $this->tabela;
    }

    /**
     * @ignore
     */
    public function set_tabela($tabela) {
        $this->tabela = $tabela;
    }

    /**
     * @ignore
     */
    public function get_objeto_atual() {
        return $this->objeto_atual;
    }

    /**
     * @ignore
     */
    public function set_objeto_atual($objeto_atual) {
        $this->objeto_atual = $objeto_atual;
    }
	
	/**
     * @ignore
     */
    public function get_sessao() {
        return $this->sessao;
    }

    /**
     * @ignore
     */
    public function set_sessao($sessao) {
        $this->sessao = $sessao;
    }

}

?>