<?php
    session_start();

    $bdd = new PDO('mysql:host=locahost;dbname=avanpraet;charset=UTF-8', 'avanpraet', 'qOBcXUSD6a');
    //$bdd = new PDO('mysql:host=localhost;dbname=tuto', 'root', '');

    if(isset($_POST['formconnect'])) {
        $mailconnect = htmlspecialchars($_POST['mailconnect']);
        $pswconnect = sha1($_POST['pswconnect']);
        if(!empty($mailconnect) && !empty($pswconnect)) {
            $requser = $bdd->prepare('SELECT * FROM membres WHERE mail = ? AND psw = ?');
            $requser->execute(array($mailconnect, $pswconnect));
            $userexist = $requser->rowCount();
            if($userexist == 1) {
                $valid = "Login success";
                $userinfo = $requser->fetch();
                $_SESSION['id'] = $userinfo['id'];
                $_SESSION['name'] = $userinfo['name'];
                $_SESSION['mail'] = $userinfo['mail'];
                header("Location: profile.php?id=".$_SESSION['id']);
            } else {
                $error = "Wrong Mail or Password.";
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
            <h2>Login :</h2>
            <br /><br />
            <form method="POST" action="">
                <input type="email" name="mailconnect" placeholder="Mail" />
                <input type="password" name="pswconnect" placeholder="Password" /><br /><br />
                <input type="submit" name="formconnect" value="Connect here !" />
                <p> or </p>
                <a href="register.php">Register here</a>
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