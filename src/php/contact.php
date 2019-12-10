<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>La Galerie de Cauca</title>
        <link rel="stylesheet" href="../../assets/styles_contact.css" />

</head>

<?php
        $name = ""; $mail = ""; $message = "";
        $required1 = ""; $required2 = ""; $required3 = "";

        if (!($_POST))
                $empty = 1;
        else {
                $empty = 0;
                $name = strip_tags($_POST["name"]);
                $mail = strip_tags($_POST["mail"]);
                $message = strip_tags($_POST["message"]);
                if (trim($name) == "")
                        $required1 = "Veuillez renseigner ce champ.";
                if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
                        $required2 = "Veuillez renseigner ce champ ou votre adresse mail est invalide.";
                if (trim($message) == "")
                        $required3 = "Veuillez renseigner ce champ.";
        }
?>

<body class="background">
        <div class="all_page">
                <form action="form_contact.php" method="post">
                        <div class="header">
                                <div class="header__links">
                                        <a href="../../index.html">Home</a>
                                        <a href="./contact.php">Contact</a>
                                </div>
                        </div>
                        <div class="container2">
                                <div class="container2__question">
                                        <h1>Contact Us !</h1>
                                        <div>
                                                <div>
                                                        <label for="name">Your Name : </label>
                                                </div>
                                                <div>
                                                        <input type="text" name="name" id="name" placeholder="Full Name" required value="<?php echo(trim($name));?>"/>
                                                        <?php echo($required1);?>
                                                </div>
                                        </div>
                                        <br>
                                        <div>
                                                <div>
                                                        <label for="mail">Your E-mail : </label>
                                                </div>
                                                <div>
                                                        <input type="email" name="mail" id="mail" placeholder="E-mail" required value="<?php echo($mail);?>" />
                                                        <?php echo($required2);?>
                                                </div>
                                        </div>
                                        <br>
                                        <div>
                                                <div>
                                                        <label for="message">Write a Message : </label>
                                                </div>
                                                <div>
                                                        <textarea type="text" name="message" id="message" maxlength="140" rows="5" cols="45" placeholder="Maximum lenght 140 char..." required> <?php echo(trim($message));?> </textarea>
                                                        <?php echo($required3);?>
                                                </div>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                        <div>
                                                <input type="submit" value="Submit your Message" />
                                        </div>
                                </div>
                        </div>
                        <?php
                                if ($empty == 0) {
                                        if ($required1 == "" && $required2 == "" && $required3 == "") {
                                                $name = "";
                                                $mail = "";
                                                $message = "";
                                        }
                                }
                        ?>
                </form>
        </div>
</body>
</html>