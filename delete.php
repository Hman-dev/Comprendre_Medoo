<?php  
session_start();
            
    $id = $_GET["id"];
    if((isset($_GET["id"])) && ! empty($_GET["id"])){
        require_once("database.php");
        
        $utilisateur = $database->get('utilisateur',
        ['id','nom','prenom','email','motdepasse','statut'],
        ['id'=>$id]);
        var_dump($utilisateur['id']);

        if(!$utilisateur['id']){
            $_SESSION['erreur'] ="Cet id n'existe pas";
            header('location:home.php');

        }

       $database->delete("utilisateur", ["id"=>$id]);
       
       $_SESSION['erreur'] = "L'utilisateur a bien été supprimé avec succes !";
       header('location:home.php');



        // $data2 = $database->delete('utilisateur',['id'=>$utilisateur['id']]);
        // var_dump($data2);
        // var_dump($data);
    }