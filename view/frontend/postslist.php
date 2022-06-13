<?php $title = 'Posts List'; ?>

<?php ob_start(); ?>
<!-- POST LIST -->
<section class="list-section">
    <div class="container">
        <div class="row">
            <div class="col-xl-9">
                <div class="row row-cols-1 row-cols-md-2 g-4 pb-4">    
                <?php foreach($posts as $post): ?>
                        <div class="col">
                            <div class="card">
                                <img src="<?= "assets/images/".$post['image'] ?>" alt="img post" class="card-img-top">
                                <div class="card-body">    
                                    <div class="card-top mb-2 d-flex justify-content-between align-items-center mb-4">
                                        <span class="card-user fst-italic"><i class="fas fa-user-alt"></i>
                                        <a href="?page=userposts&id=<?= $post['user_id']; ?>">
                                        <?php $post['name']; ?></a></span>
                                        <div class="card-date"><i class="far fa-calendar"></i>&nbsp;<span><?= $post['date_create']; ?></span></div>
                                        <span class="badge"><a href="?page=tagposts&id=<?= $post['tag_id']; ?>"><?= $post['tagname']; ?></a></span>
                                    </div>
                                    <div class="card-content">
                                    <h6 class="card-title"><?= $post['title']; ?></h6>
                                    <p class="card-head"><?= $post['headline']; ?></p>
                                    <p class="card-text"><span><?= $this->number_words($post['content']); ?></span></p>
                                    </div>
                                    <div class="card-meta d-flex justify-content-between">
                                        <span class="fa-stack fa-1x"><i class="far fa-comment fa-stack-2x"></i><?= $post['comment_count']; ?></span>    
                                        <a class="btn btn-primary" href="?page=postsingle&id=<?= $post['postId']; ?>" role="button">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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

                        
