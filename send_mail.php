<?php
// Set headers to communicate seamlessly with your Javascript AJAX engine
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Clean and validate form inputs
    $name    = strip_tags(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Stop processing if fields are completely empty or invalid
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Please complete all fields correctly."]);
        exit;
    }

    // Target delivery mailbox
    $recipient = "dineshmc20@gmail.com";

    // Set professional mail architecture headers
    $email_headers = "From: =?UTF-8?B?".base64_encode($name)."?= <$email>\r\n";
    $email_headers .= "Reply-To: $email\r\n";
    $email_headers .= "MIME-Version: 1.0\r\n";
    $email_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $email_headers .= "X-Mailer: PHP/" . phpversion();

    // Organize the message text block clearly
    $email_content = "Website Contact Form Submission\n";
    $email_content .= "=================================\n\n";
    $email_content .= "Sender Name: $name\n";
    $email_content .= "Sender Email: $email\n";
    $email_content .= "Subject: $subject\n\n";
    $email_content .= "Message Body:\n$message\n";

    // Request the host server to fire the email out natively
    if (mail($recipient, "Website Query: $subject", $email_content, $email_headers)) {
        echo json_encode(["status" => "success", "message" => "Thank you! Your message has been sent directly to our team."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Server failed to send email. Please verify hosting configurations."]);
    }

} else {
    // If someone tries to open send_mail.php directly in browser
    echo json_encode(["status" => "error", "message" => "Direct script access is strictly forbidden."]);
}
?>
