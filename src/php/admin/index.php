<?php
// Répertoire où sont stockées les images de grande taille
$dir = '../pics';
// Répertoire où seront stockées les miniatures
$dir_mini = '../mini';
// Redifinition de la taille de la miniature
$ratio = 150;

// Test formulaire permettant d'uploader un fichier.
if (isset($_POST['go'])) {
	// Test si le champ permettant de soumettre un fichier est vide ou non
	if (empty($_FILES['my_pics']['tmp_name'])) {
	// Oui = message d'erreur
	$error = 'No file sent.';
	}
	else {
	// Examin du fichier uploadé en récupérant les infos sur le fichier.
	$table = @getimagesize($_FILES['my_pics']['tmp_name']);
	if ($table == FALSE) {
		// Fichier uploadé n'est pas une image -> Supp fichier uploadé -> affiche erreur.
		unlink($_FILES['my_pics']['tmp_name']);
		$error = 'Your file is not an image.';
	}
	else {
		// Test type : jpeg, png
		if ($table[2] == 2 || $table[2] == 3) {
		// Fichier avec le même nom que le fichier que l'on d'uploade, on modifie le nom du fichier que l'on upload
		if (is_file('../pics/'.$_FILES['my_pics']['name'])) $file_upload = '_'.$_FILES['my_pics']['name'];
		else $file_upload = $_FILES['my_pics']['name'];

		// Copie du fichier dans pics(dossier image taille réel).
		if (!copy($_FILES['my_pics']['tmp_name'], $dir.'/'.$file_upload)) {
			echo "La copie du fichier a échoué...\n";
		}
		else{
			copy ($_FILES['my_pics']['tmp_name'], $dir.'/'.$file_upload);
			echo "youpi";
		}

		// Image = jpeg
		if ($table[2] == 2) {
			//  création image depuis l'image stocké dans pics (librairie GD)
			$src = imagecreatefromjpeg($dir.'/'.$file_upload);
			// Test image : paysage, portrait
			if ($table[0] > $table[1]) {
			$im = imagecreatetruecolor(round(($ratio/$table[1])*$table[0]), $ratio);
			imagecopyresampled($im, $src, 0, 0, 0, 0, round(($ratio/$table[1])*$table[0]), $ratio, $table[0], $table[1]);
			}
			else {
			$im = imagecreatetruecolor($ratio, round(($ratio/$table[0])*$table[1]));
			imagecopyresampled($im, $src, 0, 0, 0, 0, $ratio, round($table[1]*($ratio/$table[0])), $table[0], $table[1]);
			}
			//Copie le fichier généré dans le répertoire des miniatures
			imagejpeg ($im, $dir_mini.'/'.$file_upload);
		}
		elseif ($table[2] == 3) {
			$src = imagecreatefrompng($dir.'/'.$file_upload);
			if ($table[0] > $table[1]) {
			$im = imagecreatetruecolor(round(($ratio/$table[1])*$table[0]), $ratio);
			imagecopyresampled($im, $src, 0, 0, 0, 0, round(($ratio/$table[1])*$table[0]), $ratio, $table[0], $table[1]);
			}
			else {
			$im = imagecreatetruecolor($ratio, round(($ratio/$table[0])*$table[1]));
			imagecopyresampled($im, $src, 0, 0, 0, 0, $ratio, round($table[1]*($ratio/$table[0])), $table[0], $table[1]);
			}
			imagepng ($im, $dir_mini.'/'.$file_upload);
		}
		// Redirection de l'admin vers acceuil
		header('location: index.php');
		exit();
		}
		else {
		unlink($_FILES['my_pics']['tmp_name']);
		$error = 'Your picture has not a good format.';
		}
	}
	}
}

// Test formulaire pour delete
if (isset($_GET['del'])) {
	if (empty($_GET['del'])) {
	// Parametre non renseigné = error
	$error = 'No image to delete.';
	}
	else {
	$pic_a_zapper = $_GET['del'];
	// Image + miniature existe = suppr
	if (is_file('../mini/'.$pic_a_zapper) && is_file('../pics/'.$pic_a_zapper)) {
		unlink('../mini/'.$pic_a_zapper);
		unlink('../pics/'.$pic_a_zapper);
	}
	// no exist = error
	else {
		$error = 'No image to delete.';
	}
	}
}
?>
<html>
<head>
<title>My gallery - Admin</title>
</head>

<body>

<!-- Formulaire pour uploader image -->

Add a pictures to the gallery :<br /><br />

<form action="index.php" method="post" enctype="multipart/form-data">
<input type="file" name="my_pics" /> <input type="submit" name="go" value="Send" />
</form>

<hr />

<!-- Miniatures avec lien pour suppr les images -->

Delete a pictures from the gallery (click on the thumbnail to delete the pictures) :<br /><br />
<?php
$table = array();
$folder = opendir ('../mini/');
while ($files = readdir ($folder)) {
	if ($files != '.' && $files != '..' && $files != 'index.php') {
	$table[] = $files;
	}
}
closedir ($folder);

$nbcol=2;
$nbpics = count($table);

if ($nbpics != 0) {
	echo '<table>';
	for ($i=0; $i<$nbpics; $i++){
	if($i%$nbcol==0) echo '<tr>';
	// Lien pour suppr
	echo '<td><a href="index.php?del=' , $table[$i] , '"><img src="../mini/' , $table[$i] , '" alt="Image" /></a></td>';
	if($i%$nbcol==($nbcol-1)) echo '</tr>';
	}
	echo '</table>';
}
else echo 'No image to display';

// affiche message d'erreur
if (isset($error)) echo '<br />' , $error;
?>
</body>
</html>