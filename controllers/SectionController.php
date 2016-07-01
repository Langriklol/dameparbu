<?php

/**
 * Created by PhpStorm.
 * User: Ondřej
 * Date: 28.06.2016
 * Time: 23:07
 */
class SectionController extends Controller
{
    public function treat($params)
    {
        //Create new obj of section administrator
        $sectionAdministrator = new SectionAdministrator();
        //Return section gets from url
        $section = $sectionAdministrator->returnSection($params[0]);
        //if section do not exists redirect to error page
        if(!$section)
            $this->redirect('error');
        //Define the header
        $this->header = array(
            'title' => $section['title'],
            'content' => $section['content'],
            'keywords' => null,
        );
        //Define template data
        //Section's title
        $this->data['title'] = $section['title'];
        //Section's content
        $this->data['content'] = $section['content'];

        //Set the template view of page
        $this->view = 'article';
    }
}