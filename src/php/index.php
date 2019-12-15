<!DOCTYPE html>
<html>
<head>
    <title>My gallery</title>
</head>

<body>
<?php
// Tableau contenant nom des fichiers de nos miniatures
$table = array();
// Ouverture dossier
$folder = opendir ('./mini/');
while ($files = readdir ($folder)) {
	if ($files != '.' && $files != '..' && $files != 'index.php') {
	// Stock nom de fichier dans un tableau
	$table[] = $files;
	}
}
closedir ($folder);

// definition du nombre de colonne
$nbcol=2;
// compte nombre miniature
$nbpics = count($table);

// if 1 miniature = toute les afficher
if ($nbpics != 0) {
	echo '<table>';
	for ($i=0; $i<$nbpics; $i++){
	if($i%$nbcol==0) echo '<tr>';
	// Chaque miniature -> affiche la miniature avec lien vers la photo en taille réelle
	echo '<td><a href="pics/' , $table[$i] , '"><img src="mini/' , $table[$i] , '" alt="Pictures" /></a></td>';
	if($i%$nbcol==($nbcol-1)) echo '</tr>';
	}
	echo '</table>';
}
// Aucune miniature :)
else echo 'no image to display';
?>
</body>
</html>