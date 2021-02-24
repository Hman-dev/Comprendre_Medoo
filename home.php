<?php
session_start();
require_once ("database.php");
// print_r($_SESSION);
echo "'<p style=text-align:center;font-size:20px;color:white;> Bonjour cher membre : ".$_SESSION['utilisateur'].'<a href="add.php" class="btn btn-primary m-4 ">Ajouter un utilisateur</a>'.'</p>';
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Membres</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body class="bg-dark">
<div class="container mt-5">
          <?php
          // include "formuser.php";
              if(!empty($_SESSION['erreur'])){
                echo '<div class="alert alert-danger text-center" role="alert">
                '.$_SESSION['erreur'].'
              </div>';
              $_SESSION['erreur']="";
              }
          ?>
        <div class="row">
            <div class="col m-auto">
              <div class="card mt-5">
                <h2 class="bg-success text-white text-center">Voici tous les membres utilisateurs</h2>
                  <table class=" table table-bordered table-hover table-responsive">
                      <tr>
                          <th>Id</th>
                          <th>Nom</th>
                          <th>Prenom </th>
                          <th>Email</th>
                          <th>Statut</th>
                          <th>Modifier utilisateur</th>
                          <th>Supprimer utilisateur</th>
                          
                      </tr>

                      


                      <?php
                        $data = $database->select('utilisateur','*');
                      //  Ici on fait une boucle pour afficher tous les informations des utilisateurs contenues dans notre table 
                        foreach($data as $utilisateur){
                          $id = $utilisateur['id'];
                          $nom = $utilisateur['nom'];
                          $prenom = $utilisateur['prenom'];
                          $email = $utilisateur['email'];
                          $statut = $utilisateur['statut'];
                            ?>
                             <tr>
                                <td><?php echo $id ?></td>
                                <td><?php echo $nom ?></td>
                                <td><?php echo $prenom ?></td>
                                <td><?php echo $email?></td>
                                <td><?php echo $statut ?></td>
                                <td class="text-center"><a href="formuser.php?GetId=<?php echo $id?>" class="btn btn-primary">Modifier</a></td>
                                <td class="text-center"><a href="#" class="btn btn-danger">Supprimer</a> </td>
                             </tr>
                      <?php    
                        }
                       ?>

                  </table>
                  
              </div>


            </div>
        </div>
    </div>


    
</body>
</html>