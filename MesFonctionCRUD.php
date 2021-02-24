<?php
require_once ("database.php");


function getDatabaseConnexion(){
    require_once ("database.php");

}


$requete= $database->select('utilisateur','*');
// var_dump($requete)."<\br>";

function getAllusers(){
    $conn= getDatabaseConnexion();
    
    
}
var_dump(getAllusers($requete));

function readUser($id){
    
}
function creatUser($nom,$prenom,$email,$motdepasse,$statut){
    
}

function updateUser($motdepasse,$id){
    
}

function delete($id){
    
}
?>