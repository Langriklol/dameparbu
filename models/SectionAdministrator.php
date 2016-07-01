<?php

/**
 * Created by PhpStorm.
 * User: Ondřej
 * Date: 28.06.2016
 * Time: 23:09
 */
class SectionAdministrator
{
    public function returnSection($url)
    {
        return Db::queryOnce('
                        SELECT  `title`, `content`, `url`
                        FROM `sections`
                        WHERE `url` = ?
                ', array($url));
    }
}