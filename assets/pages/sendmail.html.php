<?php
include 'assets/php/DatabaseConnection.php';

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    // Access user data
    $user = $_SESSION['user'];
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: http://localhost/coursework/?login");
    exit();
}
?>

<div class="container rounded-0 d-flex justify-content-between">
    <div class="col-12 bg-white border rounded p-4 mt-4 shadow-sm">
        <h1 class="h5 text-center mb-3 fw-normal">Contact to Admin</h1>

        <form method="post" class='d-flex flex-column justify-content-center'>
            <div class='input-group mb-3'>
                <input class='form-control' placeholder="Username" type="text" id="name" name="name" required>
            </div>

            <div class='input-group mb-3'>
                <input class='form-control' placeholder="Subject/Module" type="text" id="subject" name="subject" required>
            </div>

            <div class='input-group mb-3'>
                <textarea class='form-control' placeholder="Message" id="message" name="message" rows="4" required></textarea>
            </div>

            <button class="btn btn-primary" type="submit">Send Message</button>
        </form>
        
    </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminEmail = "khuong.huy.careers@gmail.com"; 
    $userEmail = "khuongnhathuy@gmail.com";
    $name = $_POST["name"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Compose the email message
    $emailMessage = "Name: $name\n";
    $emailMessage .= "Email: $userEmail\n";
    $emailMessage .= "Subject: $subject\n\n";
    $emailMessage .= "Message:\n$message";

    // Send the email
    $success = mail($adminEmail, "Contact Form Submission", $emailMessage);

    if ($success) {
        echo "Message sent successfully!";
    } else {
        echo "Failed to send the message. Please try again later.";
    }
}
?>

