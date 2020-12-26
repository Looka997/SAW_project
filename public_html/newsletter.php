<?php
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require("../phpmailer/src/PHPMailer.php");
    require("../phpmailer/src/Exception.php");
    require("../phpmailer/src/SMTP.php");



    //Create a new PHPMailer instance
    $mail = new PHPMailer();
    try {
        /*$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output*/

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6

        //Set the SMTP port number - 587 for authenticated TLS
        $mail->Port = 587;

        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = "SAWBlein@gmail.com";

        //Password to use for SMTP authentication
        $mail->Password = "Prova123";

        //Set who the message is to be sent from
        $mail->setFrom('newsletter@jojos.com', 'Team di JOJOS.com');

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Scopri le nuove creazioni dei tuoi artisti preferiti!';
        $mail->Body    = '<b>Ciao!</b><br>Uno dei tuoi artisti preferiti ha inserito un nuovo design, corri a vederlo!<br>Saluti dal <b>Team di JOJOS.com</b>';
        $mail->AltBody = 'Ciao!'."\r\n".'Uno dei tuoi artisti preferiti ha inserito un nuovo design, corri a vederlo!'."\r\n".'Saluti dal Team di JOJOS.com';

        //Set who the message is to be sent to
        require_once("../db_connections/connections.php");
        require_once("common/db_ops.php");
        $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);

            $sql = "SELECT email_follower FROM mail_list WHERE email_creator = ?";
            $stmt = my_oo_prepared_stmt($link, $sql, "s", $_SESSION["email"]); 
            $result = $stmt->get_result();

            while ($row_data = mysqli_fetch_array($result)) {
                $mail->addAddress($row_data['email_follower']);
            } 
            $mail->send();
            echo 'Message has been sent';
    } catch (Exception $e) {
         echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
