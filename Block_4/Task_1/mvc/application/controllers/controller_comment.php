<?php

class controller_comment extends Controller
{
    function __construct()
    {
        $this->model = new Model_Comment();
        $this->view = new View();
    }
    function action_index()
    {
        $data = $this->model->getAll();
        $this->view->generate('allComments_view.php', 'template_view.php', $data);
    }

    function action_sendComment()
    {
        $this->view->generate('commentForm_view.php', 'template_view.php');
    }
}