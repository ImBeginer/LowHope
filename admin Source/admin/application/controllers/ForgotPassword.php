<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
require_once FCPATH .'/vendor/autoload.php';
class ForgotPassword extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('ForgotPasswordModel');
       
    }

    /**
     * 
     * @return [type] [description]
     */
    public function index()
    {
        $data = [];
        $this->load->view('ForgotPassword', $data);
    }

    public function random_pass()
    {
        // $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $number = "1234567890";
        $special = "@#!";
        $low_alphabet = "abcdefghijklmnopqrstuwxyz";
        $cap_alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ";

        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($number) - 1; //put the length -1 in cache
        for ($i = 0; $i < 4; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $number[$n];
        }
        $alphaLength = strlen($special) - 1; //put the length -1 in cache
        for ($i = 0; $i < 1; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $special[$n];
        }
        $alphaLength = strlen($low_alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 3; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $low_alphabet[$n];
        }
        $alphaLength = strlen($cap_alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 2; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $cap_alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function sendMail($to, $code)
    {
        $mail = new PHPMailer(true);
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        $mail->isHTML(true);
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Ask for HTML-friendly debug output
        //$mail->Debugoutput = 'html';
        $mail->CharSet = 'UTF-8';
        //Set the hostname of the mail server
        // $mail->Host = 'smtp.gmail.com';
        $mail->Host = 'smtp.gmail.com';
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;
        // $mail->Port = 25;
        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = "lowhope2017@gmail.com";
        //Password to use for SMTP authentication
        $mail->Password = "hanhphucnhe2509";
        //Set who the message is to be sent from
        $mail->setFrom('lowhope2017@gmail.com', 'Low Hope');
        //Set an alternative reply-to address
        $mail->addReplyTo('lowhope2017@gmail.com', 'Low Hope');
        //Set who the message is to be sent to
        $mail->addAddress($to);
        //Set the subject line
        $mail->Subject = '[LOW HOPE] ĐẶT LẠI MẬT KHẨU';

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        // $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
        
        $message  = "Chào bạn, <br><br>";
        $message .= "Chúng tôi nhận được yêu cầu đặt lại mật khẩu từ lowhope.com <br><br>";
        $message .= "Ðây là mật khẩu mới của bạn: <strong>";
        $message .= $code;
        $message .= "</strong> <br><br>";
        $message .= "Bạn cần đăng nhập lại để có thể đổi lại mật khẩu mới! <br>";
        $message .= "<hr>";
        $message .= "Chúc bạn sử dụng website vui vẻ, <br><br>";
        $message .= "<strong>LOW HOPE</strong>";

        $mail->Body = $message; 

        //Replace the plain text body with one created manually
        //$mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }

    function forgotPassword()
    {
        $email = $this->input->post('email');
        if ($this->ForgotPasswordModel->checkRole($email)) {
            $pass = $this->random_pass();
            $new_pass = md5($pass);
            if ($this->ForgotPasswordModel->updatePass($email, $new_pass)) {
                if ($this->sendMail($email, $pass)) {
                    echo json_encode(1);
                    return;
                }
            }
        }
        // check fail
        echo json_encode(0);
    }
}