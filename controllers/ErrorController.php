<?php

/**
 * Created by PhpStorm.
 * User: Ondřej
 * Date: 26.06.2016
 * Time: 21:24
 */
class ErrorController extends Controller
{
    public function treat($params)
    {
        header("HTTP/1.0 404 Not Found");
        $this->header['title'] = "Dáme pařbu | Error 404";
        $this->view = 'error';
    }
}