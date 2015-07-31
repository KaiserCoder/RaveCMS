<form action="<?= WEB_ROOT ?>/admin/login" method="post">
    <div class="form-group">
        <label for="login">Login</label>
        <input class="form-control" id="login" placeholder="Enter login" type="text" name="login"/>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" id="password" placeholder="Enter password" type="password" name="password"/>
    </div>
    <div class="form-group">
        <input class="btn btn-default" type="submit" name="submit" value="Login"/>
    </div>
</form>