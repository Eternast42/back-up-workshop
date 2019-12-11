<?php

    $bdd = new PDO('mysql:host=localhost;dbname=tuto', 'root', '');

    if(isset($_POST['formregister'])) {
        $name = htmlspecialchars($_POST['name']);
        $namelenght = strlen($name);
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);
        $psw = sha1($_POST['psw']);
        $psw2 = sha1($_POST['psw2']);
        if(!empty($_POST['name']) && !empty($_POST['mail']) && !empty($_POST['mail2']) && !empty($_POST['psw']) && !empty($_POST['psw2'])) {
            if($namelenght <= 30) {
                if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    if($mail == $mail2) {
                        $mailreq = $bdd->prepare('SELECT * FROM membres WHERE mail = ?');
                        $mailreq->execute(array($mail));
                        $mailexist = $mailreq->rowCount();
                        if ($mailexist == 0) {
                            if($psw == $psw2) {
                                $insertmbr = $bdd->prepare('INSERT INTO membres(name, mail, psw) VALUES (?, ?, ?)');
                                $insertmbr->execute(array($name, $mail, $psw));
                                $valid = "You are know registered. <a href=\"connection.php\">Connect here !</a>";
                            } else {
                                $error = "Password doesn't match.";
                            }
                        } else {
                            $error = "Mail already Exists.";
                        }
                    } else {
                        $error = "Mail doesn't match.";
                    }
                } else {
                    $error = "Enter a valid Mail.";
                }
            } else {
                $error = "Maximum lenght of your name is 30 char.";
            }
        } else {
            $error = "No empty line please.";
        }
    }

?>

<html>
    <head>
        <title>La galeria de Cauca</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div align="center">
            <h2>Register</h2>
            <br /><br />
            <form method="POST" action="">
                <table>
                    <tr>
                        <td align="right">
                            <label for="name"">Name :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Your Name" id="name" name="name" value="<?php if(isset($name)) { echo $name; } ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label for="mail"">Mail :</label>
                        </td>
                        <td>
                            <input type="email" placeholder="Your Mail" id="mail" name="mail" value="<?php if(isset($mail2)) { echo $mail; } ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label for="mail2"">Confirm Mail :</label>
                        </td>
                        <td>
                            <input type="email" placeholder="Confirm your Mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label for="psw"">Password :</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Your Password" id="psw" name="psw" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label for="psw2"">Confirm Password :</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Confirm your Password" id="psw2" name="psw2" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <br />
                            <input type="submit" name="formregister" value="Register here" />
                        </td>
                    </tr>
                </table>
            </form>
            <?php
                if(isset($error)) {
                    echo('<font color="red">'.$error.'</font>');
                }
                if (isset($valid)) {
                    echo('<font color="green">'.$valid.'</font>');
                }
            ?>
        </div>
    </body>
</html>