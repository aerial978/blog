<?php $title = 'Index Posts'; ?>

<?php ob_start(); ?>
<!-- INDEX POSTS  -->
    <section>
        <div class="content">
            <div class="content-header">
                <h4 class="title title-post">Manage Posts</h4>
                <div class="link-btn">
                    <a href="?page=addpost" class="add-btn post-btn btn"><i class="fas fa-plus"></i> Post</a>
                </div>
            </div>
            <!-- TABLE POSTS -->
            <?php if(empty($indexPosts)): ?>
                    <div class="alert alert-danger show" role="alert">
                        <h4 class="text-center">Empty list !</h4>  
                    </div>    
                <?php  else: ?> 
                    <table class="table table-post">
                        <thead> 
                            <tr class="table-title table-primary">
                                <th class="col-1">#</th>
                                <th class="col-1">User</th>
                                <th class="col-1">Date</th>
                                <th class="col-4">Title</th>
                                <th class="col-1">Image</th>
                                <th class="col-1">Comments</th>
                                <th class="col-1">Status</th>
                                <th class="col-2">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                        <?php foreach ($indexPosts as $indexPost): ?>
                            <tr data-id="<?php $indexPost['postId']; ?>">
                                <th scope="row"><?php $indexPost['postId']; ?></th>
                                <td><?= $indexPost['name']; ?></td>
                                <td class="date_create"><?php $indexPost['date_create'] ?></td>
                                <td class="table-bold"><?php $indexPost['title']; ?></td>
                                <td class="status-image">
                                    <?php if(!empty($indexPost['image']) && $indexPost['image'] != NULL): ?>
                                        <img src="<?php "assets/images/".$indexPost['image']; ?>" alt="post-pic" width="100px;"></td>
                                    <?php else: ?>
                                        <img src="assets/images/land-default.png" alt="img-post">
                                    <?php endif; ?>
                                </td>
                                <td class="comments"><?php $indexPost['total']; ?></td>
                                <td class="status">
                                <?php if($indexPost['status_post'] == 2): ?>
                                    <h6 style="color: green;"><?php echo 'published'; ?></h6>
                                <?php else: ?>
                                    <h6 style="color: red;"><?= 'unpublished' ?></h6>
                                <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-button">
                                        <a href="index.php?page=editpost&id=<?php $indexPost['postId']; ?>" class="btn edit-post btn-primary"><i class="far fa-edit"></i><span> edit</span></a>
                                        <a data-id="<?php $indexPost['postId']; ?>" href="index.php?page=deletepost&id=<?php $indexPost['postId']; ?>" class="delete-btn btn btn-danger"><i class="fas fa-times"></i> <span> delete</span></a>
                                    </div>
                                </td>
                            </tr>      
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            <!-- CARDS POSTS -->
            <div class="cards cards-post">
                <div class="container">
                    <div class="row">
                    <?php foreach($indexPosts as $indexPost): ?>
                        <div data-id="<?= htmlentities($indexPost['postId']) ?>" class="col-lg-4 col-sm-6"> 
                            <div class="card border-dark mb-3" style="max-width: 20rem;">     
                                <div class="card-header card-post">
                                    <div class="id"><span><?php $indexPost['postId']; ?></span></div>
                                    <div class="status">
                                    <?php if($indexPost['status_post'] == 2): ?>
                                        <h6 style="color: green;"><?php echo 'published'; ?></h6>
                                    <?php else: ?>
                                        <h6 style="color: red;"><?php echo 'unpublished'; ?></h6>
                                    <?php endif; ?>
                                    </div>
                                    <div class="card-comment"><span class="fa-stack fa-1x"><i class="far fa-comment fa-stack-2x"></i><?php $indexPost['total']; ?></span></div>
                                </div>
                                <div class="card-body image">
                                    <img src="<?php "assets/images/".$indexPost['image']; ?>" alt="img-post">
                                </div>    
                                <div class="card-body h-50 text-dark">
                                    <h5 class="card-title h-50"><?php $indexPost['title']; ?></h5>
                                </div>
                                <div class="card-footer card-post border-success">    
                                    <div class="action-button">
                                        <a href="?page=editpost&id=<?php $indexPost['postId']; ?>"class="edit-post action-btn btn btn-primary"><i class="far fa-edit"></i> edit</a>
                                        <a data-id="<?= $indexPost['postId'] ?>" href="?page=deletepost&id=<?= $indexPost['postId'] ?>" class="delete-btn btn btn-danger"><i class="fas fa-times"></i> <span> delete</span></a>    
                                    </div>
                                </div>   
                            </div>
                        </div> 
                    <?php endforeach; ?>    
                    </div>        
                </div>         
            </div>
        </div>
    </section>
</div>
<?php $bodyAdmin = ob_get_clean(); ?>

<?php require('view/headers/headerbackend.php'); ?>

<script>
    $(document).ready(function () {
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            var postId = $(this).attr("data-id");
            Swal.fire({
                title: "Delete confirmation ?",
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'ok',
                confirmButtonColor: '#1aBC9C',
            }).then((result) => {   
                if (result.isConfirmed) {
                    let sourceUrl = window.location.href.split('/');
                    let newUrl = sourceUrl[0] + '//' + sourceUrl[2] + '/' + sourceUrl[3] + '/' + href;
                    $.ajax({
                        url: newUrl,
                        type: 'GET',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success:function(){
                            Swal.fire({
                                title: "Data delete successfully !",
                                text: "",
                                icon: "success",
                                confirmButtonColor: '#1aBC9C',
                            });
                            $(`tr[data-id=${postId}]`).remove();
                            $("div[data-id="+postId+"]").remove();       
                        }
                    });
                }
            })
        });
    });    
</script>