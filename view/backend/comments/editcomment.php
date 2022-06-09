<?php $title = 'Edit Comment'; ?>

<?php ob_start(); ?>
            <!-- EDIT COMMENT FORM -->
            <section>
                <div class="content">
                    <div class="content-header">
                        <h4 class="title title-comment">Edit Comments</h4>
                    </div>
                    <div class="edit">
                        <div class="container">
                            <form method="post" action="">
                                <fieldset class="form-group form-comment row g-0">   
                                    <div class="form-field col-lg-12">
                                        <label for="name_author">Author</label>
                                        <input type="text" name="name_author" id="name_author" disabled class="form-control" value="<?= $editComment['name_author'] ?>">
                                    </div>
                                    <div class="form-field col-lg-12">
                                        <label for="date_comment">Date</label>
                                        <input type="text" name="date_comment" id="date_comment" disabled class="form-control" value="<?= $editComment['date_comment'] ?>">
                                    </div>
                                    <div class="form-field col-lg-12">
                                        <label for="post_id">Title post</label>
                                        <input type="text" name="post_id" id="post_id" disabled class="form-control" value="<?= $editComment['title'] ?>">
                                    </div>
                                    <div class="form-field col-lg-12">
                                        <label for="" class="form-label">Content</label>
                                        <textarea name="comment" id="comment" class="form-control" readonly id="exampleFormControlTextarea1" rows="5"><?= $editComment['comment'] ?></textarea>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="status_comm" class="form-check-input" value="2" <?php if(isset($editComment['status_comm']) && $editComment['status_comm'] == 2) {echo "checked='checked'";} ?> id="checkbox">
                                        <label class="form-check-label" for="checkbox">Published</label>
                                    </div>
                                    <div class="btn-comment d-flex justify-content-between">
                                        <button type="submit" name="submit" class="submit-comment submit-btn">Update comment</button>
                                        <a class="submit-btn" href="?page=indexcomment" role="button"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
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
