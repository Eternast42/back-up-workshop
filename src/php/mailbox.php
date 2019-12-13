<?php

    session_start();

    $bdd = new PDO('mysql:host=locahost;dbname=avanpraet;charset=UTF-8', 'avanpraet', 'qOBcXUSD6a');
    //$bdd = new PDO('mysql:host=localhost;dbname=tuto', 'root', '');

    if(isset($_SESSION['id']) && !empty($_SESSION['id'])) {
        $message = $bdd->prepare('SELECT * FROM message WHERE id_receiver = ?');
        $message->execute(array($_SESSION['id']));
        $message_nbr = $message->rowCount();
        
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
    <a href="profile.php?id=<?php echo $_SESSION['id']; ?>">Profile</a>
    <a href="send.php">Send a Message</a><br /><br /><br />
    <h3>Your mail box :</h3>
    <?php echo('You have : '.$message_nbr.' Messages');?>
    <br /><br /><br />
    <?php
        if($message_nbr == 0) {
            echo ("You have no message.");
        }
        while($i = $message->fetch()) {
            $name_sender = $bdd->prepare('SELECT name FROM membres WHERE id = ?');
            $name_sender->execute(array($i['id_sender']));
            $name_sender = $name_sender->fetch();
            $name_sender = $name_sender['name'];
    ?>
    <?php if($i['haveread'] == 1) { ?><br /><font color="blue"><i>Already read</i></font><br /><?php } else { ?> <br /><font color="red"><i>Unread</i></font><br /> <?php } ?><b><?php echo($name_sender); ?></b> sent you a message. <br /><a href="read.php?id=<?php echo $i['id']; ?>">Click here to read it</a><br />
    <?php } ?>
    
</body>
</html>

<?php } ?>