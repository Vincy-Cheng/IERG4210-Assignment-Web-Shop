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
        <h1>IERG 4210 e-shop Login Page</h1>
        <a href="/">Back to index page</a>
    </header>

    <div class="d-flex justify-content-center mt-4">
        <form action="auth_process.php?action=<?php echo htmlspecialchars($action ='login');?>" method="POST" class="login-box rounded bg-light border border-dark">
            <div class="my-2 mx-2">
                <h3 class="text-center">Login</h3>
            </div>
            <div class="my-2 mx-2">
                <label for="email">Email:</label>
                <div>
                    <input type="email" class="form-control" name="email" placeholder="example@example.com">
                </div>

            </div>
            <div class="my-2 mx-2">
                <label for="password">Password:</label>
                <div>
                    <input type="password" class="form-control" name="password" placeholder="Your Password">
                </div>

            </div>

            <button type="submit" class="btn btn-danger mx-2 my-2">Login</button>
            <input type="hidden" name="nonce" value="<?php echo htmlspecialchars(ierg4210_csrf_getNonce($action)) ; ?>">

        </form>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <form action="auth_process.php?action=<?php echo htmlspecialchars($action ='changepwd');?>" method="POST" class="login-box rounded bg-light border border-dark">
            <div class="my-2 mx-2">
                <h3 class="text-center">Change Password</h3>
            </div>
            <div class="my-2 mx-2">
                <label for="inputemail">Input Email:</label>
                <div>
                    <input type="email" class="form-control" name="inputemail" placeholder="example@example.com">
                </div>

            </div>
            <div class="my-2 mx-2">
                <label for="oldpassword">Old Password:</label>
                <div>
                    <input type="password" class="form-control" name="oldpassword" placeholder="Your Old Password">
                </div>

            </div>
            <div class="my-2 mx-2">
                <label for="newpassword">New Password:</label>
                <div>
                    <input type="password" class="form-control" name="newpassword" placeholder="Your New Password">
                </div>

            </div>

            <button type="submit" class="btn btn-danger mx-2 my-2">Submit</button>
            <input type="hidden" name="nonce" value="<?php echo htmlspecialchars(ierg4210_csrf_getNonce($action)) ; ?>">

        </form>
    </div>

</body>

</html>

<!-- regular expression reference link -->
<!-- https://dl.icewarp.com/online_help/203030104.htm -->