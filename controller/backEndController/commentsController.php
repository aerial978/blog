<?php

use blogmvc\model\commentManager;

class commentsController extends baseController
{
    public function __construct()
    {
        $this->authentification();
    }

    public function indexcomment()
    { 
        $activeMenu = 'commentmenu';

        $commentManager = new commentManager();
        $indexComments = $commentManager->indexComment();
        
        require 'view/backend/comments/indexcomment.php';

        if($this->issetSession('update') && $this->getSession('update') != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $this->getSession('update'); ?>",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        $this->unsetSession('update');
        }

        if($this->issetSession('process') && $this->getSession('process') != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $this->getSession('process'); ?>",
                    icon: 'error',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        $this->unsetSession('process');
        }
    }

    public function editcomment()
    { 
        $activeMenu = 'commentmenu';

        if($this->issetGet('id')) {
            $id = $this->getGet('id');
            
            $commentManager = new commentManager();
            $editComment = $commentManager->editComment($id); 
            }
            
            if ($this->issetpost()) {  
                if($this->issetPost('status_comm') && $this->getPost('status_comm') == 2) {
                    $status_comm = $this->getPost('status_comm');
                } else {
                    $status_comm = 1; 
                }
            
                $commentManager = new commentManager();
                $statusComment = $commentManager->statusComment($status_comm,$id);
                
                $this->setSession('update','Update successfully !');
                header("Location: index.php?page=indexcomment");
            }
        
        require ('view/backend/comments/editcomment.php');   
    }

    public function deletecomment()
    {
        if($this->issetGet('id') && !empty($this->getGet('id'))) {
            $commentManager = new commentManager();
            $getcomment = $commentManager->getComment($this->getGet('id'));

            $to         = $getcomment['email_author'];
            $subject    = 'Your comment on a blog post';
            $message    = "We are sorry that your comment was not accepted.</a>";
            $headers    = 'MIME Version 1.0\r\n';
            $headers    = 'From: Your name <info@address.com>' . "\r\n";
            $headers   .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

            mail($to, $subject, $message, $headers);

            $commentManager = new commentManager();
            $deleteComment = $commentManager->deleteComment($this->getGet('id'));

            if($deleteComment == NULL) {
                $this->setSession('danger',"There was a problem with a data processing !");
            }

            header('Location: index.php?page=indexcomment');
        }
    }
}