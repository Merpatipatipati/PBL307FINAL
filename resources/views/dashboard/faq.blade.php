<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css"> <!-- Link to external CSS -->
    <title>FAQ Page</title>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <div class="top-nav" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px;">
            <ul style="display: flex; align-items: center; list-style-type: none; margin: 0; padding: 0; width: 100%;">
            <li><a href="{{ route('dashboard') }}">Back</a></li>
                <div class="right-nav" style="margin-left: auto;">
                    <li><a href="{{ route('login') }}">LOGIN</a></li>
                </div>
            </ul>
        </div>
    </div>

    <hr class="separator">
    
<!-- FAQ Section -->
<div class="faq-section">
    <h2>Frequently Asked Questions</h2>
    <div class="faq-container">
        <!-- FAQ 1 -->
        <div class="faq">
            <p>Is there a payment system on this marketplace?</p>
            <i class="fas fa-plus"></i>
        </div>
        <div class="faq-answer">
            <p>No, this marketplace does not handle payments. All transactions and payments must be arranged between the buyer and seller directly.</p>
        </div>
        <!-- FAQ 2 -->
        <div class="faq">
            <p>Can I post products for sale on the marketplace?</p>
            <i class="fas fa-plus"></i>
        </div>
        <div class="faq-answer">
            <p>Yes, registered users can post products for sale. Simply log in to your account and use the "Post Product" option on your dashboard.</p>
        </div>
        <!-- FAQ 3 -->
        <div class="faq">
            <p>Can I chat with other users on the marketplace?</p>
            <i class="fas fa-plus"></i>
        </div>
        <div class="faq-answer">
            <p>Yes, you can chat with other users directly through the platform. This feature allows you to discuss products, negotiate prices, or ask any questions.</p>
        </div>
        <!-- FAQ 4 -->
        <div class="faq">
            <p>Is my data secure on this website?</p>
            <i class="fas fa-plus"></i>
        </div>
        <div class="faq-answer">
            <p>Yes, the website employs advanced security measures to protect your personal data. All communications and transactions are encrypted to ensure your privacy.</p>
        </div>
        <!-- FAQ 5 -->
        <div class="faq">
            <p>How can I ensure a safe transaction with other users?</p>
            <i class="fas fa-plus"></i>
        </div>
        <div class="faq-answer">
            <p>Since there is no payment system on the marketplace, it's important to communicate clearly with the seller and verify their credibility before proceeding with any transaction.</p>
        </div>
        <!-- FAQ 6 -->
        <div class="faq">
            <p>What should I do if I encounter a suspicious user or product?</p>
            <i class="fas fa-plus"></i>
        </div>
        <div class="faq-answer">
            <p>If you come across a suspicious user or product, please report it to the admin immediately using the "Report" button on the user's profile or product page.</p>
        </div>
        <!-- FAQ 7 -->
        <div class="faq">
            <p>Can I edit or delete my posted products?</p>
            <i class="fas fa-plus"></i>
        </div>
        <div class="faq-answer">
            <p>Yes, you can edit or delete your posted products at any time by logging into your account and accessing your dashboard.</p>
        </div>
        <!-- FAQ 8 -->
        <div class="faq">
            <p>How long will my post stay on the marketplace?</p>
            <i class="fas fa-plus"></i>
        </div>
        <div class="faq-answer">
            <p>Your post will remain active until you decide to delete it or it gets flagged for violating the platform's guidelines. You can edit or renew your post to keep it visible.</p>
        </div>
        <!-- FAQ 9 -->
        <div class="faq">
            <p>Can I send private messages to other users?</p>
            <i class="fas fa-plus"></i>
        </div>
        <div class="faq-answer">
            <p>Yes, you can send private messages to other users through the chat feature. This allows you to discuss products or services directly with other members.</p>
        </div>
        <!-- FAQ 10 -->
        <div class="faq">
            <p>What types of products are allowed to be posted?</p>
            <i class="fas fa-plus"></i>
        </div>
        <div class="faq-answer">
            <p>You are allowed to post a wide range of products, but items that are illegal or prohibited by law cannot be sold. Please review the terms and conditions for a full list of prohibited items.</p>
        </div>
        <!-- FAQ 11 -->
        <div class="faq">
            <p>What if I have a dispute with a seller or buyer?</p>
            <i class="fas fa-plus"></i>
        </div>
        <div class="faq-answer">
            <p>If you have a dispute with a seller or buyer, try to resolve it through communication. If the issue persists, you can contact the admin for assistance.</p>
        </div>
        <!-- FAQ 12 -->
        <div class="faq">
            <p>Can I post services for sale instead of physical products?</p>
            <i class="fas fa-plus"></i>
        </div>
        <div class="faq-answer">
            <p>Yes, you can post services for sale. Just select the "Service" category when posting your listing and provide the necessary details.</p>
        </div>
        <!-- FAQ 13 -->
        <div class="faq">
            <p>How can I keep my account secure?</p>
            <i class="fas fa-plus"></i>
        </div>
        <div class="faq-answer">
            <p>To keep your account secure, use a strong and unique password, enable two-factor authentication, and avoid sharing your account details with others.</p>
        </div>
    </div>
</div>


    <!-- Link to JavaScript -->
    <script src="js/faq.js"></script>
</body>
</html>
