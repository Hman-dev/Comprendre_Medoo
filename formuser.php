<?php
session_start();
require_once ("database.php");
$id2 = $_GET['GetId']; /* Ici on va creer une variable qui récupère l'id de lutilisateur dans l'url */
// var_dump($_GET['GetId']);
// $data = $database->select('utilisateur','*',['id'=>$id2]); 
//  Est -ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['GetId']) && !empty($_GET['GetId'])){
    $GetId = strip_tags($_GET['GetId']);
    $data = $database->select('utilisateur','*',['id'=>$id2]);
    // var_dump($database);
    foreach($data as $utilisateur){
        $id = $utilisateur['id'];
        $nom = $utilisateur['nom'];
        $prenom = $utilisateur['prenom'];
        $email = $utilisateur['email'];
        $motdepasse = $utilisateur['motdepasse'];
        $statut = $utilisateur['statut'];
      
        // echo"id:".$id2."<br/>";
      }
    if(!$data){
        $_SESSION['erreur']= "Cet id n'existe pas  ";
        header("location:home.php");
    }

}
else{
    $_SESSION['erreur']= "URL invalide";
    header("location:home.php");
}



if(isset($_POST['update'])){
   

    if(isset($_POST['nom'])&& isset($_POST['prenom'])&& isset($_POST['email'])
     && isset($_POST['mdp']) && isset($_POST['mdp2']) && isset($_POST['statut']))
     {
        $lastname = htmlspecialchars($_POST['nom']);
        $firstname = htmlspecialchars($_POST['prenom']);
        $mail = htmlspecialchars($_POST['email']);
        $mdp = htmlspecialchars($_POST["mdp"]);
        $mdp2= $_POST["mdp2"];
        $passworvalid = $mdp==$mdp2;
        $pass1 = !empty($mdp)?password_hash($passworvalid,PASSWORD_DEFAULT):$motdepasse;
      
        $statut1 = $_POST["statut"];
        // var_dump($nom)."<br/>";

    
        if($mdp !== $mdp2){

            echo'<script type="text/javascript">';
            echo'alert("Vos deux mots de passes ne sont pas indentiques!")';
            echo'</script>';

            if(!preg_match('`^\w{4,8}$`',$mdp,$mdp2)){
            echo'<script type="text/javascript">';
            echo'alert("Votre mot de passe doit contenir entre 4 et 8 des lettres et des chiffres!")';
            echo'</script>';
                }
    
      /*  $email = htmlspecialchars($_POST['mail']); 

        $mailexist= $database->get('utilisateur','*',['email'=>$email,
             ]);

            if($mailexist !=false){

                echo'<script type="text/javascript">';
                echo'alert("Cette email existe dejà!")';
                echo'</script>';
                // email n'existe pas      
          
             }*/
    }else{
        if($mdp===$mdp2){
            $database->debug()->update("utilisateur",[
                ['motdepasse'=>$pass1],
                ['id'=>$id2],   
    
            ]);
            var_dump($database);
            echo"<p class='text-white'>utilisateurs update avec success<p>"; 
            // header("location:home.php");
           
            
         }
         
         if(empty($mdp) && empty($mdp2)){
            $database->insert("utilisateur",[
                'nom'=>$lastname,
                'prenom'=>$firstname,
                'email'=>$mail,
                'statut'=>$statut1,['id'=>$id2],
                
    
            ]);
           
            echo"<p class='text-white'>utilisateurs update avec success<p>"; 
            }

    }
        
         
                    
         
       

    }
        
        
 

        
            

    header("location:home.php");   

    
        
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
            <div class="card mt-5">
                <div class="card-title">
                    <h1 class="bg-success text-white text-center py-3">Modification Utilisateur</h1>

                    <div class="card-body text-center">

                        <form action="formuser.php?GetId=<?php echo $id2?>" method ="post" >
                        <label for="inid">ID </label>
                         <input style= "background:red" type="text"  name="id" id="inid" value="<?= $id2;?>" readonly></br></br>            

                        <label>Nom: </label>
                        <input style= "background:red" type="text" name="nom" value="<?php echo $nom?>" /></br></br>

                        <label>Prénom: </label>
                        <input style= "background:red" type="text" name= "prenom" value="<?php echo $prenom ?>" /></br></br>

                        <label>Email: </label>
                        <input style= "background:red" type="email" name= "email" value="<?php echo $email ?>" /></br></br>

                        <label >Mot de passe: </label>
                        <input style= "background:red" type="password" name= "mdp" /></br></br>
                        <label >Confirmez mot de passe</label>
                        <input style= "background:red" type="password" name= "mdp2" /></br></br>

                        <p>Etes-vous ?<p>
                        <input style= "background:red" type="radio" name= "statut" value="professionnel"<?php if($statut=="professionnel"){echo'checked';}?>>
                        <label for="professionnel">Professionnel</label><br>

                        <input  type="radio" name= "statut" value ="particulier" <?php if($statut=="particulier"){echo'checked';}?>>
                        <label for="particulier">Particulier</label><br><br>


                        <input type="submit" name="update" value="Modifier" class="btn btn-primary"></br></br>

                        </form>
                        
                    </div>
            </div>
        
        </div>
        
        </div>

    </div>
    
    
</body>
</html>