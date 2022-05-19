<?php $title = 'Reset'; ?>

<?php ob_start(); ?>
<!-- RESET AREA -->   
<section class="sign section">
    <div class="container">
        <div class="row">
            <div class="sign-form col-md-5 mx-auto">
                <h3 class="sign-title text-center">Password reset</h3>
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
                    <input type="text" name="csrf_token" value="<?= $token ?>">
                    <?php var_dump($token); ?>
                    <?php var_dump($_SESSION['csrf_token']); ?>     
                    <div class="form-field col-md-12">
                            <label for="password" class="label">New password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="At least 8 characters"/>        
                        </div>
                        <div class="form-field col-md-12">
                            <label for="password" class="label">Confirm new password</label>
                            <input type="password" class="form-control" name="password_confirm" id="password_confirm"/>        
                        </div>  
                    </fieldset>
                    <button type="submit" class="submit-btn">Reset</button>  
                </form>
            </div>    
        </div>
    </div>
</section>
<?php $form = ob_get_clean(); ?>

<?php require('view/headers/headerform.php'); ?>