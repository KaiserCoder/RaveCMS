<form action="<?= WEB_ROOT ?>/admin/account" method="post">
    <div class="form-group">
        <label for="login">Login</label>
        <input class="form-control" type="text" id="login" name="login" value="<?= $login ?>"/>
    </div>
    <div class="form-group">
        <label>Modify password</label>
        <input type="checkbox" id="check" name="changePassword"/>
    </div>
    <div id="hidden">
        <div class="form-group">
            <label for="oldPassword">Old password</label>
            <input class="form-control" type="password" id="oldPassword" name="oldPassword"/>
        </div>
        <div class="form-group">
            <label for="newPassword">New password</label>
            <input class="form-control" type="password" id="newPassword" name="newPassword"/>
        </div>
    </div>
    <div class="form-group">
        <input class="btn btn-default" type="submit" name="submit" value="Modify"/>
    </div>
</form>

<script>
    $('#hidden').hide();

    $('#check').change(function () {
        if (this.checked) {
            $('#hidden').show();
        } else {
            $('#hidden').hide();
        }
    });
</script>