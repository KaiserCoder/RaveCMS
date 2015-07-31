<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Title</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($comments as $comment): ?>
            <tr>
                <td><?= $comment->title ?></td>
                <td><a href="<?= WEB_ROOT ?>/admin/delete-comment/<?= $comment->id ?>">X</a></td>
                <td><a href="<?= WEB_ROOT ?>/admin/update-comment/<?= $comment->id ?>">Update</a></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>