<?php
        $name = $_POST['name'];
        $mail = $_POST['mail'];
        $message = $_POST['message'];
        $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);

        $mailTo = "thomas.tilly@eemi.com";
        $headers = "From: ".$mail;
        $text = "You have received an e-mail from ".$name.".\n\n".$message;

        if(mail($mailTo, $text, $headers))
                echo "Your message has been sent";
        else
                echo "Send it again please";
?>