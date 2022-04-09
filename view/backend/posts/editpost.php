<?php $title = 'Edit Post'; ?>

<?php ob_start(); ?>
<!-- EDIT POST FORM -->
    <section>
        <div class="content">
            <div class="content-header">
                <h4 class="title title-post">Edit Posts</h4>
            </div>
            <div class="edit">
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
                    <form method="post" action="index.php?page=editpost&id=<?= $editPost['postId'] ?>" enctype="multipart/form-data">
                        <fieldset class="form-group form-post row g-0">                
                            <div class="form-field col-lg-12">
                                <label for="author">Author</label>
                                <input type="text" name="username" id="username" class="form-control" disabled value="<?= $editPost['username'] ?>">
                            </div>
                            <div class="form-field col-lg-12">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" <?php if($_SESSION['id'] != $editPost['id']) : ?> readonly <?php endif; ?> value="<?= isset($_SESSION['input']['title']) && !empty($_SESSION['input']['title']) ? $_SESSION['input']['title'] : $editPost['title'] ?>">
                            </div>
                            <?php var_dump($_SESSION['id']); ?><?php var_dump($editPost['id']); ?>
                            
                            <div class="form-field col-lg-12">
                                <label for="headline">Headline</label>
                                <input type="text" name="headline" id="headline" class="form-control" <?php if($_SESSION['id'] != $editPost['id']) { ?> readonly <?php } ?> value="<?= isset($_SESSION['input']['headline']) && !empty($_SESSION['input']['headline']) ? $_SESSION['input']['headline'] : $editPost['headline'] ?>">
                            </div>
                            
                            <div class="form-field col-lg-12">
                                <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                                <textarea name="content" <?php if($_SESSION['id'] == $editPost['id']) { ?> id="content" <?php } ?> rows="8" class="form-control" <?php if($_SESSION['id'] != $editPost['id']) { ?> readonly <?php } ?>><?= isset($_SESSION['input']['content']) && !empty($_SESSION['input']['content']) ? $_SESSION['input']['content'] : $editPost['content'] ?></textarea>
                            </div>
                            <div class="form-field col-lg-12 d-flex flex-column">
                                <label for="formFile" class="form-label">Image</label>
                                <?php if(!empty($editPost['image']) && $editPost['image'] != NULL): ?>
                                    <img src="assets/images/<?= isset($_SESSION['picture']['name']) ? $_SESSION['picture']['name'] : $editPost['image']; ?>" alt="post-pic" width="200px;">
                                    <?= isset($_SESSION['picture']['name']) ? basename($_SESSION['picture']['name']) : basename($editPost['image']); ?>
                                <? else: ?>
                                    <img src="assets/images/land-default.png" alt="post-pic" width="200px;">
                                <?php endif; ?>
                            </div>  
                            <div class="form-field col-lg-12">  
                                <input type="file" name="image" id="image" class="form-control" <?php if($_SESSION['id'] != $editPost['id']) { ?> disabled <?php } ?>>
                            </div>
                            <div class="form-field col-lg-12">
                                <label for="tags">Tag category</label>
                                <select name="tag" id="tag" class="form-control" <?php if($_SESSION['id'] != $editPost['id']) { ?> readonly <?php } ?>>
                                    <option value="0">Select option</option>
                                        <?php if(count($selectTag)>0) : ?>
                                            <?php for ($i=0; $i<count($selectTag); $i++) : ?>
                                                <option value="<?= $selectTag[$i]['id']?>"<?= isset($editPost['tag_id']) && $selectTag[$i]['id'] == $editPost['tag_id'] ? "selected" : "" ?>><?= $selectTag[$i]['name']?></option>
                                            <?php endfor; ?>    
                                    <?php endif; ?>    
                                </select>
                            </div>
                            <?php if (isset($_SESSION['auth_role']) && $_SESSION['auth_role'] == 2): ?>
                                <div class="form-check">
                                    <input type="checkbox" name="status_post" class="form-check-input" value="2" <?php if(isset($editPost['status_post']) && $editPost['status_post'] == 2) { echo "checked='checked'"; } ?> id="checkbox">
                                    <label class="form-check-label" for="checkbox">Published</label>
                                </div>
                            <?php endif; ?>
                            <div class="btn-post d-flex justify-content-between">
                                <button type="submit" name="submit" class="submit-post submit-btn">Update post</button>
                                <a class="submit-btn submit-post" href="?page=indexpost" role="button"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Back</a>    
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