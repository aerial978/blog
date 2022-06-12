<?php $title = 'Index Users'; ?>

<?php ob_start(); ?>
<!-- INDEX USERS  -->
<section>
    <div class="content">
        <div class="content-header">
            <h4 class="title title-user">Manage Users</h4>
            <?php if($this->issetSession('auth','role') && $this->getSession('auth','role') == 2) : ?>
                <div class="link-btn">
                <a href="?page=adduser" class="user-btn add-btn btn"><i class="fas fa-plus"></i> User</a>
                </div>
            <?php endif; ?>
        </div>
        <!-- TABLE USERS -->
        <?php if(empty($indexUsers)): ?>
            <div class="alert alert-danger show" role="alert">
                <h4 class="text-center">Empty list !</h4>  
            </div>    
        <?php  else: ?>
            <div class="container">
                <table class="table table-user">
                    <thead>
                        <tr class="table-title table-primary">   
                            <th class="col-1">#</th>
                            <th class="col-1">User</th>
                            <th class="col-2">Name</th>
                            <th class="col-2">Username</th>
                            <th class="col-2">Email</th>
                            <th class="col-1">Status</th>
                            <th class="col-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        <?php foreach ($indexUsers as $indexUser): ?> 
                            <tr data-id="<?php $indexUser['id']; ?>">
                                <th scope="row"><?php $indexUser['id']; ?></th>
                                <td class="user-img">
                                <?php if(!empty($indexUser['picture']) && $indexUser['picture'] != NULL): ?>
                                    <img src="assets/images/<?php $indexUser['picture']; ?>" alt="user-pic"></td>
                                <?php else: ?>
                                    <img src="assets/images/default.png" alt="user-pic">
                                <?php endif; ?>
                                </td>
                                <td class="table-bold"><?php $indexUser['name']; ?></td>           
                                <td><?php $indexUser['username']; ?></td>
                                <td><?php $indexUser['email']; ?></td>
                                <td><?php $indexUser['role'] == 2 ? 'super admin' : 'admin' ?></td>
                                <td>
                                    <div class="action-button">
                                        <a href="?page=edituser&id=<?php $indexUser['id']; ?>" class="edit-post action-btn btn btn-primary"><i class="far fa-edit"></i> edit</a>
                                        <a data-id="<?php $indexUser['id']; ?>" href="?page=deleteuser&id=<?php $indexUser['id'] ?>" class="delete-btn action-btn btn btn-danger"><i class="fas fa-times"></i> delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <!-- CARD USERS -->
        <div class="cards cards-user">
            <div class="container">
                <div class="row">
                    <?php foreach($indexUsers as $indexUser): ?> 
                        <div data-id="<?php $indexUser['id']; ?>" class="col-lg-4 col-sm-4 col-6">
                            <div class="card border-dark mb-3">
                                <div class="card-header card-user"> 
                                    <div class="id"><span># <?php $indexUser['id']; ?></span></div>
                                    <div class="status"><span><?php $indexUser['role'] == 2 ? 'super admin' : 'admin' ?></span></div>
                                </div>    
                                <div class="card-body h-75">
                                    <?php if(!empty($indexUser['picture']) && $indexUser['picture'] != NULL): ?>
                                        <img src="assets/images/<?php $indexUser['picture']; ?>" alt="user-pic"></td>
                                    <?php else: ?>
                                        <img src="assets/images/default.png" alt="user-pic">
                                    <?php endif; ?>
                                </div>
                                <div class="card-userdetail text-dark">
                                    <h5 class="card-name"><?php $indexUser['name']; ?></h5>
                                    <h6 class="card-email"><?php $indexUser['email']; ?></h6>
                                </div>
                                <div class="card-footer card-user border-success">
                                    <div class="action-button">
                                    <a href="?page=edituser&id=<?php $indexUser['id'] ?>" class="btn edit-post btn-primary"><i class="far fa-edit"></i><span> edit</span></a>
                                    <a data-id="<?php $indexUser['id']; ?>" href="index.php?page=deleteuser&id=<?php $indexUser['id'] ?>" class="delete-btn btn-danger p-2" style="text-decoration:none; border-radius:3px"><i class="fas fa-times"></i><span> delete</span></a>
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
<?php $bodyAdmin = ob_get_clean(); ?>

<?php require('view/headers/headerbackend.php'); ?>

<script>
    $(document).ready(function () {
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            var id = $(this).attr("data-id");
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
                            $(`tr[data-id=${id}]`).remove();
                            $("div[data-id="+id+"]").remove();       
                        }
                    });
                }
            })
        });
    });    
</script>
