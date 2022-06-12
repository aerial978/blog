<?php $title = 'Index Comments'; ?>

<?php ob_start(); ?>
<!-- INDEX COMMENTS -->
    <section>
        <div class="content">
            <div class="content-header">
                <h4 class="title title-comment">Manage Comments</h4>
            </div>
            <!-- TABLE COMMENTS -->
            <?php if(empty($indexComments)): ?>
                <div class="alert alert-danger show" role="alert">
                    <h4 class="text-center">Empty list !</h4>  
                </div>    
            <?php  else: ?> 
                <table class="table table-comment">
                    <thead>
                        <tr class="table-title table-primary">
                            <th class="col-1"># Post</th>
                            <th class="col-2">Author</th>
                            <th class="col-2">Email</th>
                            <th class="col-1">Date</th>
                            <th class="col-3">Post title</th>
                            <th class="col-1">Status</th>
                            <th class="col-2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                    <?php foreach($indexComments as $indexComment): ?>
                        <tr data-id="<?= htmlspecialchars($indexComment['commentId']); ?>">
                            <th scope="row"><?= $indexComment['post_id'] ?></th>
                            <th class="name_author"><?= $indexComment['name_author'] ?></th>
                            <td class="email_author"><?= $indexComment['email_author'] ?></td>
                            <td class="date_comment"><?= $indexComment['date_comment'] ?></td>
                            <td class="post-title"><small><?= $indexComment['title'] ?></small></td>
                            <td class="status"><?php if($indexComment['status_comm'] == 2) { ?>
                                <h6 style="color: green;"><?php echo 'published'; ?></h6>
                                <?php } else { ?><h6 style="color: red;"><?php echo 'unpublished'; } ?></h6></td>
                            </td>
                            <td>
                                <div class="action-button">
                                    <a href="?page=editcomment&id=<?= $indexComment['commentId'] ?>" class="btn edit-post btn-primary"><i class="far fa-edit"></i> edit</a>
                                    <a data-id="<?= $indexComment['commentId']; ?>" href="index.php?page=deletecomment&id=<?= $indexComment['commentId'] ?>" class="btn delete-btn btn-danger"><i class="fas fa-times"></i> delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>  
                    </tbody>
                </table>
            <?php endif; ?>
            <!-- CARDS COMMENTS -->   
            <div class="cards cards-comment">
                <div class="container">
                    <div class="row">
                    <?php foreach($indexComments as $indexComment): ?>
                        <div data-id="<?= $indexComment['commentId']; ?>" class="col-lg-6 col-sm-6">
                            <div class="card border-dark mb-3" style="max-width: 20rem;">
                                <div class="card-header card-com">
                                    <div class="comment-id w-50 d-flex justify-content-between">
                                        <div class="id"><span># <?= $indexComment['post_id'] ?></span></div>
                                    </div>
                                    <div class="comment-date"><?= $indexComment['date_comment'] ?></div>
                                </div>
                                <div class="card-header card-com">
                                    <div class="comment-id w-50 d-flex justify-content-between">
                                        <div class="auth-com"><?= $indexComment['name_author'] ?></div>
                                    </div>
                                    <div class="email_author"><?= $indexComment['email_author'] ?></div>
                                </div>
                                <div class="card-body text-dark">
                                    <h5 class="post-title"><?= $indexComment['title'] ?></h5>
                                    <p class="comment-text"><span class="far fa-comment">&thinsp;</span><?= $indexComment['comment'] ?></p>
                                </div>
                                <div class="card-footer card-com border-success d-flex justify-content-around">
                                    <div class="status status-red d-flex align-items-center">
                                        <?php if($indexComment['status_comm'] == 2): ?>
                                            <h6 style="color: green;"><?php echo 'published'; ?></h6>
                                            <?php else: ?>
                                            <h6 style="color: red;"><?php echo 'unpublished'; ?></h6>
                                        <?php endif; ?>
                                    </div>
                                    <a href="?page=editcomment&id=<?= $indexComment['commentId'] ?>" class="edit-post action-btn btn btn-primary"><i class="far fa-edit"></i> edit</a>
                                    <a data-id="<?= $indexComment['commentId']; ?>" href="index.php?page=deletecomment&id=<?= htmlentities($indexComment['commentId']) ?>" class="delete-btn action-btn btn btn-danger"><i class="fas fa-times"></i> delete</a>
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
            var commentId = $(this).attr("data-id");
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
                            $(`tr[data-id=${commentId}]`).remove();
                            $("div[data-id="+commentId+"]").remove();       
                        }
                    });
                }
            })
        });
    });    
</script>
