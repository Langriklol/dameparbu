<?php

/**
 * Created by PhpStorm.
 * User: Ondřej
 * Date: 29.06.2016
 * Time: 14:57
 */
class EditorController extends Controller
{
    public function treat($params)
    {
        //Check the user's permissions
        $this->notNormalUser(true);
        //Define the title of page
        $this->header['title'] = 'Editor';
        //Create instance of article administrator
        $articleAdministrator = new ArticleAdministrator();
        //Make preparation of article - pure article
        $article = array(
            'article_id' => '',
            'title' => '',
            'content' => '',
            'url' => '',
            'description' => '',
            'keywords' => '',
            'author' => '',
            'time' => '',
            'image' => '',
        );
        //If form is posted
        if($_POST){
            //Get article from $_POST
            $keys = array('article_id', 'title', 'content', 'url', 'description', 'keywords', 'author', 'time', 'image');
            $article = array_intersect_key($_POST, array_flip($keys));
            //Storing article to the Db
            $articleAdministrator->saveArticle($_POST['article_id'],$article);
            $this->addMsg("Článek byl úspěšně uložen - Article was sucessfully saved", "OK");
            $this->redirect('article/' . $article['url']);
        }
        else if(!empty($params[0]))
        {
            //Load article from db according to url
            $loadedArticle = $articleAdministrator->returnArticle($params[0]);
            //if loaded article exists
            if($loadedArticle)
                //Load loaded article to article var
                $article = $loadedArticle;
            else
                //Article do not exists, add message of it
                $this->addMsg("Článek nebyl nalezen - Article was not found");
            //Load article's params
            $this->data['article'] = $article;
            //Set view template
            $this->view = 'editor';
        }
    }
}