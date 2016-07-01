<?php

/**
 * Created by PhpStorm.
 * User: Ondřej
 * Date: 29.06.2016
 * Time: 17:08
 */
class RegistrationController extends Controller
{
    public function treat($params)
    {
        //Header of web
        //title
        $this->header['title'] = 'Registrace - register';
        //if from is posted
        if($_POST)
        {
            try{
                $useraAdministrator = new UserAdministrator();
                $useraAdministrator->register($_POST['username'], $_POST['password'], $_POST['password_again'], $_POST['year'], 0);
                $useraAdministrator->login($_POST['username'], $_POST['password']);
                $this->addMsg("Byl jsi úspěšně přihlášen - You was sucessfuly logged in");
                $this->redirect('home');
            }catch(UserError $e)
            {
                $this->addMsg($e->getMessage(),"ERROR");
            }
        }
        //Set view template
        $this->view = 'registration';
    }
}