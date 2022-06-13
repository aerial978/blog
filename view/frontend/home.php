<?php $title = 'Home'; ?>

<?php ob_start(); ?>
<!-- HERO -->
<header class="jumbotron text-center">
    <div class="intro">
        <img src="assets/images/avatar.png" alt="avatar">
        <h2 class="heading">Bienvenue sur mon blog de dev</h2>
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon">
                <i class="fa fa-star"></i>
            </div>
            <div class="divider-custom-line"></div>
        </div>
        <p class="subheading mb-5">PHP / Symfony Application Developer</p>
        <div class="social-network col-lg-12 mb-5 mb-lg-0">
            <a href="https://github.com/aerial978"><i class="fab fa-github-square"></i></a>
            <a href="https://fr.linkedin.com/"><i class="fab fa-linkedin"></i></a>
        </div>
    </div>
</header>
<!-- RECENTS POSTS -->
<section class="recent-posts section">
    <div class="container">
        <h2 class="text-center text-uppercase">Recent Posts</h2>
        <!--<h2 class="section-heading text-center text-uppercase">Recent Posts</h2>-->
        <div class="divider-custom divider-light mb-5">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon">
                <i class="fa fa-star"></i>
            </div>
            <div class="divider-custom-line"></div>
        </div>
        <div class="row">
            <div class="col-xl-8">    
                <?php foreach($posts as $post): ?>
                    <div class="row postcards g-0">
                        <div class="col-md-4">
                            <img src="<?= "assets/images/".$post['image']; ?>" class="img-fluid" alt="image post">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="card-top d-flex justify-content-between align-items-center mb-4">
                                    <span class="card-user fst-italic"><i class="fas fa-user-alt"></i>
                                    <a href="?page=userposts&id=<?= $post['user_id']; ?>">
                                    <?= " ".$post['name']; ?></a></span>
                                    <div class="card-date"><i class="far fa-calendar">&nbsp;</i><span><?= $post['date_create']; ?></span></div>
                                    <span class="badge"><a href="?page=tagposts&id=<?= $post['tag_id']; ?>"><?= $post['tagname']; ?></a></span>
                                </div>
                                <h6 class="card-title fw-bold"><?= $post['title']; ?></h6>
                                <p class="card-text fs-5"><?= $this->number_words($post['content']); ?></p>
                                <div class="card-meta d-flex justify-content-between">
                                    <span class="fa-stack fa-1x"><i class="far fa-comment fa-stack-2x"></i><?= $post['comment_count']; ?></span>
                                    <a href="?page=postsingle&id=<?= $post['postId'] ?>"class="btn btn-primary">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div> 
                <?php endforeach; ?>        
            </div>
            <div class="col-xl-4">
<!-- ASIDE TAGS LIST -->
                <aside class="aside-tags mb-4">
                    <h4 class="tags-title">Tags</h4> 
                    <ul>
                        <?php foreach($listTags as $listTag): ?>
                            <li>
                                <a href="?page=tagposts&id=<?= $listTag['id'] ?>"><?= $listTag['tagname']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>   
                </aside>
<!-- ASIDE RECENTS COMMENTS -->
                <aside class="aside-comments">
                    <h4 class="posts-title">Recent comments</h4> 
                    <ul>
                        <?php foreach($comments as $comment): ?>
                            <li>
                                <a href="?page=postsingle&id=<?= $comment['post_id']?>"><?= $comment['name_author'] ?><span> sur </span><?= $comment['title']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>    
                </aside>                                      
            </div>
        </div>
    </div>
</section>
<!-- ABOUT SECTION -->
<section class="about section">
    <div class="container">
        <h2 class="section-heading text-center text-uppercase">About me</h2>
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon">
                <i class="fa fa-star"></i>
            </div>
            <div class="divider-custom-line"></div>
        </div>
        <div class="row">
            <div class="col-lg-4 ms-auto">
                <p class="main-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris 
                    nisi ut aliquip ex ea commodo consequat.
                </p>
            </div>
            <div class="col-lg-4 me-auto">
                <p class="main-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris 
                    nisi ut aliquip ex ea commodo consequat.
                </p>
            </div>
        </div>
        <div class="text-center download">
            <a href="assets/pdf/cv.pdf" class="download-btn link-primary">Download CV <i class="fa fa-download"></i></a>
        </div>
    </div>
</section>
<!-- CONTACT SECTION -->
<section class="contact section" id="contact">
    <div class="container">
        <h2 class="section-heading text-center text-uppercase">Contact Me</h2>
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon">
                <i class="fa fa-star"></i>
            </div>
            <div class="divider-custom-line"></div>
        </div>
        <?php if(!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible show pt-5" role="alert">
                <p>You have not completed the form correctly :</p>
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?= $error; ?></li>  
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>     
            </div>    
        <?php endif; ?>
        <form method="post" action="" class="d-flex justify-content-center">
            <fieldset class="form-group row">
                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                <div class="form-field col-lg-12">
                    <input type="text" name="name" id="name" class="input-text" value="<?= $this->issetSession('input','name') ? $this->getSession('input','name') : ""; ?>"/>        
                    <label for="name" class="label">Name</label>
                </div>
                <div class="form-field col-lg-12">
                    <input type="email" name="email" id="email" class="input-text" value="<?= $this->issetSession('input','email') ? $this->getSession('input','email') : ""; ?>"/> 
                    <label for="email" class="label">Email address</label>
                </div>
                <div class="form-field col-lg-12">
                    <textarea id="textarea" name="message" class="input-text" rows="5" cols="50"><?= $this->issetSession('input','message') ? $this->getSession('input','message') : ""; ?></textarea>
                    <label for="textarea" class="label">Message</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkbox">
                    <label class="form-check-label" for="checkbox">J'autorise ce site à conserver mes données personnelles transmises via ce formulaire.</label>
                </div>
                <button type="submit" class="submit-btn" href="#contact">Send</button>
            </fieldset>
        </form>
    </div>
</section>
<?php $content = ob_get_clean(); ?>

<?php require('view/headers/headerfrontend.php'); ?>
