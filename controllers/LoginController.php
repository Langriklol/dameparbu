<?php

/**
 * Created by PhpStorm.
 * User: Ondřej
 * Date: 29.06.2016
 * Time: 17:31
 */
class LoginController extends Controller
{
    public function treat($params)
    {
        $userAdministrator = new UserAdministrator();
        if ($userAdministrator->returnUser())
            $this->redirect('administration');
        // Page's header
        $this->header['title'] = 'Přihlášení - Login';
        if ($_POST)
        {
            try
            {
                $userAdministrator->login($_POST['username'], $_POST['password']);
                $this->addMsg('Byl jste úspěšně přihlášen - You was succesfully logged in');
                $this->redirect('home');
            }
            catch (UserError $e)
            {
                $this->addMsg($e->getMessage(),"ERROR");
            }
        }
        // View's template
        $this->view = 'login';
    }
}