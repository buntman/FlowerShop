<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
         <link rel="stylesheet" href="/css/login-style.css">
<title>Login</title>
</head>
    <body>
        <?php
        include "connectMysql.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $emp_user = $_POST['username'];
            $emp_pass = $_POST['password'];


            $sql = "SELECT * FROM Employees WHERE username = ?";
            $sql_statement = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($sql_statement, 's', $emp_user);
            mysqli_stmt_execute($sql_statement);
            $result = mysqli_stmt_get_result($sql_statement);
            $emp = mysqli_fetch_assoc($result);
            $password = $emp['password'];

            if ($emp) {
                if (password_verify($emp_pass, $password)) {
                    header("Location: home.php");
                }
            }
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
