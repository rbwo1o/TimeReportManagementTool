<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail{

    public static function email_password($email, $password){

        $mail = new PHPMailer();

        try {
            $mail->SMTPDebug = 2;                                       
            $mail->isSMTP();                                            
            $mail->Host       = 'mail.blomand.net;';                    
            $mail->SMTPAuth   = true;                             
            $mail->Username   = 'USERNAME';  // !!!               
            $mail->Password   = 'PASSWORD';  // !!!                      
            $mail->SMTPSecure = 'tls';                              
            $mail->Port       = 587;  
        
            $mail->setFrom('USERNAME', 'USERNAME');     // !!!!      
            $mail->addAddress($email, 'Name');
            
            $mail->isHTML(true);                                  
            $mail->Subject = 'Timeline Password Reset';
            $mail->Body    = "Here is you're temporary password: " . $password . "<br><br>Please log in and change you're password";
            $mail->send();

            $_SESSION['reset_password'] = $email;
            Flight::redirect("/");
            }catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }  
    }
    
}

?>