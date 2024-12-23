<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Import Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/hm.css"> <!-- External stylesheet -->
    <title>OpenShop</title>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <div class="top-nav" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px;">
            <ul style="display: flex; align-items: center; list-style-type: none; margin: 0; padding: 0; width: 100%;">
                <!-- Back Button -->
                <li><a href="{{ route('dashboard') }}">Back</a></li>
                
                <!-- Logo -->
                <li style="flex-grow: 1; text-align: center;">
                    <img src="../img/open.png" alt="Logo" class="logo-brand" style="max-width: 150px; height: auto;">
                </li>
                
                <!-- Login Button -->
                <div class="right-nav" style="margin-left: auto;">
                    <li><a href="{{ route('login') }}">LOGIN</a></li>
                </div>
            </ul>
        </div>
        <!-- Separator Line -->
        <hr class="separator">

        <h1 class="welcome-title">Welcome to OpenShop</h1>

        <!-- About Section -->
        <div class="about-container">
            <div class="about-section" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                <div class="about-image" style="width: 100%; max-width: 600px;">
                    <img src="../img/advertising.jpg" alt="About Us" class="about-img" style="width: 100%; height: auto; border-radius: 8px;">
                </div>
                <div class="about-text" style="max-width: 800px; padding: 20px;">
                    <h2>About OpenShop</h2>
                    <p>OpenShop is a web-based Forum Jual Beli (FJB) platform designed to provide a simple, interactive, and secure user experience. This website enables users to create posts about anything, whether for buying and selling purposes, sharing information, or discussing products and services. Below are the key features of OpenShop:</p>

                    <h3>Main Features:</h3>
                    <ul>
                        <li>
                            <strong>Post Products and Services:</strong>
                            <p>Users can upload information about the products or services they want to sell. Each post can include images, descriptions, prices, tags, and categories.</p>
                        </li>
                        <li>
                            <strong>Discussion Forum:</strong>
                            <p>In addition to buying and selling, users can create posts for discussions, tips, or recommendations. The comment feature allows other users to engage in conversations directly under the post.</p>
                        </li>
                        <li>
                            <strong>User Dashboard:</strong>
                            <p>Provides users with easy access to all the posts they have created. Displays personal information such as profile pictures, usernames, and lists of products.</p>
                        </li>
                        <li>
                            <strong>Messaging Between Users:</strong>
                            <p>A private messaging system that allows users to communicate directly about products or services offered. Messages are encrypted to maintain privacy, but admins retain the ability to decrypt messages when necessary for policy enforcement.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
