<?php $title = 'Add Tags'; ?>

<?php ob_start(); ?>
<!-- ADD POST FORM -->
    <section>
        <div class="content">
            <div class="content-header">
                    <h4 class="title title-tag">Create Tag</h4>
            </div>
            <div class="create">
                <div class="container">
                    <?php if($this->issetSession('errors')): ?>
                        <div class="alert alert-danger alert-dismissible show pt-5" role="alert">
                            <p>You have not completed the form correctly :</p>
                            <ul>
                                <?php foreach($this->getSession('errors') as $error) : ?>
                                    <li><?= $error; ?></li>  
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>     
                        </div>    
                    <?php endif; ?>
                    <form method="post" action="">
                        <fieldset class="form-group form-tag row g-0">
                            <div class="form-field col-lg-12">
                                <label for="tagname">Name</label>
                                <input type="text" name="tagname" id="tagname" class="form-control" value="<?= $this->issetSession('input','tagname') ? $this->getSession('input','tagname') : "" ?>">
                            </div>
                            <div class="form-field col-lg-12">
                                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                                <textarea name="description" id="content" class="form-control"><?= $this->issetSession('input','description') ? $this->getSession('input','description') : "" ?></textarea>
                            </div>
                            <div class="btn-tag d-flex justify-content-between">
                            <button type="submit" name="submit" class="submit-tag submit-btn">Add tag</button>
                            <a class="submit-btn submit-tag" href="index.php?page=indextag" role="button"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
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
