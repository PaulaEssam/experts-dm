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

    if (isset($_POST['delete_message'])) {
        $delete_id = $_POST['message_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_message = $conn->prepare("SELECT * FROM `messages` WHERE id = ?");
        $verify_message->execute([$delete_id]);

        if ($verify_message->rowCount() > 0) {
            $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
            $delete_message->execute([$delete_id]);
            echo '<script> alert("message deleted successfully!") ; </script>';

        }
        else{
            echo '<script> alert("message already deleted!") ; </script>';

        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="../admin_style.css">
</head>
<body>
<!--header section -->
<?php 
    include '../component/admin_header.php';
?>

<!-- messages section start -->
<section class="comments">
    <h1 class="heading">messages</h1>
    <div class="box-container">
    
    <?php
            $update_mesg = $conn->prepare("UPDATE `messages` SET see = 1 ");
            $update_mesg->execute();


            $select_messages = $conn->prepare("SELECT * FROM `messages` ORDER BY id DESC");
            $select_messages->execute();
            if ($select_messages->rowCount() > 0) {
                while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
                    // $message_id = $fetch_message['id'];
                    $user_name = $fetch_message['name'];
                    $user_email = $fetch_message['email'];
                    $user_phone = $fetch_message['phone'];
                    
                    
                    
    ?>
            <div class="box">
                <div class="user">
                    <div>
                        <h3><span>name: </span><?=$user_name;?></h3>
                        <h3><span>email: </span><?=$user_email;?></h3>
                        <h3><span>phone: </span><?=$user_phone;?></h3>
                    </div>
                </div>
                <p class="comment-box"><?= $fetch_message['message'];?></p>
                <form action="" method="post">
                    <input type="hidden" name="message_id" value="<?= $fetch_message['id'];?>">
                    <input type="submit" name="delete_message" value="delete message" class="inline-delete-btn" onclick="return confirm('delete this message?');">
                </form>
            </div>
    <?php
                }
            }   
            else{
                echo '<p class="empty">no messages!</p>';
            }
        ?>
    </div>
</section>

<!-- messages section end -->


<!-- footer section -->
<?php 
        include '../component/footer.php';
?>
</body>
</html>