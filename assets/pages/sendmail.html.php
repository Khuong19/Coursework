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

            <button class="btn btn-primary" name="send" type="submit">Send Message</button>
        </form>
        
    </div>
</div>

<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    $mail = new PHPMailer();
    if(isset($_POST['send'])) {
        try {
        //Sender
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'khuong.huy.careers@gmail.com';
        $mail->Password = 'spcq rvnl vnje hxvz';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        //Recipient
        $mail->addAddress('khuong.huy.careers@gmail.com');

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Test';
        $mail->Body = '<b>This is the message</b>';
        //Send mail
        if ($mail->send()) {
            echo 'Message has been sent';
        } else {
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    }
?>