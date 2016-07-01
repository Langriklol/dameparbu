<?php

/**
 * Created by PhpStorm.
 * User: Ondřej
 * Date: 29.06.2016
 * Time: 17:21
 */
class AdministrationController extends Controller
{
    public function treat($params)
    {
        //Check permissions
        $this->notNormalUser();
        //Header of page
        //Page title
        $this->header['title'] = 'Administrace - administration';
        //get array of user
        $userAdministrator = new UserAdministrator();
        if(!empty($params[0]) && $params[0] == "logout")
        {
            $userAdministrator->logout();
            $this->redirect('login');
        }
        //Get user
        $user = $userAdministrator->returnUser();
        $this->data['username'] = $user['username'];
        $this->data['permissions'] = $user['permissions'];
        //Set view's template
        $this->view = 'administration';
    }
}