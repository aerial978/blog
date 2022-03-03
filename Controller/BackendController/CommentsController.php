<?php

require_once 'Controller/BaseController.php';
require_once 'model/CommentManager.php';

class CommentsController extends BaseController{

    public function indexcomment()
    {   
        $commentManager = new CommentManager();
        $indexComments = $commentManager->indexComment();
        
        echo $this->twig->render("backend/comments/indexcomment.html.twig",[
            'activemenu' => 'commentmenu',
            'indexcomments' => $indexComments
        ]);
    }

    public function editcomment()
    {
        if(isset($_GET['id'])) {

            $id = $_GET['id'];
            
            $commentManager = new CommentManager();
            $editComment = $commentManager->editComment($id);
            
            }
            
            if (!empty($_POST) && isset($_POST)) {
            
                if(isset($_POST['status_comm']) && $_POST['status_comm'] == 2) {
                    $status_comm = $_POST['status_comm'];
                } else {
                    $status_comm = 1; 
                }
            
            $update = $this->bdd->prepare('UPDATE comments SET status_comm = :status_comm WHERE id = :id');
            $update->execute([
            'status_comm'=> $status_comm,
            'id' => $id
                    
            ]);
                 
            $_SESSION['success'] = 'Your update successfully !';
                    
            header('Location: indexcomment.php');
            
            }

        echo $this->twig->render("backend/comments/editcomment.html.twig",[
            'activemenu' => 'commentmenu',
            'editcomment' => $editComment

        ]);
    }
}