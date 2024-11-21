<?php
include '../component/connect.php';
    if (isset($_COOKIE['admin_id'])) {
        $admin_id = $_COOKIE['admin_id'];
    }
    else {
        $admin_id = '';
        header("Location: index.php");
        exit();
    }

    if (isset($_POST['submit'])) {

        $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE id =? LIMIT 1");
        $select_admin->execute([$admin_id]);
        $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);

        $prev_pass      = $fetch_admin['password'];
        
        $name           = $_POST['name'];
        $name           = filter_var($name, FILTER_SANITIZE_STRING);
        
        $email          = $_POST['email'];
        $email          = filter_var($email, FILTER_SANITIZE_STRING);

        $empty_pass     = 'da39a3ee5e6b4b0d3255bfef95601890afd80709'; // كود التفشير بتاعة الاسترنج الفاضي
        $old_pass       = sha1($_POST['old_pass']);
        $old_pass       = filter_var($old_pass, FILTER_SANITIZE_STRING);
        
        $new_pass       = sha1($_POST['new_pass']);
        $new_pass       = filter_var($new_pass, FILTER_SANITIZE_STRING);
        
        $c_pass         = sha1($_POST['c_pass']);
        $c_pass         = filter_var($c_pass, FILTER_SANITIZE_STRING);


        
        if (!empty($name)) {
            $update_name = $conn->prepare("UPDATE `admins` SET name=? WHERE id=?");
            $update_name->execute([$name, $admin_id]);
            echo '<script> alert("name updated successfully!") ; </script>';

        }

        if (!empty($email)) {
            $select_admin_email = $conn->prepare("SELECT * FROM `admins` WHERE email=?");
            $select_admin_email->execute([$email]);
            if ($select_admin_email->rowCount() > 0) {
            echo '<script> alert("email already taken!") ; </script>';

            }else{
                $update_email = $conn->prepare("UPDATE `admins` SET email=? WHERE id=?");
                $update_email->execute([$email, $admin_id]);
                echo '<script> alert("email updated successfully!") ; </script>';
            }
            
        }
        

        
        if ($old_pass != $empty_pass) {
            if ($old_pass != $prev_pass) {
                echo '<script> alert("old password not matched!") ; </script>';

            }elseif ($new_pass != $c_pass) {
                echo '<script> alert("confirm password  not matched!") ; </script>';

            }else {
                if ($new_pass != $empty_pass) {
                    $update_pass = $conn->prepare("UPDATE `admins` SET password=? WHERE id=?");
                    $update_pass->execute([$c_pass, $admin_id]);
                    echo '<script> alert("password updated successfully!") ; </script>';
                }else{
                    echo '<script> alert("please enter new password!") ; </script>';

                }
            }
        }
    
    
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../admin_style.css">
</head>
<body>
<!--header section -->
<?php 
    include '../component/admin_header.php';
?>


<!-- update section start -->
<section class="form-container">   
    <form action="" method="post" enctype="multipart/form-data">
        <h3>update profile</h3>
        <div class="flex">
            <div class="col">
                <p>your name </p>
                <input type="text" name="name" maxlength="50" 
                placeholder="<?=$fetch_profile['name'];?>" class="box">

                <p>your email </p>
                <input type="email" name="email" maxlength="50" 
                placeholder="<?=$fetch_profile['email'];?>" class="box">
            </div>

            <div class="col">
            <p>old password </p>
                <input type="password" name="old_pass" maxlength="20" 
                placeholder="enter your old password" class="box">

                <p>your new password </p>
                <input type="password" name="new_pass" maxlength="20" 
                placeholder="enter your new password" class="box">

                <p>confirm password </p>
                <input type="password" name="c_pass" maxlength="20" 
                placeholder="confirm your new password" class="box">

            </div>
        </div>
        <input type="submit" name="submit" value="update" class="btn">
    </form>
</section>     
<!-- update section end -->



<!-- footer section start -->
<?php include '../component/footer.php';?>
<!-- footer section end -->

</body>
</html>