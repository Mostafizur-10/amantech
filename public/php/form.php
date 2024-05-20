<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    $phone = $_POST['mobile'];
    $preference = $_POST['preference'];

    // Email information
    $to = "mostafizur.kfc9@gmail.com"; // Replace with your email address
    $subject = "New Contact Form Submission";
    $message = "Name: $name\nCompany: $company\nEmail: $email\nPhone: $phone\n\nPreference: $preference";

    // SMTP server configuration
    $smtpHost = 'smtp.gmail.com';
    $smtpPort = 587;
    $smtpUsername = 'mostafizur.kfc9@gmail.com'; // Replace with your Gmail address
    $smtpPassword = '@haider10#'; // Replace with your Gmail password

    // Send email using SMTP
    if (smtp_mail($to, $subject, $message, $smtpHost, $smtpPort, $smtpUsername, $smtpPassword)) {
        echo "Thank you! Your message has been sent.";
    } else {
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
}

// Function to send email using SMTP
function smtp_mail($to, $subject, $message, $smtpHost, $smtpPort, $smtpUsername, $smtpPassword) {
    $headers = [
        'MIME-Version: 1.0',
        'Content-type: text/plain; charset=utf-8',
        'From: ' . $smtpUsername,
        'Reply-To: ' . $smtpUsername,
        'X-Mailer: PHP/' . phpversion()
    ];

    $smtp = fsockopen($smtpHost, $smtpPort, $errno, $errstr, 15);
    if (!$smtp) {
        return false;
    }

    fputs($smtp, "EHLO " . $smtpHost . "\r\n");
    fputs($smtp, "STARTTLS\r\n");
    fputs($smtp, "AUTH LOGIN\r\n");
    fputs($smtp, base64_encode($smtpUsername) . "\r\n");
    fputs($smtp, base64_encode($smtpPassword) . "\r\n");
    fputs($smtp, "MAIL FROM: <$smtpUsername>\r\n");
    fputs($smtp, "RCPT TO: <$to>\r\n");
    fputs($smtp, "DATA\r\n");
    fputs($smtp, "Subject: $subject\r\n");
    foreach ($headers as $header) {
        fputs($smtp, $header . "\r\n");
    }
    fputs($smtp, "\r\n");
    fputs($smtp, $message . "\r\n");
    fputs($smtp, ".\r\n");
    fputs($smtp, "QUIT\r\n");
    fclose($smtp);

    return true;
}
?>
