<?php $title = 'Post Single'; ?>

<?php ob_start(); ?>

<!-- SINGLE POST AREA -->
<section class="single-section">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="mb-4">
                    <span class="badge mb-3"><a href="?page=tagposts&id=<?= $singlePost['tag_id'] ?>"><?= $singlePost['name'] ?></a></span>
                    <h4 class="fw-bolder mb-2"><?= $singlePost['title'] ?></h4>
                    <h6 class="mb-2 fst-italic">By <a href="?page=userposts&id=<?= $singlePost['user_id'] ?>"><?= $singlePost['username'] ?></a></h6>
                    <div class="text-muted fst-italic mb-2">Posted on <?= $singlePost['date_create'] ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <figure class="mb-4"><img src="<?="assets/images/".$singlePost['image'] ?>" alt="image post" class="img-fluid rounded" ></figure>
                <div class="mb-1">
                    <p class="card-text fw-bolder fs-4 mb-4"><?= $singlePost['headline'] ?></p>
                    <p class="card-text fs-5 mb-4"><?= $this->number_words($singlePost['content']) ?></p>
                </div>
    <!-- COMMENTS AREA -->
                <div class="comment-area mt-5 mb-5" id="comments">
                    <div class="mb-4">
                        <div class="fw-bolder">
                            <?php foreach($countCommentsPosts as $countCommentsPost): ?>
                                <h5 class="comment-number"><?= $countCommentsPost['total'] ?> comment(s)</h5>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php foreach($listComments as $listComment): ?>            
                        <div class="comment-list" style="background-color: #e5e5e5;">
                            <div class="comment-id d-flex justify-content flex-start">
                                <div class="meta-area d-flex flex-column">
                                    <div class="comment-author fw-bolder"><?= $listComment['name_author'] ?></div>
                                    <div class="comment-datetime"><?= $listComment['date_comment'] ?></div>
                                </div>
                            </div>
                            <div class="comment-content"><?= $listComment['comment'] ?></div>
                        </div>
                    <?php endforeach; ?>
                    <div class="mb-4">
                        <h3 class="comment-form fw-bolder text-primary">Leave a comment</h3>
                    </div> 
                    <div class="comment-moderate mb-4">
                        <h6 class="fw-bolder">Comments on this blog are moderated.</h6>
                        <p>Your email address will not be published. Required fields are indicated with *</p>
                    </div>                      
                    <form method="post" action="">         
                        <div class="row">
                            <?php if(!empty($errors)): ?>
                                <div class="alert alert-danger alert-dismissible show" role="alert">
                                    <p>You have not completed the form correctly :</p>
                                    <ul>
                                        <?php foreach($errors as $error): ?>
                                            <li><?= $error; ?></li>  
                                        <?php endforeach; ?>
                                    </ul>
                                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>     
                                </div>    
                            <?php endif; ?>
                            <div class="form-group col-md-12">
                                <label for="author">Name *</label>
                                <input type="text" class="form-control" name="name_author" id="name_author">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="author">Email *</label>
                                <input type="text" class="form-control" name="email_author" id="email_author">
                            </div>
                            <div class="form-group">
                                <label for="message">Comment *</label>
                                <textarea class="form-control" name="comment" id="comment" rows="5"></textarea>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="comment-btn btn btn-primary" href="#comments">Send</button>
                    </form>  
                </div>
            </div>
            <div class="col-xl-3">
            <?php include 'view/partials/asides.php'; ?> 
            </div>

        </div>
    </div>       
</section>
<?php $content = ob_get_clean(); ?>

<?php require('view/headers/headerfrontend.php'); ?>                        
