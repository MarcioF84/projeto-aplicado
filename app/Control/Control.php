<?php


/**
 * @author Marcio Figueredo
 * @copyright Copyright (c) 2026
 */

class Control
{
    public $post_request;
    protected $data;
    protected $dao;

    public function __construct($post_request)
    {
        $this->post_request = $post_request;
        $this->data = new Data();
    }

    /**
     * @ignore
     */
    public function get_DAO($classe)
    {
        $dao = $classe . "_DAO";
        return new $dao("AF_Bd_Mysql");
    }

    /**
     * @ignore
     */
    public function set_post_request($post_request)
    {
        $this->post_request = $post_request;
    }

    /**
     * @ignore
     */
    public function get_post_request()
    {
        return $this->post_request;
    }

    /**
     * @ignore
     */
    public function __destruct() {}
}
