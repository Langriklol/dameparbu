<?php

/**
 * Created by PhpStorm.
 * User: Ondřej
 * Date: 27.06.2016
 * Time: 20:25
 */
class ArticleAdministrator
{
    //Return article from database according to article's
    public function returnArticle($url)
    {
        return Db::queryOnce('
                        SELECT `article_id`, `title`, `content`, `url`, `description`, `keywords`, `time`, `author`, `img`
                        FROM `articles`
                        WHERE `url` = ?
                ', array($url));
    }
    /** Return all articles from Db */
    public function returnArticles()
    {
        return Db::queryAll('
                        SELECT `article_id`, `title`, `url`, `description`, `time`, `author`, `img`
                        FROM `articles`
                        ORDER BY `article_id` DESC
                ');
    }

    /** Insert or change the article */
    public function saveArticle($id, $article)
    {
        if(!$id)
            Db::insert('articles', $article);
        else
            Db::change('articles', $article, 'WHERE clanky_id = ?', array($id));
    }
    /** Delete a article */
    public function deleteArticle($url)
    {
        Db::query('
                DELETE FROM articles
                WHERE url = ?
        ', array($url));
    }
}