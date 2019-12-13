<?php

    session_start();

    $bdd = new PDO('mysql:host=locahost;dbname=avanpraet;charset=UTF-8', 'avanpraet', 'qOBcXUSD6a');
    //$bdd = new PDO('mysql:host=localhost;dbname=tuto', 'root', '');

    if(isset($_SESSION['id']) && !empty($_SESSION['id'])) {
        if(isset($_GET['id']) && !empty($_GET['id'])) {
            $id_message = intval($_GET['id']);
            $message = $bdd->prepare('SELECT * FROM message WHERE id = ? AND id_receiver = ?');
            $message->execute(array($_GET['id'],$_SESSION['id']));
            $message_nbr = $message->rowCount();
            $i = $message->fetch();

            $name_sender = $bdd->prepare('SELECT name FROM membres WHERE id = ?');
            $name_sender->execute(array($i['id_sender']));
            $name_sender = $name_sender->fetch();
            $name_sender = $name_sender['name'];
        
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
    <a href="mailbox.php">Go to your MailBox</a>
    <a href="send.php">Reply</a>
    <div align="center">
        <h3>Read message</h3><br />
        <?php 
            if($message_nbr == 0) {
                echo ("You are not the receiver of this message.");
            } else {

                ?>
        <b><?php echo($name_sender); ?></b> sent you: <br /><br />
        <?php echo(nl2br($i['message'])); ?>
        <?php } ?>
    </div>
</body>
</html>

<?php

        $haveread = $bdd->prepare('UPDATE message SET haveread = 1 WHERE id = ?');
        $haveread->execute(array($i['id']));

        }     
    } 
?>