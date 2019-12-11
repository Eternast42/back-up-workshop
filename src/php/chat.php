<!DOCTYPE html>
<?php
    $bdd = new PDO("mysql:host=127.0.0.1;dbname=tuto;charset=utf8", "root", "");
    if(isset($_POST['pseudo']) AND isset($_POST['message']) AND !empty($_POST['pseudo']) AND !empty($_POST['message'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $message = htmlspecialchars($_POST['message']);
        $insertmsg = $bdd->prepare('INSERT INTO chat(pseudo, message) VALUES(?, ?)');
        $insertmsg->execute(array($pseudo, $message));
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Galeria de Cauca</title>
</head>
<body>
    <form method="post" action="">
        <input type="text" name="pseudo" placeholder="PSEUDO" /><br />
        <textarea type="text" name="message" placeholder="MESSAGE"></textarea><br />
        <input type="submit" value="Submit" />
    </form>
    <?php
        $allmsg = $bdd->query('SELECT * FROM chat');
        while($msg = $allmsg->fetch()) {
            echo ($msg['pseudo'].' : ');
            echo ($msg['message'].'<br>');

        }
    ?>
</body>
</html>