<form action="<?= WEB_ROOT ?>/admin/update-photo/<?= $photo->id ?>" method="post">
    <div class="form-group">
        <label>Title</label>
        <input class="form-control" type="text" name="title" value="<?= $photo->title ?>"/>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" name="description"><?= $photo->description ?></textarea>
    </div>
    <div class="form-group">
        <label>Tags</label>
        <input class="form-control" type="text" name="tags" value="<?= $photo->tags ?>"/>
    </div>
    <div class="form-group">
        <input class="btn btn-default" type="submit" name="submit" value="Update"/>
    </div>
</form>