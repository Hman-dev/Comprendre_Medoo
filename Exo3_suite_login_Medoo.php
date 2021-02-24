
<?php
session_start();
require_once ("database.php");

if(isset($_POST["envoyer"])){

    if(isset($_POST['utilisateur']) && isset($_POST['mdp'])){

        // $base = new PDO('mysql:host=localhost;dbname=niveau2;charset=utf8', 'root', '');

        $login = htmlspecialchars($_POST['utilisateur']);
        $mdp = $_POST['mdp'];
        date_default_timezone_set('Europe/Paris');
        setlocale(LC_TIME,"fr_FR.UTF-8", "French_France.1252");
        $date = date('Y-m-d H:i:s');
        
        // $database->get('utilisateur','*',[
            // 'email'=>'$login']);

        $data = $database->get('utilisateur','*',[
                'email'=>$login]);

        var_dump($data);

       /* $search = $base->prepare("SELECT * FROM utilisateur WHERE email=?");
        $search ->execute([$login]);
        $loginexist = $search->fetch();
        // var_dump ($loginexist);*/

        if($data != false ){


            $hash = $data['motdepasse'];
            $result = password_verify($mdp,$hash);
             

            if($result){
                // echo ("<font color='red'>login réussi !");

                $_SESSION['utilisateur'] = $data['email'];

                header("location:home.php");
                
                 /* la fonction header location va rediriger
                 l'utilisateur vers sa session home.php 
                 */

                /*$base = new PDO('mysql:host=localhost;dbname=niveau2;charset=utf8', 'root', '');
                $sql = "INSERT INTO connexions(login,PASSWORD,heure_connexion) VALUES('$login','$result', '$date')";
                $base -> query($sql);*/
                $database->insert ('connexions',[
                    'login'=>$login, 
                    'motdepasse'=>$result,
                    'date'=>$date     
                
                ]);

                // var_dump($database)."<br><br>";
            }
            else{
                echo("<div align='center'><p><font color='red'>Les idendtifiants que vous avez tapé sont incorrectes !</p></div>");
            }

           

        }else{
            echo ('<body onLoad="alert(\'Membre non reconnu, Veuillez rentrer tous les champs merci!\')">');
        }


            }

        
        
    

}


?>



<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title> Page de Connexion</title>
</head>
<style>
.center{
    text-align: center;
}

</style>
<body class="bg-dark">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-6 m-auto">
              <div class="card mt-5">
                  <div class="card-title">
                    <h1 class="bg-success text-white text-center py-3">Connexion Utilisateur</h1>
                  </div>
                 <div class="center mt-1">        
                    <form action="Exo3_suite_login_Medoo.php" method ="post">
                        <div class="form-group">
                            <label>Email :</label>
                            <input type="email" name="utilisateur" placeholder ="Votre email" />
                        </div>

                        <div class="form-group">
                            <label>Password :</label>
                            <input type="password" name= "mdp" placeholder ="Votre mot de passe" />
                        </div>

                        <div class="form-group">
                            
                            <input type="submit" value="valider" name= "envoyer" class="btn btn-primary"/>
                        </div>
                     </form>

                  <p><a href="resetpassword_Medoo.php">Mot de passe oublié</a></p>
                </div>
              </div>


            </div>
        </div>
    </div>




</body>
</html>