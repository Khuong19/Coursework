<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer();

if (isset($_POST['send'])) {
    try {
        // Sender
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'khuong.huy.careers@gmail.com';
        $mail->Password = 'spcq rvnl vnje hxvz';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipient
        $recipientEmail = 'huykngch220063@fpt.edu.vn';
        $mail->addAddress($recipientEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $_POST['subject'];
        $mail->Body = '<b>Message from: ' . $_POST['name'] . '</b><br>' . $_POST['message'];

        // Send mail
        if ($mail->send()) {
            session_start();
            $_SESSION['success_message'] = 'Message has been sent';
            header("Location: ../../?sendmail");
            exit(); 
        } else {
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>
