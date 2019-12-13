<?php

    session_start();

    $bdd = new PDO('mysql:host=locahost;dbname=avanpraet;charset=UTF-8', 'avanpraet', 'qOBcXUSD6a');
    //$bdd = new PDO('mysql:host=localhost;dbname=tuto', 'root', '');

    if(isset($_SESSION['id']) && !empty($_SESSION['id'])) {
        if(isset($_POST['sendmessage'])) {
            if(isset($_POST['receiver'],$_POST['message']) && !empty($_POST['receiver']) && !empty($_POST['message'])) {
                $receiver = htmlspecialchars($_POST['receiver']);
                $message = htmlspecialchars($_POST['message']);

                $reqid = $bdd->prepare('SELECT id FROM membres WHERE name = ?');
                $reqid->execute(array($receiver));
                $reqsender = $reqid->rowCount();

                if($reqsender == 1) {
                    $reqid = $reqid->fetch();
                    $reqid = $reqid['id'];
                    $insert = $bdd->prepare('INSERT INTO message(id_sender,id_receiver,message) VALUES (?,?,?)');
                    $insert->execute(array($_SESSION['id'],$reqid,$message));

                    $valid = "Your Message has been sent.";
                } else {
                    $error = "This person/name doesn't exist.";
                }
            } else {
                $error = "No empty line please.";
            }
        }

        $receivers = $bdd->query('SELECT name FROM membres ORDER BY name');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>La galeria de Cauca</title>
</head>
<body>
    
    <form method="POST">
        <div align="center">
            <label>Send a message to a Member :</label>
            <select name="receiver">
                <?php while($i = $receivers->fetch()) { ?>
                <option><?php echo $i['name']; ?></option>
                <?php } ?>
            </select>
            <br /><br />
            <textarea placeholder="Your Message" name="message" rows="8" cols="60"></textarea>
            <br /><br />
            <input type="submit" value="Send it" name="sendmessage"/>
            <br /><br />
            <?php
                if(isset($error)) {
                    echo('<font color="red">'.$error.'</font>');
                }
                if (isset($valid)) {
                    echo('<font color="green">'.$valid.'</font>');
                }
            ?>
            <br />
            <a href="mailbox.php">Go to your Mailbox</a>
        </div>
    </form>

</body>
</html>
<?php } else {
    header("Location: login.php");
} ?>
