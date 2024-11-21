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

    if (isset($_POST['delete_service'])) {
        $delete_id = $_POST['delete_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_service = $conn->prepare("SELECT * FROM `services` WHERE id =?");
        $verify_service -> execute([$delete_id]);

        if ($verify_service->rowCount() > 0) {
            $fetch_thumb = $verify_service->fetch(PDO::FETCH_ASSOC);
            $prev_thumb  = $fetch_thumb['thumb'];
            if ($prev_thumb != '') {
                unlink('../uploaded_files/' . $prev_thumb);
            }
            $delete_service = $conn->prepare("DELETE FROM `services` WHERE id= ? ");
            $delete_service->execute([$delete_id]);
            echo '<script> alert("service deleted!") ; </script>';

        }else{
            echo '<script> alert("service was already deleted!") ; </script>';

        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All services</title>
    <link rel="stylesheet" href="../admin_style.css">
</head>
<body>
<!--header section -->
<?php 
    include '../component/admin_header.php';
?>


<!-- view services section start -->
<section class="playlists">
    <h1 class="heading">all services</h1>

    <div class="box-container">

        <div class="box" style="text-align:center;">
            <h3 class="title" style="padding-bottom: 1rem;">create new service</h3>
            <a href="services.php" class="btn">add service</a>
        </div>
        <?php
            $select_service = $conn->prepare("SELECT * FROM `services`");
            $select_service -> execute();

            if ($select_service->rowCount() > 0) {
                while($fetch_service = $select_service->fetch(PDO::FETCH_ASSOC)){
                    $service_id   = $fetch_service['id'];
        ?>
        <div class="box">
            
            <div class="thumb">
                    <img src="../uploaded_files/<?=$fetch_service['thumb'];?>" alt="">
            </div>

            <h3 class="title"><?=$fetch_service['title'];?></h3>
            <p class="description"><?=$fetch_service['description'];?></p>
            
            <form action="" method="POST" class="flex-btn">
                <input type="hidden" name="delete_id" value="<?=$service_id?>">
                <input type="submit" value="delete" name="delete_service" class="delete-btn" onclick="return confirm('delete this service?');">
            </form>
        </div>
        <?php        
                }
            }else{
                echo '<p class="empty">service not added yet!</p>';
            }
        
        ?>
    </div>
</section>
<!-- view services section end -->








<!-- footer section -->
<?php 
        include '../component/footer.php';
?>
</body>
</html>