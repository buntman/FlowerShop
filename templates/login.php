<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/login-style.css">
    <link rel="stylesheet" href="../public/css/login-style.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <h1>
            Rizza's Flower Shop
        </h1>
        <div class="main-container container">
            <form class="form p-3" action="/login" method="POST" onsubmit="userLogin(event)">
                <h2>System Login</h2>
                <p>Please enter your credentials below to continue</p>
                <div class="row ">
                    <div class="form-container-main py-2 pt-5">
                        <div class="form-container col-7 ">
                            <input class="form-control" type="text" id="username" placeholder="Username" name="username" required>
                            <span class="errors" id="username-error"></span>
                        </div>
                    </div>
                    <div class="form-container-main py-2">
                        <div class="form-container col-7">
                            <input class="form-control" type="password" id="password" placeholder="Password" name="password" required>
                            <span class="errors" id="password-error"></span>
                        </div>
                    </div>
                    <div class="form-options form-check form-container-main  align-self-center py-3">
                        <div class="d-flex justify-content-around w-75">
                            <label class="remember-me  form-check-label ps-3">
                                <input type="checkbox" name="remember" class="form-check-input"> Remember Me
                            </label>
                            <a href="#" class="forgot-password ">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="button-container py-3">
                        <button type="submit" name="login" value="login">Login</button>
                    </div>
                    <div class="form-signup">
                        <div class="">
                            <p>
                                Don't have an account?
                                <a href="/register" class="signup">Sign up</a>
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="js/login.js"></script>
</body>

</html>