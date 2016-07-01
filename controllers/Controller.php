<?php

/**
 * Created by PhpStorm.
 * User: Ondřej
 * Date: 24.06.2016
 * Time: 22:28
 */
abstract class Controller
{
    protected $data = array();
    protected $view = "";
    protected $header = array('title' => '', 'keywords' => '', 'description' => '');

    /**treat
     * @param $params
     * @return mixed
     */
    abstract function treat($params);
    /**
     * Extract view
     * @return phtml view
     */
    public function extractView()
    {
        if($this->view)
        {
            extract($this->data, EXTR_PREFIX_ALL, "");
            extract($this->protectData($this->data));
            require("views/" . $this->view . "phtml");
        }
    }
    /** redirect to URL
     *@params URL
     */
    public function redirect($url)
    {
        header("Location: /$url");
        header("Connection: close");
        exit;
    }
    /** Protecting method for XSS attack */
    private function protectData($x = null)
    {
        if (!isset($x))
            return null;
        elseif (is_string($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif (is_array($x))
        {
            foreach($x as $k => $v)
            {
                $x[$k] = $this->protectData($v);
            }
            return $x;
        }
        else
            return $x;
    }

    /** Add error message to page */
    public function addMsg($msg, $type)
    {
        if (isset($_SESSION['error_messages']))
            $_SESSION['error_messages'][] = array('errorMessage' => $msg, 'type' => $type);
        else
            $_SESSION['error_messages'] = array(array('errorMessage' => $msg, 'type' => $type));
    }
    /** return error messages */
    public static function returnErrorMessages()
    {
        if (isset($_SESSION['error_messages']))
        {
            $errorMessages = $_SESSION['error_messages'];
            unset($_SESSION['error_messages']);
            return $errorMessages;
        }
        else
            return array();
    }
    /** check if user have permissions */
    public function notNormalUser($permissions = false)
    {
        //Instance of user administrator
        $userAdministrator = new UserAdministrator();
        //return user from db
        $user = $userAdministrator->returnUser();
        //Check for permissions (0 - normal user etc.)
        if(!$user || ($permissions && $user['permissions'] > 1))
        {
            //Add message of insuficient permissions
            $this->addMsg('Nedostatečná oprávnění - Insuficient permissions', 'WARNING');
            //Redirect to home
            $this->redirect('home');
        }
    }
}