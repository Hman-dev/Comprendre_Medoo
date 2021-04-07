<?php
session_start();
require_once ("database.php");
// var_dump($database->get('utlisateur','*',['id'=>2]));
if(!empty($_SESSION['erreur'])){
    echo '<div class="alert alert-danger text-center" role="alert">
    '.$_SESSION['erreur'].'
  </div>';
  $_SESSION['erreur']="";
  }

if(isset($_POST['soummettre'])){


    if(empty($_POST['condition'])|| (empty($_POST["nom"]))|| empty($_POST["prénom"]) 
    || empty($_POST["mail"]) || empty($_POST["mdp"]) || empty($_POST["mdp2"]) 
    || empty($_POST["statut"])){
       
        echo '<script type="text/javascript">';
        echo 'alert("Vous devez accepter les conditions et remplir tousles champs !")'; 
        echo '</script>';
     
    }else{

        if((isset($_POST["nom"])) && isset($_POST["prénom"]) 
            && isset($_POST["mail"]) && isset($_POST["mdp"]) && isset($_POST["mdp2"]) 
            && isset($_POST["statut"])){
                
                $nom = htmlspecialchars($_POST["nom"]);
                $prenom = htmlspecialchars($_POST["prénom"]);
                $email = htmlspecialchars($_POST["mail"]);
                $mdp = htmlspecialchars($_POST["mdp"]);
                $pass = password_hash($mdp, PASSWORD_DEFAULT);
                $mdp2= $_POST["mdp2"];
                $statut = $_POST["statut"];

                if($mdp !== $mdp2){

                    echo'<script type="text/javascript">';
                    echo'alert("Vos deux mots de passes ne sont pas indentiques!")';
                    echo'</script>';

                    if(!preg_match('`^\w{4,8}$`',$mdp,$mdp2)){
                    echo'<script type="text/javascript">';
                    echo'alert("Votre mot de passe doit contenir entre 4 et 8 des lettres et des chiffres!")';
                    echo'</script>';
                    }
                }else{
                    $email = htmlspecialchars($_POST['mail']); 

                   $mailexist= $database->get('utilisateur','*',['email'=>$email,
                    ]);

                    // var_dump($mailexist);

                    if($mailexist !=false){

                        echo'<script type="text/javascript">';
                        echo'alert("Cette email existe dejà!")';
                        echo'</script>';
                        // email n'existe pas 
                        var_dump($mailexist);  
                        
                    }else{

                        $database->insert('utilisateur',[
                            'nom'=>$nom,
                            'prenom'=>$prenom,
                            'email'=>$email,
                            'motdepasse'=>$pass,
                            'statut'=>$statut,

                        ]);
                        echo($_SESSION['message'] = "<p>L'utilisateur a bien été ajouté avec succes</p>");
                        header("location:home.php"); 
                        // header("location:Exo3_suite_login_Medoo.php");

                        var_dump($database);

                       /* $base1 = new PDO('mysql:host=localhost;dbname=niveau2;charset=utf8', 'root', '');
                        $sql1 = "INSERT INTO utilisateur(nom,prénom,email,motdepasse,statut) VALUES('$nom','$prenom', '$email' ,'$pass' ,'$statut')";
                        $base1 -> query($sql1);
            
                        echo $sql1."<br><br>";*/
                        
                        
            
                    } 
                    
                }
            
            }
            

       
        
         
    }
    


        



   

    
}else{
    echo'<script type="text/javascript">';
    echo'alert("Vous devez rentrer tous les champs Merci!")';
    echo'</script>';
}

  

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Signin</title>
    

</head>
<body class="bg-dark">

<div class="contenair">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card mt-5">
                <div class="card-title">
                    <h1 class="bg-success text-white text-center py-3">Ajouter un utilisateur</h1>

                    <div class="card-body text-center">

                        <form action="add.php" method ="post" >

                        <label>Nom: </label>
                        <input style= "background:red" type="text" name="nom" /></br></br>

                        <label>Prénom: </label>
                        <input style= "background:red" type="text" name= "prénom" /></br></br>

                        <label>Email: </label>
                        <input style= "background:red" type="email" name= "mail" /></br></br>

                        <label >Mot de passe: </label>
                        <input style= "background:red" type="password" name= "mdp" /></br></br>
                        <label >Confirmez mot de passe</label>
                        <input style= "background:red" type="password" name= "mdp2" /></br></br>

                        <p>Etes-vous ?<p>
                        <input style= "background:red" type="radio" name= "statut" value="professionnel">
                        <label for="professionnel">Professionnel</label><br>

                        <input  type="radio" name= "statut" value = "particulier">
                        <label for="particulier">Particulier</label><br><br>

                        <input type="checkbox" name="condition">
                        <label><a href="#">Je reconnais avoir pris connaissance des conditions d'utilisation et y adhère totalement</a></label></br></br>


                        <input type="submit" name="soummettre" value="valider"></br></br>

                        </form>
                        
                    </div>
            </div>
        
        </div>
        
        </div>

    </div>
    








</body>
</html>