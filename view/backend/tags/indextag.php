<?php $title = 'Index Tags'; ?>

<?php ob_start(); ?>
<!-- INDEX TAGS -->
    <section>
        <div class="content">
            <div class="content-header">
                <h4 class="title title-tag">Manage Tags</h4>
                <div class="link-btn">
                <a href="?page=addtag" class="tag-btn add-btn btn"><i class="fas fa-plus"></i> Tag</a>
                </div>
            </div>
            <!-- TABLE TAGS -->
            <?php if(empty($listTags)): ?>
                <div class="alert alert-danger show" role="alert">
                    <h4 class="text-center">Empty list !</h4>  
                </div>    
            <?php  else: ?> 
                <div class="container">
                    <table class="table table-tag">
                        <thead>
                            <tr class="table-title table-primary">   
                                <th class="col-2">#</th>
                                <th class="col-6">Tag name</th>
                                <th class="col-4">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            <?php foreach($listTags as $listTag): ?>
                                <tr data-id="<?= $listTag['id']; ?>">
                                    <th scope="row"><?= $listTag['id']; ?></th>
                                    <td class="tagname"><?= $listTag['tagname']; ?></td>
                                    <td>
                                        <div class="action-button">
                                        <a href="?page=edittag&id=<?= $listTag['id']; ?>" class="btn edit-post btn-primary"><i class="far fa-edit"></i><span> edit</span></a>
                                        <a data-id="<?= $listTag['id'] ?>" href="?page=deletetag&id=<?= $listTag['id'] ?>" class="delete-btn btn btn-danger"><i class="fas fa-times"></i><span> delete</span></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>   
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
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