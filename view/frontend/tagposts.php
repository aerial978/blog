<?php $title = 'Tag Posts'; ?>

<?php ob_start(); ?>       
<!-- POSTS LIST BY TAG -->
<section class="tag-section">
    <div class="container">
        <div class="title_tag mb-4 h4"><?= $tag['tagname'] ?></div> 
        <div class="row">
            <div class="col-xl-9">
                <div class="row row-cols-1 row-cols-md-2 g-4 pb-4">
                    <?php if(empty($tagPosts)): ?>
                        <div class="alert alert-danger show" role="alert">
                        <h4 class="text-center">Empty list !</h4>  
                    </div>    
                    <?php  else : ?>
                        <?php foreach($tagPosts as $tagPost): ?>
                            <div class="col">
                                <div class="card">
                                    <img src="<?= "assets/images/".$tagPost['image']; ?>" alt="img post" class="card-img-top">
                                    <div class="card-body">    
                                        <div class="card-top mb-2 d-flex justify-content-between align-items-center mb-4">
                                            <span class="card-user fst-italic"><i class="fas fa-user-alt"></i>
                                            <a href="?page=userposts&id=<?= $tagPost['user_id']; ?>"><?= $tagPost['name']; ?></a></span>
                                            <div class="card-date"><i class="far fa-calendar"></i>&nbsp;<span><?= $tagPost['date_create']; ?></span></div>
                                            <span class="badge"><?= $tagPost['tagname']; ?></span>
                                        </div>
                                        <div class="card-content">
                                            <h6 class="card-title"><?= $tagPost['title']; ?></h6> 
                                            <p class="card-head"><?= $tagPost['headline']; ?></p>
                                            <p class="card-text"><?= $this->number_words($tagPost['content']); ?></span></p>
                                        </div>
                                        <div class="card-meta d-flex justify-content-between">
                                            <span class="fa-stack fa-1x"><i class="far fa-comment fa-stack-2x"></i><?= $tagPost['comment_count']; ?></span>     
                                            <a class="btn btn-primary" href="?page=postsingle&id=<?= $tagPost['postId']; ?>" role="button">Read More</a>
                                        </div>
                                    </div>        
                                </div>
                            </div> 
                        <?php endforeach; ?>
                    <?php endif; ?>

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