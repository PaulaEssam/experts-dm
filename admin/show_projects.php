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

    if (isset($_POST['delete_project'])) {
        $delete_id = $_POST['delete_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_project = $conn->prepare("SELECT * FROM `projects` WHERE id =?");
        $verify_project -> execute([$delete_id]);

        if ($verify_project->rowCount() > 0) {
            $fetch_thumb = $verify_project->fetch(PDO::FETCH_ASSOC);
            $prev_thumb  = $fetch_thumb['thumb'];
            if ($prev_thumb != '') {
                unlink('../uploaded_files/' . $prev_thumb);
            }
            $delete_project = $conn->prepare("DELETE FROM `projects` WHERE id= ? ");
            $delete_project->execute([$delete_id]);
            echo '<script> alert("project deleted!") ; </script>';

        }else{
            echo '<script> alert("project was already deleted!") ; </script>';

        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All projects</title>
    <link rel="stylesheet" href="../admin_style.css">
</head>
<body>
<!--header section -->
<?php 
    include '../component/admin_header.php';
?>


<!-- view projects section start -->
<section class="playlists">
    <h1 class="heading">all projects</h1>

    <div class="box-container">

        <div class="box" style="text-align:center;">
            <h3 class="title" style="padding-bottom: 1rem;">create new project</h3>
            <a href="projects.php" class="btn">add project</a>
        </div>
        <?php
            $select_project = $conn->prepare("SELECT * FROM `projects`");
            $select_project -> execute();

            if ($select_project->rowCount() > 0) {
                while($fetch_project = $select_project->fetch(PDO::FETCH_ASSOC)){
                    $project_id   = $fetch_project['id'];
        ?>
        <div class="box">
            
            <div class="thumb">
                    <img src="../uploaded_files/<?=$fetch_project['thumb'];?>" alt="">
            </div>

            <h3 class="title"><?=$fetch_project['title'];?></h3>
            <p class="description"><?=$fetch_project['description'];?></p>
            
            <form action="" method="POST" class="flex-btn">
                <input type="hidden" name="delete_id" value="<?=$project_id?>">
                <input type="submit" value="delete" name="delete_project" class="delete-btn" onclick="return confirm('delete this project?');">
            </form>
        </div>
        <?php        
                }
            }else{
                echo '<p class="empty">project not added yet!</p>';
            }
        
        ?>
    </div>
</section>
<!-- view projects section end -->








<!-- footer section -->
<?php 
        include '../component/footer.php';
?>
</body>
</html>