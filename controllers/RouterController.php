<?php

/**
 * Created by PhpStorm.
 * User: Ondřej
 * Date: 24.06.2016
 * Time: 22:36
 */
class RouterController extends Controller
{
    protected $controller;

    public function treat($params)
    {
        $parsedURL = $this->parseURL($params[0]);

        if(empty($parsedURL) || $parsedURL == "home")
            $this->redirect('section/outset');

        $classOfController = $this->toCamelCase(array_shift($parsedURL)) . 'Controller';

        if(file_exists('controllers' . $classOfController . '.php'))
            $this->controller = new $classOfController;
        else
            $this->redirect('error');
        //Sets the data for template
        //Set template's title
        $this->data['title'] = $this->header['title'];
        //Sets template's description
        $this->data['description'] = $this->header['description'];
        //Sets template's keywords
        $this->data['keywords'] = $this->header['keywords'];

        //Sets view's template
        $this->view = 'main';

        $this->data['errorMessages'] = $this->returnErrorMessages();
    }
    /** extract url
     * @return string
     * @param URL
     */
    private function parseURL($url)
    {
        $parsedURL = parse_url($url);
        $arsedURL["path"] = ltrim($parsedURL["path"], "/");
        $parsedURL["path"] = trim($parsedURL["path"]);

        $separatedWay = explode("/", $parsedURL["path"]);

        return $separatedWay;
    }

    /** Parse text to CamelCase syntaxe
     * @params text
     */
    private function toCamelCase($text)
    {
        $sentence = str_replace('-',' ', $text);
        $sentence = ucwords($sentence);
        $sentence = str_replace(' ', '', $sentence);

        return $sentence;
    }
}