<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "session.php";

use ECF\User;
use ECF\Mabase;

$error = "";
$success = "";


if (!empty($_POST)) { 

    try {
        $pdo = new Mabase(); 
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :login"); 
        $stmt->bindParam('login', $_POST['login'], PDO::PARAM_STR); 
        $stmt->execute(); 
        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class); 
        $user = $stmt->fetch(); 


        /**
         * @var User
         */

        if ($user) { // Si on a un user
            if ($user->verifMDP($_POST['password'])) { 
                $success = "Vous êtes maintenant connecté.";
                $_SESSION['user'] = true; 
                $_SESSION['role'] = $user->getRole();    
                 header("Location: index.php" );
                 exit();
            } else {
                $error = "Le mot de passe est incorrect.";
            }
        } else {
            $error = "Le login est incorrect.";
        }
    } catch (\PDOException $e) {
        echo $e->getMessage(); 
    }
}


include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "ECF-PHP" . DIRECTORY_SEPARATOR . "header.php"; 


?>

<?php if(isset($_SESSION['user'])) : ?> 
    <div class="container mt-3">
        <div class="alert alert-danger" role="alert">
            Vous êtes déjà connecté à votre session
        </div>
    </div>

<?php else : ?>   

<?php if ($error) : ?>
    <div class="container mt-3">
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    </div>

<?php endif ?>

<?php if ($success) : ?>
    <div class="container mt-3">
        <div class="alert alert-success" role="alert">
            <?= $success ?>
        </div>
    </div>

<?php else : ?> 

<div class="row mt-3">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <form method="POST" action="#">
            <h1>Se connecter</h1>
            <div class="mb-3">
                <label for="inputLogin" class="form-label">Login</label>
                <input name="login" type="text" class="form-control" id="inputLogin" placeholder="Login" required>
            </div>
            <div class="mb-3">
                <label for="inputPassword" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="InputPassword" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
    <div class="col-md-3"></div>
</div>
<?php endif ?>
<?php endif ?>