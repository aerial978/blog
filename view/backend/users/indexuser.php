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
                            <tr data-id="<?= $indexUser['id']; ?>">
                                <th scope="row"><?= $indexUser['id']; ?></th>
                                <td class="user-img">
                                <?php if(!empty($indexUser['picture']) && $indexUser['picture'] != NULL): ?>
                                    <img src="assets/images/<?= $indexUser['picture']; ?>" alt="user-pic"></td>
                                <?php else: ?>
                                    <img src="assets/images/default.png" alt="user-pic">
                                <?php endif; ?>
                                </td>
                                <td class="table-bold"><?= $indexUser['name']; ?></td>           
                                <td><?= $indexUser['username']; ?></td>
                                <td><?= $indexUser['email']; ?></td>
                                <td><?= $indexUser['role'] == 2 ? 'super admin' : 'admin' ?></td>
                                <td>
                                    <div class="action-button">
                                        <a href="?page=edituser&id=<?= $indexUser['id']; ?>" class="edit-post action-btn btn btn-primary"><i class="far fa-edit"></i> edit</a>
                                        <a data-id="<?= $indexUser['id']; ?>" href="?page=deleteuser&id=<?= $indexUser['id'] ?>" class="delete-btn action-btn btn btn-danger"><i class="fas fa-times"></i> delete</a>
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
                        <div data-id="<?= $indexUser['id']; ?>" class="col-lg-4 col-sm-4 col-6">
                            <div class="card border-dark mb-3">
                                <div class="card-header card-user"> 
                                    <div class="id"><span># <?= $indexUser['id']; ?></span></div>
                                    <div class="status"><span><?= $indexUser['role'] == 2 ? 'super admin' : 'admin' ?></span></div>
                                </div>    
                                <div class="card-body h-75">
                                    <?php if(!empty($indexUser['picture']) && $indexUser['picture'] != NULL): ?>
                                        <img src="assets/images/<?= $indexUser['picture']; ?>" alt="user-pic"></td>
                                    <?php else: ?>
                                        <img src="assets/images/default.png" alt="user-pic">
                                    <?php endif; ?>
                                </div>
                                <div class="card-userdetail text-dark">
                                    <h5 class="card-name"><?=$indexUser['name']; ?></h5>
                                    <h6 class="card-email"><?= $indexUser['email']; ?></h6>
                                </div>
                                <div class="card-footer card-user border-success">
                                    <div class="action-button">
                                    <a href="?page=edituser&id=<?= $indexUser['id'] ?>" class="btn edit-post btn-primary"><i class="far fa-edit"></i><span> edit</span></a>
                                    <a data-id="<?= $indexUser['id']; ?>" href="index.php?page=deleteuser&id=<?= $indexUser['id'] ?>" class="delete-btn btn-danger p-2" style="text-decoration:none; border-radius:3px"><i class="fas fa-times"></i><span> delete</span></a>
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
                    e.preventDefault();
                    let sourceUrl = window.location.href.split('/');
                    let newUrl = sourceUrl[0] + '//' + sourceUrl[2] + '/' + sourceUrl[3].replace('?page=indexuser', '') + href;
                    $.ajax({
                        url: newUrl,
                        type: 'GET',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success:function(data) {
                            console.log(data);
                            let array = JSON.parse(data);
                            if(array.code == 200 && array.role == 1) {
                                Swal.fire({
                                    title: "Do you want to delete this account ?",
                                    text: "",
                                    icon: "warning",
                                    confirmButtonColor: '#1aBC9C',
                                }).then((result) => {
                                    if(result.isConfirmed) {
                                        Swal.fire({
                                            title: "Data delete successfully !",
                                            text: "",
                                            icon: "success",
                                            confirmButtonColor: '#1aBC9C',
                                        }).then((result) => {
                                            if(result.isConfirmed) {
                                                $(`tr[data-id= ${id} ]`).remove();
                                                $("div[data-id=" + id +"]").remove();  
                                                window.location.href = sourceUrl[0] + '//' + sourceUrl[2] + '/' + 'index.php?page=logout2';
                                            }       
                                        })
                                    }
                                })
                            } else if (array.code == 500){
                                Swal.fire({
                                    title: array.message,
                                    text: "",
                                    icon: "warning",
                                    confirmButtonColor: '#1aBC9C',
                                });
                            }
                        }
                    })
                } 
            })
        })
    });
</script>