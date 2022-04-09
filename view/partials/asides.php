<!-- ASIDE TAGS LIST -->    
<aside class="aside-tags mb-4">
    <h5 class="tags-title">Tags</h5> 
    <ul>
        <?php foreach ($listTags as $listTag) { ?>
            <li>
            <a href="?page=tagposts&id=<?= $listTag['id'] ?>"><?= $listTag['name']; ?></a>
            </li>
        <?php } ?> 
    </ul>     
</aside>                
<!-- ASIDE RECENTS POSTS LIST -->
<aside class="aside-posts mb-4">
    <h5 class="posts-title">Recent posts</h5> 
    <ul>
        <?php foreach ($posts as $post) { ?>
            <li>
                <div class="recent-post">
                    <img src="<?= "assets/images/".$post['image']; ?>" class="img-recent img-fluid">
                    <div class="title-recents">
                        <h6><a href="?page=postsingle&id=<?= $post['postId'] ?>"><?= $post['title'] ?></a></h6>
                        <p><a href="?page=userposts&id=<?= $post['user_id'] ?>"><?= $post['username'] ?></a></p>
                    </div>
                </div>
            </li>
        <?php } ?>      
    </ul>     
</aside>        
<!-- ASIDE RECENTS COMMENTS LIST -->
<aside class="aside-comments">
    <h5 class="posts-title">Recent comments</h5> 
    <ul>
        <?php foreach ($comments as $comment) { ?>
            <li>
                <li>
                <a href="?page=postsingle&id=<?=$comment['post_id']?>"><?= $comment['name_author'] ?><span> sur </span><?= $comment['title']; ?></a>
                </li>
            </li>
        <?php } ?>
    </ul>    
</aside>                                                                    