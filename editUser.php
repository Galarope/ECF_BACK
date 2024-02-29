<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

use ECF\Mabase;
use ECF\User;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "ECF-PHP" . DIRECTORY_SEPARATOR . "header.php";

$pdo = new Mabase();
$success = null;

if (isset($_GET['id'])) {

    $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id"); 
    $stmt->execute(['id' => $_GET['id']]); 
    $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);

    /**
     * @var User
     */

    $user = $stmt->fetch();
}else{
    header('Location: adminUser.php'); 
}



if(!empty($_POST)){
    $query = "UPDATE user SET ";

    $params = []; 

    if($_POST['name'] != $user->getName()){ 
        $params[] = "name = '" . $_POST['name'] . "'"; 
    }

    if($_POST['username'] != $user->getUsername()){ 
        $params[] = "username = '" . $_POST['username'] . "'"; 
    }

    

    if($_POST['role'] != $user->getRole()){ 
        $params[] = "role = '" . $_POST['role']. "'";
    }

    $query .= implode(",", $params); 
    $query .= " WHERE id = " . $user->getId();

    $pdo->query($query);
    $id = $user->getId();
    $stmt = $pdo->query("SELECT * FROM user WHERE id = $id");
    $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
    $user = $stmt->fetch();

    $success = "Modification effecutée avec succès.";

}


?>

<div class="container">
    <h1 class="mt-5">Éditer l'utilisateur N°<?= $user->getId() ?></h1>

    <?php if ($success) : ?>
    <div class="container mt-3">
        <div class="alert alert-success" role="alert">
            <?= $success ?>
        </div>
    </div>
    <?php endif ?>

    <form class="row g-3 mt-3" method="POST" action="#">
        <div class="col-md-4">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= $user->getName() ?>" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text">@</span>
                <input type="text" class="form-control" name="username" value="<?= $user->getUsername() ?>" required>
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label">Email</label>
            <input type="text" name="email" class="form-control" value="<?= $user->getEmail() ?>" disabled>
        </div>
        <div class="col-md-3">
            <label class="form-label">Rôle</label>
            <select class="form-select" name="role" required>
                <option <?= ($user->getRole() === "user") ? 'selected' : '' ?> value="user">User</option>
                <option <?= ($user->getRole() === "admin") ? 'selected' : '' ?> value="admin">Admin</option>
            </select>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Valider</button>
        </div>
    </form>
</div>