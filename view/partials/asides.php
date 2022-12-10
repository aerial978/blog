<!-- ASIDE TAGS LIST -->
<aside class="aside-tags mb-4">
    <h5 class="tags-title">Tags</h5>
    <ul>
        <?php foreach ($listTags as $listTag) { ?>
            <li>
                <a href="?page=tagposts&id=<?= $listTag['id']; ?>"><?= $listTag['tagname']; ?></a>
            </li>
        <?php } ?>
    </ul>
</aside>
<!-- ASIDE RECENTS POSTS LIST -->
<aside class="aside-posts mb-4">
    <h5 class="posts-title">Recent posts</h5>
    <ul>
        <?php for ($i = 0; $i < 5; $i++) : ?>
            <?php if (isset($posts[$i])) : ?>
                <li>
                    <div class="recent-post">
                    <?php if (!empty($posts[$i]['image']) && $posts[$i]['image'] != NULL) : ?>
                        <img src="<?= "assets/images/" . $posts[$i]['image']; ?>" class="img-recent img-fluid" alt="image-post">
                    <?php else :  ?>
                        <img src="assets/images/land-default.png" alt="image-post" class="img-fluid">
                    <?php endif; ?>
                        <div class="title-recents">
                            <h6><a href="?page=postsingle&id=<?= $posts[$i]['postId']; ?>"><?= $posts[$i]['title']; ?></a></h6>
                            <p><a href="?page=userposts&id=<?= $posts[$i]['user_id']; ?>"><?= $posts[$i]['name']; ?></a></p>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
        <?php endfor; ?>
    </ul>
</aside>
<!-- ASIDE RECENTS COMMENTS LIST -->
<aside class="aside-comments">
    <h5 class="posts-title">Recent comments</h5>
    <ul>
        <?php foreach ($comments as $comment) { ?>
            <li>
            <li>
                <a href="?page=postsingle&id=<?= $comment['post_id']; ?>"><?= $comment['name_author']; ?><span> on </span><?= $comment['title']; ?></a>
            </li>
            </li>
        <?php } ?>
    </ul>
</aside>