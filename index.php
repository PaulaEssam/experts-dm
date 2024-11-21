<?php
include 'component/connect.php';

if (isset($_POST['submit'])) { 
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);

    $message = $_POST['message'];
    $message = filter_var($message, FILTER_SANITIZE_STRING);

    $is_sent = $conn->prepare('SELECT * FROM `messages` WHERE name=? AND email=? AND phone=? AND message =?') ;
    $is_sent->execute([$name, $email, $number, $message]);
    if($is_sent->rowCount()>0){
        echo '<script>alert("You have already sent a message")</script>';
    }
    else{
        $send_message = $conn->prepare('INSERT INTO `messages` (name,email,phone,message) VALUES (?,?,?,?)');
        $send_message->execute([$name, $email, $number, $message]);
        echo '<script>alert("Your message has been sent successfully")</script>';
        
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experts Digital Marketing</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <!-- Header Section -->
    <header>
        <a href="index.php" class="logo">
            <img src="imgs/logoo.png" alt="Logo" style="width: 400px; height: 400px; border-radius: 50%;">
        </a>
        <nav class="gat">
            <a href="#section-1">Home</a>
            <a href="#about">About</a>
            <a href="#Services">Services</a>
            <a href="#Projects">Projects</a>
            <a href="#Contact">Contact</a>
        </nav>
    </header>
<div class="container">
    <!-- Section 1-->
    <section id="section-1">
        <div class="s1">
            <h1 >
                <p class="name-s1">Experts</p> <br> Digital Marketing
            </h1>
            <p class="s1-3" style="font-family: chiller; font-size: 28px;">A Way to Success To Your Projects</p>
        </div>
        <br> <br>
        <div class="image-container">
            <img style="width: 20em;height:20em;" src="imgs/Gradient.png" alt="Background Image" class="background-image">
            <img src="imgs/Me.png" alt="Avatar" class="avatar">
        </div>
    </section>

<br> <br> <br> 
    <!-- Section 2: About Section -->
    <section class="section-2" id="about">
        <div>
            <h1 style="margin-bottom: 0;">
                <p class="name-s1">Experts</p> Digital Marketing <br>
                is the best software house that creates innovative digital solutions to help your business thrive.
            </h1>
        </div>
        <br>
        <div class="s2-2">
            <a href="#Contact"><button style="color: #ffffff; cursor: pointer; font-weight: bold; ">contact us </button> </a>
        </div>
        <div style="margin-top: 3em;">
            <p class="s2-3">
                Creative Design ...<br>
                We don't do cookie-cutter solutions. Our user-centered design encourages productivity and boosts revenue. <br>
                At our software house, security is our top priority. We implement the latest technologies and best practices to ensure your digital assets are safe and protected.
            </p>
        </div>
    </section>

    <!-- Section 3: Services Section -->
    <section class="section-3" id="Services">
        <img src="imgs/Gradient.png" alt="" style="width: 200px; height: 200px; margin-bottom: -150px;">
        <h2>Services</h2>
        <div class="work-cards">
            <?php 
                $getService = $conn->prepare('SELECT * FROM `services`');
                $getService->execute();
                if ($getService->rowCount()>0) {
                    while($fetchService = $getService->fetch(PDO::FETCH_ASSOC)){
            ?>
                <div class="card">
                    <div>
                        <img src="uploaded_files/<?=$fetchService['thumb']?>" alt="<?=$fetchService['title']?>" style="width: 130px; height: 100px;">
                    </div>
                    <div>
                        <h3><?=$fetchService['title']?></h3>
                        <p><?=$fetchService['description']?></p>
                        <a href="https://www.facebook.com/ExpertsDigitallMarketing"><button>LEARN MORE</button></a>
                    </div>
                </div>
            <?php
                }
            }
            ?>
        
        </div>
    </section>

    <section class="projects" id="Projects">
        <img src="imgs/Gradient.png" alt="" style="width: 200px; height: 200px; margin-bottom: -350px;">
        <h2 style="margin-bottom: -200px;">Projects</h2>
        <?php 
            $getProject = $conn->prepare('SELECT * FROM `projects`');
            $getProject->execute();
            if ($getProject->rowCount()>0) {
                while($fetchProject = $getProject->fetch(PDO::FETCH_ASSOC)){
        ?>
                <?php if ($fetchProject['id'] % 2 !=0) {
                    $class = 'left-text';
                    } else {
                        $class = 'right-text';
                    
                }?>
                
                <div class="project <?= $class?>">
                    <div class="project-text">
                        <h3 class="project-title"><?=$fetchProject['title']?></h3>
                        <div class="project-content">
                            <p><?=$fetchProject['description']?></p>                        
                        </div>
                    </div>
                    <div class="image-content">
                        <?php 
                            if($fetchProject['project_link']){
                        ?>
                            <a href="https://<?=$fetchProject['project_link']?>">
                                <img src="uploaded_files/<?=$fetchProject['thumb']?>" alt="<?=$fetchProject['title']?>">
                            </a>
                        <?php 
                            } else{
                        ?>
                            <img src="uploaded_files/<?=$fetchProject['thumb']?>" alt="<?=$fetchProject['title']?>">
                        <?php
                            }
                        ?>
                    </div>
                </div>
        <?php 
                }
            }
        ?>
        
    </section>
<br> <br> <br> <br> <br> <br>

    <!-- Section 5: Review Section -->
    <section class="review">
        <img class="r-img" src="imgs/Gradient.png" alt="" style="width: 200px; height: 200px; margin-bottom: -150px; margin-left: 500px;">
        <h2 style="text-align: center; margin-top: 12px;" >Reviews</h2>
        <br>
        <div class="work-cards">
            <?php
                $getReview = $conn->prepare('SELECT * FROM `reviews`');
                $getReview->execute();
                if ($getReview->rowCount()>0) {
                    while($fetchReview = $getReview->fetch(PDO::FETCH_ASSOC)){
            ?>
                    <div class="card">
                        <div>
                            <img src="uploaded_files/<?=$fetchReview['thumb']?>"  style="width: 100%; height: 100%;">

                        </div>
                    </div>
            <?php 
                }
                    }
            ?>    
        </div>
    </section>


    <!-- Footer Section -->
    <footer id="Contact">
        
        <h2 style="margin-bottom: 1em; text-align: center;">Contact</h2>
        <div class="contact">
            <form action="" method="POST">
                <h2 style="text-align: center;">get in touch</h2>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="number" name="number" placeholder="Phone Number" min="0" required>
                <textarea name="message" placeholder="Message"></textarea>
                <button name="submit" type="submit" style="color: #ffffff; font-weight: bold; cursor: pointer;">Send</button>
            </form>
            <div class="img">
                <img  src="imgs/contact-img.svg" alt="contact-img" title="contact-img">
            </div>
        </div>
        <div class="socials">
            <a href="https://www.facebook.com/ExpertsDigitallMarketing" class="facebook">
                <i class="fa-brands fa-facebook" style="color: #ffffffd0;"></i>
            </a>
            <a href="https://wa.me/201553999966" class="whatsapp">
                <i class="fa-brands fa-whatsapp" style="color: #ffffff;"></i>
            </a>
        </div>
    </footer>
</div>

</body>
</html>
