<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Candal&family=Lato&display=swap" rel="stylesheet">
        
        <!-- CSS -->
        <link rel="stylesheet" href="../../../assets/css/style.css">
    </head>
    <body>
    <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="index.html">Michel HATHIER</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse dual-collapse2">
                    <ul class="navbar-nav m-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="postslist.html">Posts</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="register.html">Sign up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="login.html">Sign in</a>
                        </li>
                    </ul>
                </div>
            </div>  
        </nav>
        <!-- LOGIN AREA -->
        <section class="sign section">
            <div class="container">
                <div class="row">
                    <div class="sign-form col-md-5 mx-auto">
                        <h3 class="sign-title text-center">Login</h3>
                        <div class="message error text-light d-flex align-items-center justify-content-center">
                        <h5>Username required</h5>
                        </div>
                        <form method="post" action="">
                            <fieldset class="form-group row">    
                                <div class="form-field col-md-12">
                                    <label for="username" class="label">Username</label>
                                    <input type="text" class="form-control" name="username" id="username" required/>        
                                </div>
                                <div class="form-field col-md-12">
                                    <label for="password" class="label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" required/>        
                                </div>
                                <div class="pass-link">
                                <a href="#">Forgot password ?</a>
                                </div>
                            </fieldset>
                                <button type="submit" class="submit-btn">Sign in</button>  
                            </form>
                            <div class="sign-link">
                            <h5>Not a member ?<a href="register.html"> Sign up</a></h5>
                            </div>
                    </div>
                    
                </div>
            </div>
        </section>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script src="../../../assets/js/main.js"></script>
    
    </body>
</html>

                        
