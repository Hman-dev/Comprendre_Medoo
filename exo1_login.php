<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
<h1>Connexion Utilisateur</h1>
<form action="exo1_login.php" method ="post">
    <label>Login :</label>
    <input type="text" name="utilisateur" required/> 
    <label>password</label>
    <input type="password" name= "mdp" required/>
    <input type="submit" value="valider">
    
</form>

<?php

include "database.php"; /* Pour inclure et initialiser la connexion à la base de données*/


if(isset($_POST['utilisateur']) && isset($_POST['mdp'])){
$login = $_POST['utilisateur'];
$mdp = $_POST['mdp'];
$date = date('Y-m-d H:i:s');

// Méthode d'insertion dans la base de donnée avec le framework Medoo

$database->insert ('connexions', [
    'login' => $login,
    'motdepasse' => $mdp,
    'date'=>$date,
]);

// echo"<p>Votre compte a été bien créer !</p>";

// Ancienne méthode d'insertion dans une base de données avec la méthode PDO.
/*/$base = new PDO('mysql:host=localhost;dbname=niveau2;charset=utf8', 'root', '');

$sql = "INSERT INTO connexions(login,motdepasse, date) VALUES('$login','$mdp', '$date')"; 
$base->query($sql);
echo $sql ;*/


}
if(!isset($_POST['submit'])){
    echo("");
}
?>

</body>
</html>