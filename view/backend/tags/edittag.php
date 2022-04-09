<?php $title = 'Edit Tags'; ?>

<?php ob_start(); ?>
<!-- EDIT TAG FORM -->
    <section>
        <div class="content">
            <div class="content-header">
                    <h4 class="title title-tag">Edit Tags</h4>
            </div>
            <div class="create">
                <div class="container">
                    <?php if(!empty($_SESSION['errors'])): ?>
                        <div class="alert alert-danger alert-dismissible show pt-5" role="alert">
                            <p>You have not completed the form correctly :</p>
                            <ul>
                                <?php foreach($_SESSION['errors'] as $error) : ?>
                                    <li><?= $error; ?></li>  
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>     
                        </div>    
                    <?php endif; ?>
                    <form method="post" action="">
                        <fieldset class="form-group form-tag row g-0">
                            <div class="form-field col-lg-12">
                                <label for="nametag">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="<?= isset($_SESSION['input']['name']) && !empty($_SESSION['input']['name']) ? $_SESSION['input']['name'] : $tagId['name'] ?>">
                            </div>
                            <div class="form-field col-lg-12">
                                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                                <textarea name="description" id="content" class="form-control"><?= isset($_SESSION['input']['description']) && !empty($_SESSION['input']['description']) ? $_SESSION['input']['description'] : $tagId['description'] ?></textarea>
                            </div>
                            <div class="btn-tag d-flex justify-content-between">
                            <button type="submit" name="submit" class="submit-tag submit-btn">Update tag</button>
                                <a class="submit-btn submit-tag" href="?page=indextag" role="button"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                            </div>
                        </fieldset>
                    </form>
                </div>                 
            </div>
        </div>
    </section>
</div>
<?php $bodyAdmin = ob_get_clean(); ?>

<?php require('view/backend/basebackend.php'); ?>        