<?php
    session_start();

    $bdd = new PDO('mysql:host=locahost;dbname=avanpraet;charset=UTF-8', 'avanpraet', 'qOBcXUSD6a');
    //$bdd = new PDO('mysql:host=localhost;dbname=tuto', 'root', '');

    if(isset($_SESSION['id'])) {
        $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
        $requser->execute(array($_SESSION['id']));
        $user = $requser->fetch();
        if(isset($_POST['newname']) && !empty($_POST['newname']) && $_POST['newname'] != $user['name']) {
            $newname = htmlspecialchars($_POST['newname']);
            $insertname = $bdd->prepare("UPDATE membres SET name = ? WHERE id = ?");
            $insertname->execute(array($newname, $_SESSION['id']));
            header('Location: profile.php?id='.$_SESSION['id']);
        }
        if(isset($_POST['newmail']) && !empty($_POST['newmail']) && $_POST['newmail'] != $user['mail']) {
            $newmail = htmlspecialchars($_POST['newmail']);
            $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
            $insertmail->execute(array($newmail, $_SESSION['id']));
            header('Location: profile.php?id='.$_SESSION['id']);
        }
        if(isset($_POST['newpsw1']) && !empty($_POST['newpsw1']) && isset($_POST['newpsw2']) && !empty($_POST['newpsw2'])) {
            $psw1 = sha1($_POST['newpsw1']);
            $psw2 = sha1($_POST['newpsw2']);
            if($psw1 == $psw2) {
                $insertpsw = $bdd->prepare("UPDATE membres SET psw = ? WHERE id = ?");
                $insertpsw->execute(array($psw1, $_SESSION['id']));
                header('Location: profile.php?id='.$_SESSION['id']);
            } else {
                $error = "Password doesn't match.";
            }
        }
        if(isset($_POST['newname']) && $_POST['newname'] == $user['name']) {
            header('Location: profile.php?id='.$_SESSION['id']);
        }
?>

<html>
    <head>
        <title>La galeria de Cauca</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div align="center">
            <h2>Edit your Profile</h2>
            <form method="POST" action="">
                <table>
                    <tr>
                        <td align="right">
                            <label>Name : </label><br /><br />
                        </td>
                        <td>
                            <input type="text" name="newname" placeholder="Name" value="<?php echo $user['name'] ?>" /><br /><br />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label>E-mail : </label><br /><br />
                        </td>
                        <td>
                            <input type="email" name="newmail" placeholder="Mail" value="<?php echo $user['mail'] ?>" /><br /><br />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label>Password : </label><br /><br />
                        </td>
                        <td>
                            <input type="password" name="newpsw1" placeholder="Password" /><br /><br />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label>Confirma Password : </label><br /><br />
                        </td>
                        <td>
                            <input type="password" name="newpsw2" placeholder="Confirm your Password" /><br /><br />
                        </td>
                    </tr>
                    <tr>
                    <td></td>
                        <td align="right">
                            <input type="submit" value="Apply changes !" />
                        </td>
                    </tr>
                </table>
            </form>
            <?php
                if(isset($error)) {
                    echo('<font color="red">'.$error.'</font>');
                }
            ?>
        </div>
    </body>
</html>
<?php
    } else {
        header("Location: login.php");
    }
?>