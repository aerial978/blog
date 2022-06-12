<!-- ASIDE TAGS LIST -->
<aside class="aside-tags mb-4">
    <h5 class="tags-title">Tags</h5>
    <ul>
        <?php foreach ($listTags as $listTag) { ?>
            <li>
                <a href="?page=tagposts&id=<?php $listTag['id']; ?>"><?php $listTag['tagname']; ?></a>
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
                        <img src="<?php "assets/images/" . $posts[$i]['image']; ?>" class="img-recent img-fluid">
                        <div class="title-recents">
                            <h6><a href="?page=postsingle&id=<?php $posts[$i]['postId']; ?>"><?php $posts[$i]['title']; ?></a></h6>
                            <p><a href="?page=userposts&id=<?php $posts[$i]['user_id']; ?>"><?php $posts[$i]['name']; ?></a></p>
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
                <a href="?page=postsingle&id=<?php $comment['post_id']; ?>"><?php $comment['name_author']; ?><span> sur </span><?php $comment['title']; ?></a>
            </li>
            </li>
        <?php } ?>
    </ul>
</aside>