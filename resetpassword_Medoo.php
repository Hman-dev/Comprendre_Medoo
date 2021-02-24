<?php
 session_start();
require_once ("database.php");
if(isset($_POST['envoyer'])){
    include "sendemail.php";

    $mail= htmlspecialchars($_POST['utilisateur']);

    if(!empty($mail)){
       

        $mail_exist = $database->get('utilisateur','*',['email'=>$mail]);
    //   ici on créer une variable qui va chercher en base de données si l'utilisateur a déjà une adresse mail existante dans la bdd
        // var_dump($mail_exist);

        if($mail_exist !=false){
             $_SESSION['utilisateur']= $mail_exist['id'];
           

            // $string = implode('', array_merge(range('A','Z'), range('a','z'), range('0','9')));
			// $token = substr(str_shuffle($string), 0, 20);
            $token = bin2hex(random_bytes(32));
            $to = $mail;
            $subject= "Récuperatuion mot de passe";
            $body = "<p>Vous pouvez récuperer votre mot de passe via ce lien: <a href='http://localhost/Comprendre_Medoo/newpassword_Medoo.php?id=".$token."'>http://localhost/Comprendre_Medoo/newpassword_Medoo.php?id=".$token."</a></p>";
         
            send_mail($to,$subject,$body);
            

           echo ('<body onLoad="alert(\'Votre mot de passe a bien été envoyée à l\ adresse mail renseigné!\')">');
            
        }else{
            echo ('<body onLoad="alert(\'Mail inexistant.Veuillez rentrer un mail valide\')">');
        }

    }
    else{
        echo ('<body onLoad="alert(\'Veuillez rentrer  un mail valide !\')">');
    }
}

var_dump(dechex(time()));

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récupération mot de passe</title>
</head>
<style>
.center{
   text-align: center;
}
</style>

<body class="center">
<div >

<h2>Réinitailisation du mot de passe</h2>

<form action="resetpassword_Medoo.php" method="POST">
<label > Email :</label>
<input type="email" name="utilisateur" placeholder="rentrez votre mail"/><br/><br/>
<input type="submit" value="Envoyer" name="envoyer">

</form>
</div>


    
</body>
</html>