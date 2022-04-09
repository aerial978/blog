<?php $title = 'Add Post'; ?>

<?php ob_start(); ?>
<!-- ADD POST FORM -->
    <section>     
        <div class="content">
            <div class="content-header">
                <h4 class="title title-post">Create Posts</h4>
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
                    <form method="post" action="" enctype="multipart/form-data">
                        <fieldset class="form-group form-post row g-0">
                            <div class="form-field col-lg-12">
                                <label for="author">Author</label>
                                <input type="text" name="username" id="username" class="form-control" disabled value="<?= $_SESSION['username'] ?>">
                            </div>  
                            <div class="form-field col-lg-12">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" value="<?= isset($_SESSION['input']['title']) ? $_SESSION['input']['title'] : "" ; ?>">
                            </div>
                            <div class="form-field col-lg-12">
                                <label for="headline">Headline</label>
                                <input type="text" name="headline" id="headline" class="form-control" value="<?= isset($_SESSION['input']['headline']) ? $_SESSION['input']['headline'] : "" ; ?>">
                            </div>
                            <div class="form-field col-lg-12">
                            <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                            <textarea name="content" id="content" class="form-control"><?= isset($_SESSION['input']['content']) ? $_SESSION['input']['content'] : "" ; ?></textarea>      
                            </div>
                            
                            <div class="form-field col-lg-12 file-input">
                                <label for="formFile" class="form-label">Image</label>
                                <input type="file" name="image" id="image" class="form-control" value="<?= isset($_SESSION['input']['image']) ? $_SESSION['input']['image'] : "" ; ?>">
                            </div>
                            <div class="form-field col-lg-12">
                                <label for="tags">Tag category</label>
                                <select name="tag" id="tag" class="form-control">
                                    <option value="0">Select option</option>
                                    <?php if(count($selectTag)>0) : ?>
                                        <?php for ($i=0; $i<count($selectTag); $i++) : ?>
                                            <option <?= isset($_SESSION['input']['tag']) && $_SESSION['input']['tag'] == $selectTag[$i]['id'] ? "selected" : "" ; ?> value="<?= $selectTag[$i]['id'];?>"><?= $selectTag[$i]['name'];?></option>
                                        <?php endfor; ?>    
                                    <?php endif; ?> 
                                </select>
                            </div>
                            <?php if (isset($_SESSION['auth_role']) && $_SESSION['auth_role'] == 2): ?>
                            <div class="form-check">
                                <input type="checkbox" name="status_post" class="form-check-input" value="2" <?php if(isset($posts['status_post']) && $posts['status_post'] == 2) { echo "checked='checked'"; } ?> id="checkbox">
                                <label class="form-check-label" for="checkbox">Published</label>
                            </div> 
                            <?php endif; ?>
                            <div class="btn-post d-flex justify-content-between">
                                <button type="submit" name="submit" class="submit-post submit-btn">Add post</button>
                                <a class="submit-btn submit-post" href="index.php?page=indexpost" role="button"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Back</a>    
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