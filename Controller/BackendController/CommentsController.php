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

        if(isset($_SESSION['editcomm']) && $_SESSION['editcomm'] != "") { ?>
        
            <script>
                swal({
                title: "<?= $_SESSION['editcomm'] ?>",
                text: "",
                icon: "success", 
                });
            </script>
        <?php
            unset($_SESSION['editcomm']);
        }
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
            
            $commentManager = new CommentManager();
            $statusComment = $commentManager->statusComment($status_comm,$id);

            if($statusComment == NULL) {
                array_push($_SESSION['danger'], "There was a problem with a data processing !");
            }
                 
            $_SESSION['editcomm'] = 'Your update successfully !';
                    
            header('Location: index.php?page=indexcomment');
            
            }

        echo $this->twig->render("backend/comments/editcomment.html.twig",[
            'activemenu' => 'commentmenu',
            'editcomment' => $editComment
        ]);
    }
}