<?php

use blogmvc\model\postManager;
use blogmvc\model\tagManager;
use blogmvc\model\commentManager;
use blogmvc\model\userManager;

class dashboardController extends baseController
{
    public function __construct()
    {
        $this->authentification();
    }
        
    public function dashboard()
    {   
        $activeMenu = 'dashboardmenu';
    
        $postManager = new postManager();
        $countPosts = $postManager->countPosts();

        $commentManager = new commentManager();
        $countComments = $commentManager->countComments();

        $userManager = new userManager();
        $countUsers = $userManager->countUsers();

        $tagManager = new tagManager();
        $countTags = $tagManager->countTags();
        
        require('view/backend/dashboard.php');

        if($this->issetSession('login') && $this->getSession('login') != "") { ?>        
            <script>
                Swal.fire({
                    title: "<?php print htmlentities($this->getSession('login')); ?>",
                    text: "You are identified now !",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
            $this->unsetSession('login');
        } 

        if($this->issetSession('alreadylog') && $this->getSession('alreadylog') != "") { ?>
            <script>
                Swal.fire({
                title: "<?= $this->getSession('alreadylog'); ?>",
                icon: "error",
                confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        $this->unsetSession('alreadylog');
        }
    }
}
