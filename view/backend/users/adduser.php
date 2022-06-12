<?php $title = 'Add Users'; ?>

<?php ob_start(); ?>
            <!-- ADD POST FORM -->
            <section>
                <div class="content">
                    <div class="content-header">
                        <h4 class="title title-user">Create User</h4>
                    </div>
                    <div class="create">
                        <div class="container">
                            <?php if($this->issetSession('errors')): ?>
                                <div class="alert alert-danger alert-dismissible show pt-5" role="alert">
                                    <p>You have not completed the form correctly :</p>
                                    <ul>
                                        <?php foreach($this->getSession('errors') as $error): ?>
                                            <li><?php $error; ?></li>  
                                        <?php endforeach; ?>
                                    </ul>
                                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>     
                                </div>    
                            <?php endif; ?>
                            <form method="post" action="" enctype="multipart/form-data">
                                <fieldset class="form-group form-user row g-0">
                                    <div class="form-field col-lg-12">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" id="username" class="form-control" placeholder="At least 8 characters, one lowercase letter, one uppercase letter, one number & one special character." value="<?php $this->issetSession('input','username') ? $this->getSession('input','username') : ""; ?>">
                                    </div>
                                    <div class="form-field col-lg-12">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="First character uppercase, the rest lowercase." value="<?php $this->issetSession('input','name') ? $this->getSession('input','name') : ""; ?>">
                                    </div>
                                    <div class="form-field col-lg-12 file-input">
                                        <label for="formFile" class="form-label">Image</label>
                                        <input type="file" name="picture" id="picture" class="form-control" value="<?php $this->issetSession('input','picture') ? $this->getSession('input','picture') : ""; ?>">
                                    </div>
                                    <div class="form-field col-lg-12">
                                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                                        <input type="email" name="email" id="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="email@address.com" value="<?php $this->issetSession('input','email') ? $this->getSession('input','email') : ""; ?>">
                                    </div>
                                    <div class="form-field col-lg-12">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" id="inputPassword" placeholder="At least 8 characters, one lowercase letter, one uppercase letter, one number & one special character.">
                                    </div>
                                    <div class="form-field col-lg-12">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Confirm password</label>
                                        <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                                    </div>
                                    <?php if ($this->issetSession('auth','role') && $this->getSession('auth','role') == 2): ?>
                                        <div class="form-check">
                                        <input type="checkbox" name="role" class="form-check-input mt-3" value="2" <?php if(isset($user['role']) && $user['role'] == 2) { echo "checked='checked'"; } ?> id="checkbox">
                                        <label class="form-check-label" for="checkbox">Super admin</label>
                                        </div>
                                    <?php endif; ?>
                                    <div class="btn-user d-flex justify-content-between">
                                    <button type="submit" name="submit" class="submit-user submit-btn">Add user</button>
                                    <a class="submit-btn submit-user" href="?page=indexuser" role="button"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                                    </div>
                                </fieldset>
                            </form>
                        </div>                 
                    </div>
                </div>
            </section>
        </div>
<?php $bodyAdmin = ob_get_clean(); ?>

<?php require('view/headers/headerbackend.php'); ?>
