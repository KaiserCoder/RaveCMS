<form action="<?= WEB_ROOT ?>/admin/update-comment/<?= $comment->id ?>" method="post">
    <div class="form-group">
        <label>Title</label>
        <input class="form-control" type="text" name="title" value="<?= $comment->title ?>"/>
    </div>
    <div class="form-group">
        <label>Author</label>
        <input class="form-control" type="text" name="author" value="<?= $comment->author ?>"/>
    </div>
    <div class="form-group">
        <label>Content</label>
        <textarea class="form-control" name="content"><?= $comment->content ?></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-default" type="submit" name="submit" value="Update"/>
    </div>
</form>