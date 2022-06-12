<?php $title = 'Dashboard'; ?>

<?php ob_start(); ?>
    <!-- DASHBOARD CARDS -->
    <section>
        <div class="content">
            <div class="content-header">
                <h4 class="title title-dash">Dashboard</h4>
            </div>
            <div class="dashboard">
                <div class="container">
                    <div class="row cards-dash">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-post mb-3" style="max-width: 20rem;">
                                <div class="card-body">
                                    <div class="card-info">
                                        <h2><?php $countPosts; ?></h2>
                                        <h4>Posts</h4>
                                    </div>
                                    <div class="card-icon">
                                        <i class="far fa-file-alt"></i>
                                    </div>
                                </div>
                                <div class="card-footer border-light">
                                    <a href="?page=indexpost">
                                        <h6>View details</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php if($this->issetSession('auth','role') && $this->getSession('auth','role') == 2) : ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-com mb-3" style="max-width: 20rem;">
                                <div class="card-body">
                                    <div class="card-info">
                                        <h2><?php $countComments; ?></h2>
                                        <h4>Comments</h4>
                                    </div>
                                    <div class="card-icon">
                                        <i class="fas fa-comments"></i>
                                    </div>
                                </div>
                                <div class="card-footer border-light">
                                    <a href="?page=indexcomment">
                                        <h6>View details</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-users mb-3" style="max-width: 20rem;">
                                <div class="card-body">
                                    <div class="card-info">
                                        <h2><?php $countUsers; ?></h2>
                                        <h4>Users</h4>
                                    </div>
                                    <div class="card-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div  class="card-footer border-light">
                                    <a href="?page=indexuser">
                                        <h6>View details</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php if($this->issetSession('auth','role') && $this->getSession('auth','role') == 2) : ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-tags mb-3" style="max-width: 20rem;">
                                <div class="card-body">
                                    <div class="card-info">
                                        <h2><?php $countTags; ?></h2>
                                        <h4>Tags</h4>
                                    </div>
                                    <div class="card-icon">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                </div>
                                <div class="card-footer border-light">
                                    <a href="?page=indextag">  
                                        <h6>View details</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>       
        </div>
    </section>
</div>
<?php $bodyAdmin = ob_get_clean(); ?>

<?php require('view/headers/headerbackend.php'); ?>

                        
