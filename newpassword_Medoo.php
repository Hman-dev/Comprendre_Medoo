<?php
session_start();
require_once ("database.php");

if(isset($_POST['envoyer'])){

    if(isset($_POST['mdp']) && isset($_POST['mdp2'])){
        $mdp = htmlspecialchars($_POST['mdp']);
        $mdp2 = htmlspecialchars($_POST['mdp2']);
        $pass =  password_hash($mdp, PASSWORD_DEFAULT);
        
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
            $utilisateur = $_SESSION['utilisateur'];
            $message_formulaire_valide = "Votre mot de passe ont été bien pris en compte";
            // var_dump($utilisateur);
            // $database->update('utilisateur',)
            $database->update('utilisateur', ['motdepasse'=>$pass],['id'=>$utilisateur]);
            echo '<p>'.$message_formulaire_valide.' <a href="index-6.html">Retour au formulaire</a></p>'."\n";
            echo '<script type="text/javascript">setTimeout(function(){window.top.location="Exo3_suite_login_Medoo.php"} , 6000);</script>';
        }
        


    }else{
        echo "<p style='color:red;'>Veuillez renseigner le nouveau mot de passe</p>";
    }

    // header("location:Exo3_suite_login_Medoo.php");

}


?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe</title>
</head>
<style>
    .center{
        text-align: center;
    }
</style>
<body>
<?php

?>
<div class="center">

    <h2>Nouveau mot de passe</h2>

    <form action="newpassword_Medoo.php" method="POST">
    <label > Nouveau mot de passe:</label>
    <input type="password" name="mdp" placeholder="mot de passe"/><br/><br/>
    <label >Confirmer votre mot de passe :</label>
    <input type="password" name="mdp2" placeholder="retapez mot de passe"/><br/><br/>
    <input type="submit" value="Envoyer" name="envoyer">

    </form>

</div>
    
</body>
</html>

