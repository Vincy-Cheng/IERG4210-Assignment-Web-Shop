<?php
include_once('auth.php');
?>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>
    <header class="text-center">
        <h1>IERG 4210 e-shop Sign UP Page</h1>
        <a href="/">Back to index page</a>
    </header>

    <div class="d-flex justify-content-center mt-4">
        <form id="sigupform" action="auth_process.php?action=<?php echo htmlspecialchars($action = 'signup'); ?>" method="POST" class="login-box rounded bg-light border border-dark" onsubmit="return signupsubmit(event)">
            <div class="my-2 mx-2">
                <h3 class="text-center">Sign Up</h3>
            </div>
            <div class="my-2 mx-2">
                <label for="email">Email:</label>
                <div>
                    <input id="signup_email" type="email" class="form-control" name="email" placeholder="example@example.com" require>
                </div>
                <div class="invalid-feedback ">
                    Email can't be empty!
                </div>

            </div>
            <div class="my-2 mx-2">
                <label for="email">Username:</label>
                <div>
                    <input id="signup_username" type="text" class="form-control" name="username"  require>
                </div>
                <div class="invalid-feedback ">
                    Username can't be empty!
                </div>

            </div>
            <div class="my-2 mx-2">
                <label for="password">Password:</label>
                <div>
                    <input id="signup_pwd" type="password" class="form-control" name="password" placeholder="Your Password" require>
                </div>
                <div class="invalid-feedback ">
                    Password can't be empty!
                </div>

            </div>
            <div class="my-2 mx-2">
                <label for="password">Confirm Password:</label>
                <div>
                    <input id="signup_conpwd" type="password" class="form-control" name="conpassword" placeholder="Confirm Password" require>
                </div>
                <div class="invalid-feedback ">
                    Password not the same!
                </div>

            </div>

            <button type="submit" class="btn btn-danger mx-2 my-2">Submit</button>
            <input type="hidden" name="nonce" value="<?php echo htmlspecialchars(ierg4210_csrf_getNonce($action)); ?>">

        </form>
    </div>

    <script src="scripp.js"></script>
</body>

</html>

<!-- regular expression reference link -->
<!-- https://dl.icewarp.com/online_help/203030104.htm -->