<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
        <title><?= $title ?></title>
        <link rel="icon" type="image/png" href="assets/images/avatar.png" />

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Candal&family=Lato&display=swap" rel="stylesheet">
        
        <!-- CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/admin.css">
        <link rel="stylesheet" href="assets/css/navbar.css">

    </head>
    <body>
    <!-- SIDEBAR -->
    <div class="sidemenu">
        <div class="close-btn">
            <i class="fa fa-times"></i>
        </div>
        <div class="sidebar">
            <div class="profil-image">
                <img src="assets/images/avatar.png" alt="avatar">
            </div>
            <div class="sidebar-menu">   
                <ul>
                    <li><a href="?page=dashboard" class="nav-link <?php if($activeMenu == 'dashboardmenu'): ?> active <?php endif; ?>"><span class="fas fa-tachometer-alt"></span><span>Dashboard</span></a></li>
                    <li><a href="?page=indexpost" class="nav-link <?php if($activeMenu == 'postmenu'): ?> active <?php endif; ?>"><span class="far fa-file-alt"></span><span>Posts</span></a></li>
                    <?php if($this->issetSession('auth','role') && $this->getSession('auth','role') == 2): ?>
                        <li><a href="?page=indexcomment" class="nav-link <?php if($activeMenu == 'commentmenu'): ?> active <?php endif; ?>"><span class="fas fa-comments"></span><span>Comments</span></a></li>
                    <?php endif; ?>
                    <li><a href="?page=indexuser" class="nav-link <?php if($activeMenu == 'usermenu'): ?> active <?php endif; ?>"><span class="fas fa-user"></span><span>Users</span></a></li>
                    <?php if($this->issetSession('auth','role') && $this->getSession('auth','role') == 2): ?>
                        <li><a href="?page=indextag" class="nav-link <?php if($activeMenu == 'tagmenu'): ?> active <?php endif; ?>"><span class="fas fa-tag"></span><span>Tags</span></a></li>  
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-content">
        <!-- NAVBAR -->
        <header>
            <div class="nav-btn">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <?php if($this->issetSession('auth')): ?>
                <ul class="user-wrapper">
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if($this->issetSession('auth','picture')): ?>
                                <img src="assets/images/<?= $this->getSession('auth','picture') ?>" alt="user-pic" width="60px;">
                            <?php else: ?>
                                <img src="assets/images/default.png" alt="user-pic" width="60px;">
                            <?php endif; ?>
                            <?= $this->getSession('auth','name') ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="index.php?page=home">Home</a>
                            <a class="dropdown-item" href="index.php?page=logout"><i class="fas fa-sign-out-alt text-danger"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            <?php endif; ?>

        </header>
    
    <?= $bodyAdmin ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
    <script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>
    
    <script src="assets/js/main.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        ClassicEditor
            .create( document.querySelector('#content') )
            .then( editor => {
                config.height = 1000;
                console.log( editor );
            } )  
            .catch( error => {
                console.error( error );
            } );
        </script>
    </body>
</html>
