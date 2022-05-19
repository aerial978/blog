<?php $title = 'Register'; ?>

<?php ob_start(); ?>
<!-- REGISTER AREA -->
<section class="sign section">
    <div class="container">
        <div class="row">
            <div class="sign-form col-md-5 mx-auto">            
                <h3 class="sign-title text-center">Register</h3>
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
                <form method="post" action="">
                    <fieldset class="form-group row">
                    <input type="hidden" name="csrf_token" value="<?= $token ?>">
                        <div class="form-field col-md-12">
                            <label for="username" class="label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="At least 8 characters" value="<?= isset($_SESSION['input']['username']) ? $_SESSION['input']['username'] : "" ?>"/>  
                        </div>
                        <div class="form-field col-md-12">
                            <label for="email" class="label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="email@address.com" value="<?= isset($_SESSION['input']['email']) ? $_SESSION['input']['email'] : "" ?>"/>        
                        </div>
                        <div class="form-field col-md-12">
                            <label for="password" class="label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="At least 8 characters"/>        
                        </div>
                        <div class="form-field col-md-12">
                            <label for="password" class="label">Confirm password</label>
                            <input type="password" class="form-control" name="password_confirm" id="password_confirm"/>        
                        </div>
                        <small>By clicking <span>sign up</span> you agree to this site to keep 
                            your personal data via this form.</small>
                        
                    </fieldset>
                        <button type="submit" class="submit-btn">Sign up</button>  
                </form>
                <div class="sign-link">
                    <h5>Already a member ?<a href="?page=login"> Sign in</a></h5>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $form = ob_get_clean(); ?>

<?php require('view/headers/headerform.php'); ?>