<?php $title = 'Edit User'; ?>

<?php ob_start(); ?>
<!-- EDIT USER FORM -->
    <section>
        <div class="content">
            <div class="content-header">
                <h4 class="title title-user">Edit User</h4>
            </div>
            <div class="edit">
                <div class="container">
                    <?php if ($this->issetSession('errors')) : ?>
                        <div class="alert alert-danger alert-dismissible show pt-5" role="alert">
                            <p>You have not completed the form correctly :</p>
                            <ul>
                                <?php foreach ($this->getSession('errors') as $error) : ?>
                                    <li><?= $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="index.php?page=edituser&id=<?= $editUser['id'] ?>" enctype="multipart/form-data">
                        <fieldset class="form-group form-user row g-0">
                            <div class="form-field col-lg-12">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" <?php if ($this->getSession('auth','id') != $editUser['id']) : ?> disabled <?php endif; ?> value="<?= $editUser['username'] ?>">
                            </div>
                            <div class="form-field col-lg-12">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" readonly value="<?= $editUser['name'] ?>">
                            </div>
                            <div class="form-field col-lg-12 d-flex flex-column mb-3">
                                <label for="formFile" class="form-label">Image</label>
                                <?php if (!empty($editUser['picture']) && $editUser['picture'] != NULL) : ?>
                                    <img src="assets/images/<?= $this->issetSession('picture','name') ? htmlentities($this->getSession('picture','name')) : $editUser['picture']; ?>" alt="" width="115px;">
                                    <?= $this->issetSession('picture','name') ? basename($this->getSession('picture','name')) : basename($editUser['picture']); ?>
                                <?php else :  ?>
                                    <img src="assets/images/default.png" alt="pic-user" width="115px;">
                                <?php endif; ?>
                            </div>
                            <div class="form-field col-lg-12">
                                <input type="file" name="picture" id="image" class="form-control" <?php if ($this->getSession('auth','id') != $editUser['id']) : ?> disabled <?php endif; ?>>
                            </div>
                            <div class="form-field col-lg-12">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="email@address.com" <?php if ($this->getSession('auth','id') != $editUser['id']) : ?> disabled <?php endif; ?> value="<?= $this->issetSession('input','email') ? $this->getSession('input','email') : $editUser['email'] ?>">
                            </div>
                            <div class="form-field col-lg-12">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" <?php if ($this->getSession('auth','id') != $editUser['id']) : ?> disabled <?php endif; ?>>
                            </div>
                            <div class="form-field col-lg-12">
                                <label for="password" class="col-sm-2 col-form-label">Confirm password</label>
                                <input type="password" class="form-control" name="password_confirm" id="password_confirm" <?php if ($this->getSession('auth','id') != $editUser['id']) : ?> disabled <?php endif; ?>>
                            </div>
                            <?php if ($this->issetSession('auth','role') && $this->getSession('auth','role') == 2) : ?>
                                <div class="form-check">
                                    <input type="checkbox" name="role" class="form-check-input mt-3" value="2" <?php if (isset($editUser['role']) && $editUser['role'] == 2) {echo "checked='checked'";} ?> id="checkbox">                                                                                
                                    <label class="form-check-label" for="checkbox">Super admin</label>
                                </div>
                            <?php endif; ?>
                            <div class="btn-user d-flex justify-content-between">
                                <button type="submit" name="submit" class="submit-user submit-btn">Update user</button>
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