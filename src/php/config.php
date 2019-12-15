<?php
//$dsn = 'mysql:host=http://etudiants.eemi.tech/phpmyadmin;dbname=avanpraet;port=3306;charset=utf8';

try {
 
 $pdo = new PDO('mysql:host=localhost;dbname=avanpraet;charset=utf8', 'avanpraet' , 'qOBcXUSD6a');
 
 }
 catch (Exception $e)
 {
         die('Erreur : ' . $e->getMessage());
 }