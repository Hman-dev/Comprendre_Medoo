<?php
session_start();
require_once ("database.php");

$id2 = $_GET['GetId']; /* Ici on va creer une variable qui récupère l'id de lutilisateur dans l'url */
// var_dump($_GET['GetId']);
// $data = $database->select('utilisateur','*',['id'=>$id2]); 
//  Est -ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['GetId']) && !empty($_GET['GetId'])){
    $GetId = strip_tags($_GET['GetId']);
    $utilisateur = $database->get('utilisateur',
    ['id','nom','prenom','email','motdepasse','statut'],
    ['id'=>$id2]);

    if(!$utilisateur['id']){
        $_SESSION['erreur'] = "Cet id n'existe pas !" ; 
        header('location:home.php');
    }

}
else{
    $_SESSION['erreur']= "Cet id n'existe pas !";
    header("location:home.php");
}



if(isset($_POST['update'])){

    if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email'])
     && isset($_POST['mdp']) && isset($_POST['mdp2']) && isset($_POST['statut']))
     { 
        $id = htmlspecialchars($_POST['id']);
        $lastname = htmlspecialchars($_POST['nom']);
        $firstname = htmlspecialchars($_POST['prenom']);
        $mail = htmlspecialchars($_POST['email']);
        $mdp = htmlspecialchars($_POST['mdp']);
        $mdp2=  $_POST['mdp2'];
        $passworvalid = $mdp==$mdp2;
        $pass1 = !empty($mdp)?password_hash($passworvalid,PASSWORD_DEFAULT):$utilisateur['motdepasse'];
        $statut = $_POST['statut'];

        // $database->debug()->update("utilisateur",[
        //     "nom"=>$lastname,
        //     "prenom"=>$firstname,
        //     "email"=>$mail,
        //     "motdepasse"=>$pass1,
        //     "statut"=>$statut],
        //     ["id"=>$id]);
        // echo"<p class='text-white'>utilisateurs update avec success<p>"; 
        // header("location:home.php");  
        // // var_dump($database);
        // var_dump($id2);
        

        // require_once ("database.php");
        // var_dump($nom)."<br/>";
        if($mdp===$mdp2){
            $database->update("utilisateur",[
                "nom"=>$lastname,
                "prenom"=>$firstname,
                "email"=>$mail,
                "motdepasse"=>$pass1,
                "statut"=>$statut],
                ["id"=>$id]);
            
              echo($_SESSION['message'] = "L'utilisateur id[$utilisateur[id]] a été modifié avec succes ");
            // echo"<p class='text-white'>utilisateurs update avec success<p>"; 
            header("location:home.php");  

            if(empty($mdp) && empty($mdp2)){
                $database->update("utilisateur",[
                    "nom"=>$lastname,
                    "prenom"=>$firstname,
                    "email"=>$mail,
                    "statut"=>$statut],["id"=>$id]);
               
                    echo($_SESSION['message'] = "L'utilisateur id[$utilisateur[id]] a été modifié avec succes ");
                    header("location:home.php"); 
                }
        }else{
            if($mdp !== $mdp2){
    
                echo'<script type="text/javascript">';
                echo'alert("Vos deux mots de passes ne sont pas indentiques!")';
                echo'</script>';
    
                if(!preg_match('`^\w{4,8}$`',$mdp,$mdp2)){
                echo'<script type="text/javascript">';
                echo'alert("Votre mot de passe doit contenir entre 4 et 8 des lettres et des chiffres!")';
                echo'</script>';
                    }
    
            }
            
                         
           
    
        }  
 
    }
            

    // header("location:home.php");   

    
        
}else{
    // $_SESSION['erreur'] = "le formulaire incomplet: Aucune modification n'a été prise en compte ! ";
}










?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Modification Utilisateur</title>
</head>
<body class="bg-dark">
<div class="contenair">
    <div class="row">
        <div class="col-lg-6 m-auto">
        <?php
            if(!$utilisateur){
                $_SESSION['erreur']= "Cet id n'existe pas  ";
                // header("location:home.php");
            }   

        ?>
            <div class="card mt-5">
                <div class="card-title">
                    <h1 class="bg-success text-white text-center py-3">Modification Utilisateur</h1>

                    <div class="card-body text-center">

                        <form action="formuser.php?GetId=<?php echo $id2?>" method ="post" >

                        <label for="inid">ID </label>
                         <input style= "background:red" type="text"  name="id" id="inid" value="<?= $id2;?>" readonly></br></br>            

                        <label>Nom: </label>
                        <input style= "background:red" type="text" name="nom" value="<?= $utilisateur['nom']?>" /></br></br>

                        <label>Prénom: </label>
                        <input style= "background:red" type="text" name= "prenom" value="<?= $utilisateur['prenom'] ?>" /></br></br>

                        <label>Email: </label>
                        <input style= "background:red" type="email" name= "email" value="<?= $utilisateur['email']?>" /></br></br>

                        <label >Mot de passe: </label>
                        <input style= "background:red" type="password" name= "mdp" /></br></br>
                        <label >Confirmez mot de passe</label>
                        <input style= "background:red" type="password" name= "mdp2" /></br></br>

                        <p>Etes-vous ?<p>
                        <input style= "background:red" type="radio" name= "statut" value="professionnel"<?php if($utilisateur['statut']=="professionnel"){echo'checked';}?>>
                        <label for="professionnel">Professionnel</label><br>

                        <input  type="radio" name= "statut" value ="particulier" <?php if($utilisateur['statut']=="particulier"){echo'checked';}?>>
                        <label for="particulier">Particulier</label><br><br>


                        <input type="submit" name="update" value="Envoyer" class="btn btn-primary"></br></br>

                        </form>
                        
                    </div>
            </div>
        
        </div>
        
        </div>

    </div>
    
    
</body>
</html>