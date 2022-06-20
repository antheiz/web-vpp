<?php

require_once "core/init.php";

if ($user->is_loggedIn()) {
    Redirect::to('dashboard');
}

$errors = array();

if (isset($_POST['submit'])) {

    if (Token::check($_POST['token'])) {

        // Call Validation Object

        $validation = new Validation();

        // Check Method
        $validation = $validation->check(array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));


        // Check Passed
        if ($validation->passed()) {

            // Menguji username apakah sudah atau belum terdaftar di Database
            if ($user->check_username($_POST['username'])) {
                if ($user->login_user($_POST['username'], $_POST['password'])) {
                    Session::set('username', $_POST['username']);
                    Redirect::to('dashboard');
                } else {

                    $errors[] = "Login gagal";
                }
            } else {

                $errors[] = "Silahkan coba lagi";
            }
        } else {
            $errors = $validation->errors();
        }
    } // end of input token

} // endof submit form

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in - Virtual Power Plant</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/app.css">
</head>

<body>
    <div id="auth">

        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card pt-4">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <img src="assets/images/favicon.svg" height="48" class='mb-4'>
                                <h3>Sign In</h3>
                                <p>Please sign in to continue to Dashboard.</p>
                                <?php if (!empty($errors)) { ?>

                                    <?php foreach ($errors as $error) : ?>
                                        <div class="alert alert-danger">
                                            <?php echo $error; ?>
                                        </div>
                                    <?php endforeach; ?>

                                <?php } ?>

                                <?php if (Session::exists('index')) { ?>
                                    <div class="alert alert-info">
                                        <?php echo Session::flash('index'); ?>
                                    </div>
                                <?php } ?>

                            </div>
                            <form method="POST">
                                <div>
                                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <label for="username">Username</label>
                                    <div class="position-relative">
                                        <input type="text" name="username" class="form-control" id="username">
                                        <div class="form-control-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="clearfix">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="position-relative">
                                        <input type="password" name="password" class="form-control" id="password">
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class='form-check clearfix my-4'>
                                    <div class="checkbox float-start">
                                        <input type="checkbox" id="checkbox1" class='form-check-input'>
                                        <label for="checkbox1">Remember me</label>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <button types="submit" name="submit" class="btn btn-primary float-end">Sign In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script src="assets/js/main.js"></script>
</body>

</html>