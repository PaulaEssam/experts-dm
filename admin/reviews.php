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
        
        $thumb          = $_FILES['thumb']['name'];
        $thumb          = filter_var($thumb, FILTER_SANITIZE_STRING);
        $thumb_ext            = pathinfo($thumb, PATHINFO_EXTENSION);
        $rename_thumb         = create_unique_id().'.'.$thumb_ext;
        $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
        $thumb_size     = $_FILES['thumb']['size'];
        $thumb_folder   = '../uploaded_files/'.$rename_thumb;

            if ($thumb_size > 2000000) {
                echo '<script> alert("image  is too large!") ; </script>';

            }
            else{
                $add_review = $conn->prepare("INSERT INTO `reviews` (thumb)
                VALUES (?)");
                $add_review -> execute([$rename_thumb]);            
                move_uploaded_file($thumb_tmp_name, $thumb_folder);
                echo '<script> alert("new review created!") ; </script>';
            }

    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" review="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../admin_style.css">
    <title>Add Review | Experts Digital Marketing</title>
</head>
<body>
<?php 
    include '../component/admin_header.php';
?>
<section class="crud-form">
    <h1 class="heading">add review</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <p> review photo <span>*</span></p>
        <input type="file" name="thumb"  class="box" accept="image/*" required>
        <input type="submit" name="submit"  value="add review" class="btn">
    
    </form>

</section>

<!-- footer section start -->
<?php include '../component/footer.php';?>
<!-- footer section end -->

</body>
</html>