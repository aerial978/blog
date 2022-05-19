<?php $title = 'Login'; ?>

<?php ob_start(); ?>
<!-- LOGIN AREA -->
<section class="sign section">
    <div class="container">
        <div class="row">
            <div class="sign-form col-md-5 mx-auto">
                <h3 class="sign-title text-center">Login</h3>
                <?php if(!empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible show pt-5" role="alert">
                        <p>You have not completed the form correctly :</p>
                        <ul>
                            <?php foreach($errors as $error): ?>
                                <li><?= $error; ?></li>  
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>     
                    </div>    
                <?php endif; ?>
                <form method="post" action="index.php?page=login">
                    <fieldset class="form-group row">
                    <input type="hidden" name="csrf_token" value="<?= $token ?>">  
                        <div class="form-field col-md-12">
                            <label for="username" class="label">Username</label>
                            <input type="text" class="form-control" name="username" id="username"/>  
                        </div>
                        <div class="form-field col-md-12">
                            <label for="password" class="label">Password</label>
                            <input type="password" class="form-control" name="password" id="password"/>        
                        </div>
                        <div class="pass-link">
                        <a href="?page=forget">Forgot password ?</a>
                        </div>
                    </fieldset>
                    <button type="submit" class="submit-btn">Sign in</button>  
                </form>
                <div class="sign-link">
                    <h5>Not a member ?<a href="?page=register"> Sign up</a></h5>
                </div>
            </div>    
        </div>
    </div>
</section>
<?php $form = ob_get_clean(); ?>

<?php require('view/headers/headerform.php'); ?>

                        
