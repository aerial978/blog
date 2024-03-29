<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="icon" type="image/png" href="assets/images/avatar.png" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Candal&family=Lato&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="?page=home">Michel HATHIER</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse dual-collapse2">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($activeMenu == 'homemenu') : ?> active <?php endif; ?>" href="?page=home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($activeMenu == 'postsmenu') : ?> active <?php endif; ?>" href="?page=postslist">Posts</a>
                    </li>
                </ul>
                <?php if ($this->issetSession2('auth')) : ?>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="?page=register">Sign up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=login">Sign in</a>
                        </li>
                    </ul>
                <?php endif; ?>
                <ul class="navbar-nav">
                    <?php if ($this->issetSession('auth')) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php if ($this->issetSession('auth', 'picture')) : ?>
                                    <img src="assets/images/<?= $this->getSession('auth', 'picture'); ?>" alt="user-pic" width="70px;">
                                <?php else : ?>
                                    <img src="assets/images/default.png" alt="user-pic" width="70px;">
                                <?php endif; ?>
                                <?= $this->getSession('auth', 'name'); ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="?page=dashboard">Dashboard</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="index.php?page=logout"><i class="fas fa-sign-out-alt text-danger"></i> Logout</a>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?= $content; ?>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 social-network d-flex align-items-center justify-content-center">
                    <a href="https://github.com/aerial978"><i class="fab fa-github-square"></i></a>
                    <a href="https://fr.linkedin.com/in/mh4125"><i class="fab fa-linkedin"></i></a>
                </div>
                <div class="col-lg-4">
                    <div class="menu-footer">
                        <h4 class="pb-2 border-bottom">Menu</h4>
                        <ul class="navbar-nav m-auto">
                            <li class="nav-item">
                                <a class="nav-link <?php if ($activeMenu == 'homemenu') : ?> active <?php endif; ?>" href="?page=home">
                                    <small>Home</small>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($activeMenu == 'postsmenu') : ?> active <?php endif; ?>" href="?page=postslist">
                                    <small>Posts</small>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?page=register">
                                    <small>Sign up</small>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?page=login">
                                    <small>Sign in</small>
                                </a>
                            </li>
                        </ul>
                    </div>    
                </div>
                <div class="col-lg-4 d-flex align-items-center flex-column">
                    <img src="assets/images/avatar.png" alt="avatar" width="150px;">  
                </div>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="assets/js/main.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>