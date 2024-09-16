<?php

$siteOwnersEmail = 'naitikbu@gmail.com';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize input data to prevent XSS
    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    $error = [];

    // Validate Name
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }

    // Validate Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Please enter a valid email address.";
    }

    // Validate Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Please enter your message. It should have at least 15 characters.";
    }

    // Set default subject if none provided
    if ($subject == '') {
        $subject = "Contact Form Submission";
    }

    // If no errors, proceed to send the email
    if (empty($error)) {
        $message = "Email from: " . $name . "<br />";
        $message .= "Email address: " . $email . "<br />";
        $message .= "Message: <br />";
        $message .= $contact_message;
        $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

        // Email Headers
        $from =  $name . " <" . $email . ">";
        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: ". $email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Send the email
        if (mail($siteOwnersEmail, $subject, $message, $headers)) {
            echo "OK";
        } else {
            echo "Something went wrong. Please try again.";
        }
    } else {
        // Return error messages
        foreach ($error as $err) {
            echo $err . "<br />";
        }
    }
} else {
    echo "Invalid request method.";
}

?>
