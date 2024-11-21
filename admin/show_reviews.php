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

    if (isset($_POST['delete_review'])) {
        $delete_id = $_POST['delete_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_review = $conn->prepare("SELECT * FROM `reviews` WHERE id =?");
        $verify_review -> execute([$delete_id]);

        if ($verify_review->rowCount() > 0) {
            $fetch_thumb = $verify_review->fetch(PDO::FETCH_ASSOC);
            $prev_thumb  = $fetch_thumb['thumb'];
            if ($prev_thumb != '') {
                unlink('../uploaded_files/' . $prev_thumb);
            }
            $delete_review = $conn->prepare("DELETE FROM `reviews` WHERE id= ? ");
            $delete_review->execute([$delete_id]);
            echo '<script> alert("review deleted!") ; </script>';

        }else{
            echo '<script> alert("review was already deleted!") ; </script>';

        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All reviews</title>
    <link rel="stylesheet" href="../admin_style.css">
</head>
<body>
<!--header section -->
<?php 
    include '../component/admin_header.php';
?>


<!-- view reviews section start -->
<section class="playlists">
    <h1 class="heading">all reviews</h1>

    <div class="box-container">

        <div class="box" style="text-align:center;">
            <h3 class="title" style="padding-bottom: 1rem;">create new review</h3>
            <a href="reviews.php" class="btn">add review</a>
        </div>
        <?php
            $select_review = $conn->prepare("SELECT * FROM `reviews`");
            $select_review -> execute();

            if ($select_review->rowCount() > 0) {
                while($fetch_review = $select_review->fetch(PDO::FETCH_ASSOC)){
                    $review_id   = $fetch_review['id'];
        ?>
        <div class="box">
            
            <div class="thumb">
                    <img src="../uploaded_files/<?=$fetch_review['thumb'];?>" alt="">
            </div>
            <form action="" method="POST" class="flex-btn">
                <input type="hidden" name="delete_id" value="<?=$review_id?>">
                <input type="submit" value="delete" name="delete_review" class="delete-btn" onclick="return confirm('delete this review?');">
            </form>
        </div>
        <?php        
                }
            }else{
                echo '<p class="empty">review not added yet!</p>';
            }
        
        ?>
    </div>
</section>
<!-- view reviews section end -->








<!-- footer section -->
<?php 
        include '../component/footer.php';
?>
</body>
</html>