<?php
session_start();

include "../config.php";

$text = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["email"];
    $password = $_POST["password"];

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":email", $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Store user session data
        $_SESSION["user_id"] = $user['id'];
        $_SESSION["email"] = $user['email'];
        $_SESSION["role"] = $user['role']; 

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: /projectlab2/admin/index.php");
        } 
        elseif ($user['role'] === 'customer') {
            header("Location: /projectlab2/index.php");
        }
        
        exit;
    } else {
        $text = "<span class='text-danger'>Incorrect email or password</span>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="../admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../admin/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../admin/img/logo1.png" type="image/x-icon">

    <style>
        .vh-100 {
            height: 100vh;
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container vh-100 d-flex align-items-center justify-content-center">

        <div class="col-xl-5 col-lg-6 col-md-8">
            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Welcome</h1>
                        <?php echo $text; ?>
                    </div>
                    <form class="user" method="POST" action="">
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" name="email"
                                placeholder="email" value="john@gmail.com" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" name="password"
                                placeholder="password" value="12345" required>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Login
                        </button>
                    </form>

                    <hr>
                    <div class="text-center">
                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="register.html">Create an Account!</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>