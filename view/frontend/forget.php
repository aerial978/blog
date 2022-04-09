<?php $title = 'Forget'; ?>

<?php ob_start(); ?>
<!-- FORGET AREA -->   
<section class="sign section">
    <div class="container">
        <div class="row">
            <div class="sign-form col-md-5 mx-auto">
                <h3 class="sign-title text-center">Forgot password</h3>
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
                        <div class="form-field col-md-12">
                            <label for="email" class="label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="email@address.com" value=""/>        
                        </div>   
                    </fieldset>
                    <button type="submit" class="submit-btn">Submit</button>  
                </form>
            </div>    
        </div>
    </div>
</section>
<?php $form = ob_get_clean(); ?>

<?php require('baseform.php'); ?>
