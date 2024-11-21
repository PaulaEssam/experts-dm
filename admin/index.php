<?php
include '../component/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
}
else {
    $admin_id = '';
}
if (isset($_POST['submit'])) {
    // Get the data from form    
    $email          = $_POST['email'];
    $email          = filter_var($email, FILTER_SANITIZE_STRING);
    
    $pass           = sha1($_POST['password']);
    $pass           = filter_var($pass, FILTER_SANITIZE_STRING);
    
    $verify_admin = $conn->prepare("SELECT * FROM `admins` WHERE email=? AND password =? LIMIT 1");
    $verify_admin->execute([$email, $pass]);
    $row = $verify_admin->fetch(PDO::FETCH_ASSOC);
    
        if ($verify_admin->rowCount() > 0) {
                setcookie('admin_id', $row['id'], time() + 60*60*24*30,'/');
                header("Location: dashboard.php");
        }else{
            echo '<script> alert("incorrect email or password!") ; </script>';
        }         
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-login | Experts Digital Marketing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #2196F3; /* لون أزرق */
        }
        input[type="email"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }
        button {
            background-color: #2196F3; /* لون أزرق */
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 30%;
        }
        button:hover {
            background-color: #1976D2; /* درجة أغمق من الأزرق */
        }
        @media (max-width: 400px) {
            .login-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Welcom Admin</h2>
        <form method="POST">
            <input name="email" type="email" placeholder="email" required>
            <input name="password" type="password" placeholder="password" required>
            <button name="submit" type="submit">Login </button>
        </form>
    </div>
</body>
</html>