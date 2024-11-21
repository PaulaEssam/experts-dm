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
        $title          = $_POST['title'];
        $title          = filter_var($title, FILTER_SANITIZE_STRING);
        
        $description    = $_POST['description'];
        $description    = filter_var($description, FILTER_SANITIZE_STRING);

        $project_link    = $_POST['project_link'];
        $project_link    = filter_var($project_link, FILTER_SANITIZE_STRING);
        
        $thumb          = $_FILES['thumb']['name'];
        $thumb          = filter_var($thumb, FILTER_SANITIZE_STRING);
        $thumb_ext            = pathinfo($thumb, PATHINFO_EXTENSION);
        $rename_thumb         = create_unique_id().'.'.$thumb_ext;
        $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
        $thumb_size     = $_FILES['thumb']['size'];
        $thumb_folder   = '../uploaded_files/'.$rename_thumb;

        


        $verify_project = $conn->prepare("SELECT * FROM `projects` WHERE  title =? AND description =? ");
        $verify_project -> execute([ $title, $description]);

        if ($verify_project->rowCount() > 0) {
            echo '<script> alert("project already added!") ; </script>';

        }
        else{
            if ($thumb_size > 2000000) {
                echo '<script> alert("image  is too large!") ; </script>';

            }
            else{
                $add_project = $conn->prepare("INSERT INTO `projects` (title, description,thumb, project_link)
                VALUES (?,?,?,?)");
                $add_project -> execute([$title, $description,$rename_thumb,$project_link]);            
                move_uploaded_file($thumb_tmp_name, $thumb_folder);
                echo '<script> alert("new project created!") ; </script>';
            }

        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" project="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../admin_style.css">
    <title>Add Project | Experts Digital Marketing</title>
</head>
<body>
<?php 
    include '../component/admin_header.php';
?>
<section class="crud-form">
    <h1 class="heading">add project</h1>
    <form action="" method="post" enctype="multipart/form-data">
        
        <p>project title <span>*</span></p>
        <input type="text" name="title" placeholder="enter project title" class="box" maxlength="100" required>
        
        <p>project description</p>
        <textarea name="description" placeholder="enter project description" class="box" maxlength="1000"  cols="30" rows="10"></textarea>
        
        <p>project link </p>
        <input type="text" name="project_link" placeholder="enter project link" class="box">

        <p>project photo <span>*</span></p>
        <input type="file" name="thumb"  class="box" accept="image/*" required>
        <input type="submit" name="submit"  value="add project" class="btn">
    
    </form>

</section>

<!-- footer section start -->
<?php include '../component/footer.php';?>
<!-- footer section end -->

</body>
</html>