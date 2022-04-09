<?php

require_once 'model/commentManager.php';

class commentsController {

    public function indexcomment()
    { 
        $activeMenu = 'commentmenu';

        $commentManager = new commentManager();
        $indexComments = $commentManager->indexComment();
        
        require('view/backend/comments/indexcomment.php');

        if(isset($_SESSION['update']) && $_SESSION['update'] != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $_SESSION['update'] ?>",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        unset($_SESSION['update']);
        }

        if(isset($_SESSION['process']) && $_SESSION['process'] != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $_SESSION['process'] ?>",
                    icon: 'error',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        unset($_SESSION['process']);
        }
    }

    public function editcomment()
    { 
        $activeMenu = 'commentmenu';

        if(isset($_GET['id'])) {

            $id = $_GET['id'];
            
            $commentManager = new commentManager();
            $editComment = $commentManager->editComment($id); 
            }
            
            if (!empty($_POST) && isset($_POST)) {
            
            if(isset($_POST['status_comm']) && $_POST['status_comm'] == 2) {
                $status_comm = $_POST['status_comm'];
            } else {
                $status_comm = 1; 
            }
            
            $commentManager = new commentManager();
            $statusComment = $commentManager->statusComment($status_comm,$id);
            
            $_SESSION['update'] = 'Update successfully !'; 
            header('Location: index.php?page=indexcomment');
            }
        
        require('view/backend/comments/editcomment.php');   
    }

    public function deletecomment()
    {
        if(isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
            
            $commentManager = new commentManager();
            $deleteComment = $commentManager->deleteComment($id);

            if($deleteComment == NULL) {
                $_SESSION['danger'] = "There was a problem with a data processing !";
            }
            header('Location: index.php?page=indexcomment');
        }
    }
}