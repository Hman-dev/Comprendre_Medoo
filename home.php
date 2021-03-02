<?php
session_start();
require_once("database.php");

// print_r($_SESSION);
echo "'<p style=text-align:center;font-size:20px;color:black;> Bonjour cher membre : " . $_SESSION['utilisateur'] . '<a href="add.php" class="btn btn-primary m-4 ">Ajouter un utilisateur</a>' . '<a href="Exo3_suite_login_Medoo.php" class="btn btn-primary m-4 ">Se déconnecter</a>' . '</p>';

?>




<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accès Membres</title>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
</head>

<body class="">
  <div class="container mt-5">
    <?php
    include_once("database.php");
    if (!empty($_SESSION['erreur'])) {
      echo '<div class="alert alert-danger text-center" role="alert">
                ' . $_SESSION['erreur'] . '
              </div>';
      $_SESSION['erreur'] = "";
    }



    ?>
    <div class="toggle">
      <input type="checkbox" class="checkbox" id="dark-mode">
      <label for="dark-mode" class="label">
        <i class="fas fa-moon"></i>
        <i class="fas fa-sun"></i>
        <div class="ball"></div>
    </div>
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
            $data = $database->select('utilisateur', '*');
            //  Ici on fait une boucle pour afficher tous les informations des utilisateurs contenues dans notre table 
            foreach ($data as $utilisateur) {
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
                <td><?php echo $email ?></td>
                <td><?php echo $statut ?></td>
                <td class="text-center"><a href="formuser.php?GetId=<?php echo $id ?>" class="btn btn-primary">Modifier</a></td>
                <td class="text-center"><button type="button" class="btn btn-danger deletebtn"><a href="home.php?GetId=<?= $id ?>"> Supprimer</a> </button></td>
              </tr>
            <?php
            }


            ?>
          </table>
          <?php
          if ((isset($_GET["delete"])) && !empty($_GET["delete"])) {

            $data2 = $database->delete('utilisateur', ['id' => $id]);
          }
          ?>



          <div class="modal fade" id="deletmodal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form action="home.php" method="GET">
                  <div class="modal-body">
                    <input type="hidden" name="delete_id" id="delete_id">
                    <h4>Etes vous sur de vouloir supprimer ? </h4>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" name="deletuser" class="btn btn-primary deletuser">Valider</a>
                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>


      </div>
    </div>
  </div>



</body>
<script>
  $(document).ready(function() {
    $(".deletebtn").click(function() {
      if (window.confirm('Voulez-vous vraiment supprimer cet utilisateur ?')) {
        window.location.href = "home.php?delete=" + $(this).attr("id");
      }
    })
  });
</script>
<script>
        const darkMode = document.getElementById('dark-mode');
        // cette input on va lui dire d'écouter(qd ça change  paremètre d'une fonction 
        // fléchée au document body tu ajoute une classe

        darkMode.addEventListener('change', () => {
            document.body.classList.toggle('dark');
            
        });
    </script>

</html>