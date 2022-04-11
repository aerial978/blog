<?php

class dashboardController
{
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

        if(isset($_SESSION['login']) && $_SESSION['login'] != "") { ?>        
            <script>
                Swal.fire({
                    title: "<?= $_SESSION['login'] ?>",
                    text: "You are identified now !",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
            unset($_SESSION['login']);
        } 
    }
}
