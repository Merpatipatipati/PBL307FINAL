<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>OpenShop</title>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <div class="top-nav">
        <ul>
            <li class="center-logo">
                <img src="img/open.png" alt="Logo" class="logo-brand">
            </li>
            <div class="right-nav">
            <li><a href="{{ route('about') }}">ABOUT</a></li>
            <li><a href="{{ route('faq') }}">FAQ</a></li>
            <li><a href="{{ route('register') }}">SIGN UP</a></li>
                <li><a href="{{ route('login') }}"><i class="fa-solid fa-user"></i></a></li>
            </div>
        </ul>
    </div>

        </div>

        <hr class="separator">
        
        <h1 class="welcome-title">WELCOME TO OUR WEBSITE!</h1>
    </div>

    <!-- Main Content Section -->
    <div class="main-content">
        <!-- Left half: Text section -->
        <div class="text-section">
            <p class="dressing-up"><span class="large-text">Dressing up to</span><br><span class="highlighted-text">be noticed!</span></p>
            <p class="small-text">Fashion is a need, being pretty is a should! Here's where you can find your identity!</p>
            <div class="buttons">
                <a href="{{ route('login') }}"> <i class="fas fa-play"></i> Start Shopping</a>
            </div>
        </div>

        <!-- Right half: Slider -->
        <div class="slider">
            <img src="img/dashboard/1.jpg" alt="Slide 1" class="slide active">
            <img src="img/dashboard/2.jpg" alt="Slide 2" class="slide">
            <img src="img/dashboard/3.jpg" alt="Slide 3" class="slide">
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <i class="fas fa-phone-alt"></i>
                <h3>Phone</h3>
                <p>+6281234567</p>
            </div>
            <div class="footer-section">
                <i class="fas fa-envelope"></i>
                <h3>Email</h3>
                <p>shopen@gmail.com</p>
            </div>
            <div class="footer-section">
                <h3>Social Media</h3>
                <div class="social-icons">
                <a href="https://instagram.com/hereshopen" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://twitter.com/hereshopen" target="_blank"><i class="fab fa-x-twitter"></i></a>
                <a href="https://facebook.com/OpenShop" target="_blank"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript for slider (Simple auto-play slider) -->
    <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let slides = document.getElementsByClassName("slide");
            for (let i = 0; i < slides.length; i++) {
                slides[i].classList.remove("active");
            }
            slideIndex++;
            if (slideIndex > slides.length) {slideIndex = 1}
            slides[slideIndex - 1].classList.add("active");
            setTimeout(showSlides, 3000); // Change image every 3 seconds
        }
    </script>
</body>
</html>