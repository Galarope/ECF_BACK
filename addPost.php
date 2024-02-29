<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "session.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
  header("Location: index.php");
  exit();
}

use ECF\Mabase;
use ECF\User;

$pdo = new Mabase();
$success = null;

$users = $pdo->query("SELECT * FROM user")->fetchAll(PDO::FETCH_CLASS, User::class);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['title']) && isset($_POST['body'])) {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $userid = $_POST['userid'];

    try {
      $date = new DateTimeImmutable();
      $date = $date->format('c');

      $stmt = $pdo->prepare("INSERT INTO posts (title, body, userId, createdAt) VALUES (:title, :body, :userId, :date)");

      $stmt->bindValue('title', $title);
      $stmt->bindValue('body', $body);
      $stmt->bindValue('userId', $userid); 
      $stmt->bindValue('date', $date);

      $stmt->execute();

      $success = "Post ajouté avec succès.";

      
    } catch (PDOException $e) {
      echo "Erreur PDO lors de l'ajout du post : " . $e->getMessage();
      exit();
    }
  } else {
    echo "Des informations sont manquantes";
    exit();
  }
}

?>

<?php
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "ECF-PHP" . DIRECTORY_SEPARATOR . "header.php";
?>

<div class="container mt-4">
  <h2>Ajouter un post</h2>
  <?php if ($success) : ?>
    <div class="container mt-3">
      <div class="alert alert-success" role="alert">
        <?= $success ?>
      </div>
    </div>
  <?php endif ?>
  <form method="POST" action="">
    <div class="mb-3">
      <label for="title" class="form-label">Titre</label>
      <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
      <label for="body" class="form-label">Post</label>
      <textarea class="form-control" id="body" name="body" rows="5" required></textarea>
    </div>
    <div class="mb-3">
      <label for="userid" class="form-label">Post</label>
      <select class="form-control" id="userid" name="userid" rows="5" required>
      <?php foreach ($users as $user) : ?>
        <option value="<?= $user->getId()?>"><?= $user->getUsername()?></option>
      <?php endforeach ?>
      </select>
      
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
  </form>
</div>


