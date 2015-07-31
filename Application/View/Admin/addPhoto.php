<form action="<?= WEB_ROOT ?>/admin/add-photo" method="post" enctype="multipart/form-data" onsubmit="valid()">
    <div class="form-group">
        <label>Title</label>
        <input class="form-control" type="text" name="title"/>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" name="description"></textarea>
    </div>
    <div class="form-group">
        <label>Tags</label>
        <input id="tags" class="form-control" type="text" name="tags"/>
    </div>
    <div class="form-group">
        <label>Photo</label>
        <input type="file" name="photo"/>
    </div>
    <div class="form-group">
        <input class="btn btn-default" type="submit" name="submit" value="Add"/>
    </div>
</form>