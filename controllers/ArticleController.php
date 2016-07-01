<?php

/**
 * Created by PhpStorm.
 * User: Ondřej
 * Date: 28.06.2016
 * Time: 20:24
 */
class ArticleController extends Controller
{
    //Treat method
    public function treat($params)
    {
        // Create new obj of article administrator
        $articleAdministrator = new ArticleAdministrator();
        // Create new obj of user administrator
        $userAdministrator = new UserAdministrator();
        //return user's array
        $user = $userAdministrator->returnUser();
        //Check user permissions
        $this->data['permissions'] = $user && ($user['permissions'] > 1);

        //If is assigned article's url for delete
        if(!empty($params[1]) && $params[1] == 'delete')
        {
            //check user's permissions
            $this->notNormalUser(true);
            //delete article
            $articleAdministrator->deleteArticle($params[0]);
            //add Message of it
            $this->addMsg("Článek byl úspěšně odstraněn - Article was sucessfuly deleted", "OK");
            //Redirect to home
            $this->redirect("home");
        }
        //Article administrator return article from url
        $article = $articleAdministrator->returnArticle($params[0]);
        // If article do not exists redirect to error page
        if(!$article)
            $this->redirect('error');
        //Sets the header
        $this->header = array(
            'title' => $article['title'],
            'keywords' => $article['keywords'],
            'description' => $article['description'],
        );
        //Define template's variables
        //Time of article when was published
        $this->data['time'] = $article['time'];
        //Article's title
        $this->data['title'] = $article['title'];
        //Article's content
        $this->data['content'] = $article['content'];
        //Article's author
        $this->data['author'] = $article['author'];
        //Article's image
        $this->data['image'] = $article['image'];

        //Set the view template
        $this->view = 'article';
    }
}