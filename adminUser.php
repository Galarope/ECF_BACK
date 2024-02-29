<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "session.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { // Si pas de session, ou si le role est différent de Admin alors admin.php dans l'url redirige vers l'index
    header("Location: index.php");
    exit();
}

use ECF\Mabase;
use ECF\User;


$pdo = new Mabase();

$users = $pdo->query("SELECT * FROM user")->fetchAll(PDO::FETCH_CLASS, User::class); // Une simple query requête SQL, avec un fetch all pour tout récupérer


?>

<?php 
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "ECF-PHP" . DIRECTORY_SEPARATOR . "header.php";
?>





<div class="container mt-3">
<h1>Administration</h1>
<h3>Gestion des utilisateurs</h3>
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                /**
                 * @var User 
                 */
                foreach($users as $user) : ?>
                    <tr>
                        <td><?= $user->getId() ?></td>
                        <td><?= $user->getName() ?></td>
                        <td><?= $user->getUsername() ?></td>
                        <td><?= $user->getEmail() ?></td>
                        <td><?= $user->getRole() ?></td>
                        <td><a href="editUser.php?id=<?= $user->getId()?>" class="btn btn-success">
                                Modifier
                            </a>
                            <a href="deleteUser.php?id=<?= $user->getId()?>" class="btn btn-danger" onclick="confirm('Voulez-vous confirmer la suppression?')">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php 




?>