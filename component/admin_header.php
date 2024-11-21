
<!-- header section starts -->
<header class="header">
    <section class="flex">
        <a href="dashboard.php" class="logo">Experts Digital Marketing</a>
    </section>
</header>
<!-- header section ends -->


<!-- side bar section start -->
<div class="side-bar">
        <div class="close-side-bar">
            <i class="fas fa-times"></i>
        </div>
        <div class="profile">
            <?php
                $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id=?");
                $select_profile->execute([$admin_id]);
                if($select_profile->rowCount() > 0){
                    $fetch_profile =  $select_profile->fetch(PDO::FETCH_ASSOC) ;
                
            ?>
            <h3><?= $fetch_profile['name'];?></h3>
            <a href="profile.php" class="btn">edit profile</a>
            
            <?php 
                
                }
            ?>
            <?php
                $message = $conn->prepare("SELECT * FROM `messages` WHERE see !=1"); 
                $message->execute();
                $newMessages = $message->rowCount();
            ?>
        </div>
        <nav class="navbar">
            <a href="dashboard.php"><span>Home</span></a>
            <a href="show_services.php"><span>Services</span></a>
            <a href="show_projects.php"><span>Projects</span></a>
            <a href="show_reviews.php"><span>Reviews</span></a>
            <a href="messages.php" style="position: relative; color:var(--light-color);">
                <?php if($newMessages)
                    {
                ?>
                <span style="background-color: red; position:absolute; font-size:12px; right: -1px;  top: 3px; color: #fff; padding: 2px 5px; border-radius: 50%;">
                    <?=$newMessages ?>
                </span>
                <?php } ?>
                Messages
            </a>
            <a href="../component/admin_logout.php" onclick="return confirm('logout from this website?')"><span>logout</span></a>
        </nav>
</div>
<!-- side bar section end -->