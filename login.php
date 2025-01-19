<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/login-style.css">
<title>Login</title>
</head>
    <body>
        <?php
        include "connectMysql.php";
        include "formValidator.php";
        include "authenticate.php";
        include "storeData.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sanitizedData = input($_POST);
            $validator = new formValidator($sanitizedData);

            try {
                $validator->validateLogin();
                $authenticateUser = new authenticate($sanitizedData, $connect);
                $authenticateUser->authenticateLogin();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        function input($arrayData)
        {
            foreach ($arrayData as $key => $data) {
                $arrayData[$key] = htmlspecialchars(stripslashes(trim($data)));
            }
            return $arrayData;
        }
        ?>

        <h1>
            Rizza's Flower Shop
        </h1>
        <div class="main-container">
        <form class="form" action="#" method="POST">
        <h2>System Login</h2>
        <p>Please enter your credentials below to continue</p>
        <div class="form-container">
            <label for="username"></label><br>
            <input type="text" id="username" placeholder="Username" name="username">
        </div>
        <div class="form-container">
            <label for="password"></label><br>
            <input type="password" id="password" placeholder="Password" name="password">
        </div>
        <div class="form-options">
        <label class="remember-me">
        <input type="checkbox" name="remember"> Remember Me
        </label>
        <a href="#" class="forgot-password">Forgot Password?</a>
        </div>
        <div class="button-container">
            <button type="submit" name="login" value="login">Login</button>
        </div>
        <div class="form-signup">
                    <p> 
                    Don't have an account?
        <a href="register.php" class="signup">Sign up</a>
                    </p>
        </div>
        </form>
        </div>
</body>
</html> 
