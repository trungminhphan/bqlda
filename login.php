<?php
function __autoload($class_name) {
   require_once('cls/class.' . strtolower($class_name) . '.php');
}
require_once('inc/functions.inc.php');
$session = new SessionManager();
$users = new Users();

if($users->isLoggedIn()){
    transfers_to('index.php');
}
require('inc/config.inc.php');

if(isset($_POST['login'])){
    $username = $_POST['username'] ? $_POST['username'] : '';
    $password = $_POST['password'] ? $_POST['password'] : '';

    if ($users->authenticate($username, $password)) {
        transfers_to("index.php");
    } else {
        $alert = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Quản lý công văn - Ban quản lý dự án đầu tư xây dựng tỉnh An Giang.">
    <meta name="keywords" content="Quản lý công văn, Trung tâm Tin học Ban quản lý dự án đầu tư xây dựng tỉnh An Giang">
    <meta name="author" content="Phan Minh Trung">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
    <title>Quản lý công văn - Ban quản lý dự án đầu tư xây dựng tỉnh An Giang</title>
    <link href="css/metro.css" rel="stylesheet">
    <link href="css/metro-icons.css" rel="stylesheet">
    <link href="css/metro-responsive.css" rel="stylesheet">
    <link href="css/metro-schemes.css" rel="stylesheet">
    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/metro.js"></script>
</head>
    <style>
        .login-form {
            width: 25rem;
            height: 18.75rem;
            position: fixed;
            top: 50%;
            margin-top: -9.375rem;
            left: 50%;
            margin-left: -12.5rem;
            background-color: #ffffff;
            opacity: 0;
            -webkit-transform: scale(.8);
            transform: scale(.8);
        }
    </style>
    <script>
        $(function(){
            var form = $(".login-form");
            form.css({
                opacity: 1,
                "-webkit-transform": "scale(1)",
                "transform": "scale(1)",
                "-webkit-transition": ".5s",
                "transition": ".5s"
            });
            <?php if(isset($alert) && $alert == true) : ?>
                $.Notify({type: 'alert', caption: 'Thất bại', content: "Vui lòng điền đúng tài khoản và mật khẩu"});
            <?php endif; ?>
        });
    </script>
</head>
<body style="background-color: #067FD9;">
    <div class="login-form padding20 block-shadow">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" data-role="validator" data-show-required-state="false" data-hint-background="bg-red" data-hint-color="fg-white" data-hide-error="5000">
            <h1 class="text-light">Đăng nhập hệ thống</h1>
            <h4>BQLDA Đầu tư Xây dựng tỉnh An Giang.</h4>
            <hr class="thin"/>
            <br />
            <div class="input-control text full-size" data-role="input">
                <label for="user_login">Tài khoản:</label>
                <input type="text" name="username" id="username" value="<?php echo isset($username) ? $username : ''; ?>" data-validate-func="required" data-validate-hint="Vui lòng nhập tài khoản đăng nhập."/>
                <span class="input-state-error mif-warning"></span>
                <span class="input-state-success mif-checkmark"></span>
            </div>
            <br />
            <br />
            <div class="input-control password full-size" data-role="input">
                <label for="user_password">Mật khẩu:</label>
                <input type="password" name="password" id="password" data-validate-func="required" data-validate-hint="Vui lòng nhập mật khẩu đăng nhập." />
                <span class="input-state-error mif-warning"></span>
                <span class="input-state-success mif-checkmark"></span>
            </div>
            <br />
            <br />
            <div class="form-actions">
                <button type="submit" name="login" id="login" class="button primary"><span class="mif-checkmark"></span> Đăng nhập</button>
            </div>
        </form>
    </div>
</body>
</html>
