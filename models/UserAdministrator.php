<?php

/**
 * Created by PhpStorm.
 * User: Ondřej
 * Date: 29.06.2016
 * Time: 15:33
 */
class UserAdministrator
{
    //Retrun a MegaSuperDuper protected and hashed password
    public function returnImprint($passwd)
    {
        $saltF = "#&asSfr1%egh@l€d";
        $saltS = "0hRl1?El53T1pe!e";
        return hash('sha256', $saltF . $passwd . $saltS);
    }
    //Register new user
    public function register($name, $passwd, $passwdAgain, $year, $permissions = 0)
    {
        //If year do not match this year
        if ($year != date('Y'))
            throw new UserError('Chybně vyplněný antispam - Bad wrotten anitspam');
        //If password do not match
        if ($passwd != $passwdAgain)
            throw new UserError('Hesla nesouhlasí - Passwords do not match');
        //User array
        $user = array(
            'username' => $name,
            'password' => $this->returnImprint($passwd),
            'permissions' => $permissions,
        );
        try{
            Db::insert('users', $user);
        }catch(PDOException $e){
            throw new UserError("Uživatel s tímto jménem již existuje - User with this name already exists");
        }
    }
    //Login user
    public function login($name, $passwd)
    {
        //Import user from table
        $user = Db::queryOnce('
                        SELECT user_id, username, permissions
                        FROM users
                        WHERE jmeno = ? AND heslo = ?
                ', array($name, $this->returnImprint($passwd)));
        //If user do not exists
        if(!$user)
            throw new UserError("Nesprávné jméno nebo heslo - Bad username or password");
        //User array to session
        $_SESSION['user'] = $user;
    }
    //User logout
    public function logout(){
        unset($_SESSION['user']);
    }

    public function returnUser()
    {
        if (isset($_SESSION['user']))
            return $_SESSION['user'];
        return null;
    }
}