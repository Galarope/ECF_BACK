<?php
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "ECF-PHP" . DIRECTORY_SEPARATOR . "header.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "session.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
  header("Location: index.php");
  exit();
}

use ECF\Mabase;
use ECF\Posts;

$success = null;
$pdo = new Mabase();

if (isset($_GET['id'])) {
  $stmt = $pdo->prepare("SELECT title, body, createdAt, posts.id, user.username FROM posts INNER JOIN user ON posts.userId = user.id WHERE posts.id = :idpost");
  $stmt->execute(['idpost' => $_GET['id']]);
  $stmt->setFetchMode(PDO::FETCH_CLASS, Posts::class);
  $posts = $stmt->fetch();
} else {
  echo "marche po";
}


if (!empty($_POST)) {

  $params = [];
  $query = "UPDATE posts SET ";

  if ($_POST['title'] != $posts->getTitle()) {
    $params[] = "title = '" . $_POST['title'] . "'";
  }

  if ($_POST['body'] != $posts->getBody()) {
    $params[] = "body = '" . $_POST['body'] . "'";
  }

  $date = new DateTimeImmutable();
  $date = $date->format('c');


  $params[] = "createdAt = '" . $date . "'";

  $query .= implode(",", $params);
  $query .= " WHERE id = " . $posts->getId();

  $pdo->query($query);
  $id = $posts->getId();
  $stmt = $pdo->query("SELECT title, body, createdAt, posts.id, user.username FROM posts INNER JOIN user ON posts.userId = user.id WHERE posts.id = $id");
  $stmt->setFetchMode(PDO::FETCH_CLASS, Posts::class);
  $posts = $stmt->fetch();


  $success = "Modification effecutée avec succès.";
}
?>

<div class="container mt-3">

  <h1 class="mt-5">Éditer le post N°<?= $posts->getId() ?></h1>

  <?php if ($success) : ?>
    <div class="container mt-3">
      <div class="alert alert-success" role="alert">
        <?= $success ?>
      </div>
    </div>
  <?php endif ?>

  <label for="id" class="form-label">ID</label>
  <input class="form-control" type="text" name="id" id="id" disabled value="<?= $posts->getId() ?>">

  <form method="POST" action="#">
    <div class="mb-3">
      <label for="title" class="form-label">Titre</label>
      <input class="form-control" id="title" name="title" value="<?= $posts->getTitle() ?>">
    </div>
    <div class="mb-3">
      <label for="body" class="form-label">Contenu de l'article</label>
      <input class="form-control" id="body" name="body" value="<?= $posts->getBody() ?>">
    </div>
    <div class="mb-3">
      <label for="date" class="form-label">Date de publication</label>
      <input class="form-control" id="date" name="date" value="<?= $posts->getCreatedAt() ?>" disabled>
    </div>
    <div class="mb-3">
      <label for="username" class="form-label">Publié par :</label>
      <input class="form-control" name="username" id="username" value="<?= $posts->getUsername() ?>" disabled></input>
    </div>

    <button type="submit" class="btn btn-primary">Modifier</button>
  </form>


</div>