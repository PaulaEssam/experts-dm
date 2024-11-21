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

    $getServices = $conn->prepare('SELECT * FROM `services`');
    $getServices->execute();
    $totalServices = $getServices->rowCount();

    $getProjects = $conn->prepare('SELECT * FROM `projects`');
    $getProjects->execute();
    $totalProjects = $getProjects->rowCount();

    $getReviews = $conn->prepare('SELECT * FROM `reviews`');
    $getReviews->execute();
    $totalReviews = $getReviews->rowCount();

    $getMessages = $conn->prepare('SELECT * FROM `messages`');
    $getMessages->execute();
    $totalMessages = $getMessages->rowCount();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link rel="stylesheet" href="../admin_style.css">
    <title>Dashboard | Experts Digital Marketing</title>
</head>
<body>
<?php 
    include '../component/admin_header.php';
?>
<section class="dashboard">
    <h1 class="heading">dashboard</h1>
    <div class="box-container">

            
        <div class="box">
            <h3>welcome!</h3>
            <p><?= $fetch_profile['name'];?></p>
            <a href="profile.php" class="btn">edit profile</a>
        </div>

        <div class="box">
            <h3><?= $totalServices;?></h3>
            <p>Services</p>
            <a href="services.php" class="btn">add new Service</a>
        </div>

        <div class="box">
            <h3><?= $totalProjects;?></h3>
            <p>Projects</p>
            <a href="projects.php" class="btn">add new Project</a>
        </div>

        <div class="box">
            <h3><?= $totalReviews;?></h3>
            <p>Reviews</p>
            <a href="reviews.php" class="btn">add Reviews</a>
        </div>
        <div class="box">
            <h3><?= $totalMessages;?></h3>
            <p>Messages</p>
            <a href="messages.php" class="btn">View Messages</a>
        </div>
    </div>  

</section>

<!-- footer section start -->
<?php include '../component/footer.php';?>
<!-- footer section end -->

</body>
</html>