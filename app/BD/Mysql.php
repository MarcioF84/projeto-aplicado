<?php

/**
 * @author Marcio Figueredo
 * @copyright Copyright (c) 2026
 */

class Mysql
{

    private static $instance = null;
    private $con = null;

    public static function get_Instance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __construct()
    {

        $servidor_bd = "localhost"; // IP do Servidor do banco de dados.                    
        $nome_bd = ""; // Nome da Base do banco de dados.
        $usuario_bd = "root"; // Nome do usuário para conectar no banco de dados.
        $senha_bd = "rootpass"; // Senha do usuário para conectar no banco de dados.

        $this->con = mysqli_connect($servidor_bd, $usuario_bd, $senha_bd);
        mysqli_select_db($this->con, $nome_bd) or die("Could not select db: " . mysqli_error($this->con));
        mysqli_set_charset($this->con, "utf8mb4");
    }

    public function query($query)
    {

        $result = mysqli_query($this->con, $query);

        if (!$result) {
            throw new Exception(
                "Erro SQL: " . mysqli_error($this->con) .
                    " | Query: " . $query
            );
        }

        $returno = $result;


        return $returno;
    }

    public function fetch_object($result)
    {

        $got = array();

        if (!($result instanceof mysqli_result)) {
            throw new Exception("Resultado inválido para fetch_object");
        }

        while ($row = mysqli_fetch_object($result)) {
            array_push($got, $row);
        }

        return $got;
    }

    /**
     *  MYSQLI_ASSOC (int) Colunas s�o retornadas no array com os nomes dos campos nas chaves.
     *  MYSQLI_NUM (int) Colunas s�o retornadas no array com �ndices enumerados.
     *  MYSQLI_BOTH (int) Colunas s�o retornadas no array com �ndice tanto num�rico quanto com nomes dos campos.
     */
    public function fetch_array($result, $mode = MYSQLI_BOTH)
    {

        $got = array();

        if (!($result instanceof mysqli_result)) {
            throw new Exception("Resultado inválido na query");
        }

        while ($row = mysqli_fetch_array($result, $mode)) {
            array_push($got, $row);
        }

        return $got;
    }

    public function free_result(&$result)
    {
        return mysqli_free_result($result);
    }

    public function begin()
    {
        mysqli_query($this->con, "begin");
    }

    public function commit()
    {
        mysqli_query($this->con, "commit");
    }

    public function rollback()
    {
        mysqli_query($this->con, "rollback");
    }

    public function last_error()
    {
        return mysqli_error($this->con);
    }
}
