<?php
    session_start();

    $bdd = new PDO('mysql:host=locahost;dbname=avanpraet;charset=UTF-8', 'avanpraet', 'qOBcXUSD6a');
    //$bdd = new PDO('mysql:host=localhost;dbname=tuto', 'root', '');

    if(isset($_GET['id']) && $_GET['id'] > 0) {
        $getid = intval($_GET['id']);
        $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
        $requser->execute(array($getid));
        $userinfo = $requser->fetch();

?>

<html>
    <head>
        <title>La galeria de Cauca</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div align="center">
            <h2>Welcome on your profile, <?php echo $userinfo['name']; ?>. </h2>
            <br /><br />
            Name = <?php echo $userinfo['name']; ?>.
            <br />
            Mail = <?php echo $userinfo['mail']; ?>.
            <br /><br />
            <?php
                if(isset($_SESSION['id']) && $userinfo['id'] == $_SESSION['id']) { 
            ?> 
            <a href="editprofile.php">Edit your Profile</a><br />
            <a href="send.php">Send a Message</a> /
            <a href="mailbox.php">My Messages</a><br /><br />
            <a href="disconnect.php">Disconnect</a>
            <?php
                } 
            ?>
        </div>
    </body>
</html>
<?php
}
?>