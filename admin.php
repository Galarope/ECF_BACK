<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "session.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
  header("Location: index.php");
  exit();
}

use ECF\Mabase;
use ECF\Posts;


try {
  $pdo = new Mabase();
  $stmt = $pdo->prepare("SELECT title, body, createdAt, posts.id, user.username FROM posts INNER JOIN user ON posts.userId = user.id ORDER BY posts.id");
  $stmt->execute();
  $posts = $stmt->fetchAll(PDO::FETCH_CLASS, Posts::class);
} catch (PDOException $e) {
  echo "Erreur PDO : " . $e->getMessage();
  exit();
}


if (isset($_POST['delete_id'])) {
  try {
    $deleteStmt = $pdo->prepare("DELETE FROM posts WHERE id = :post_id");
    $deleteStmt->execute(['post_id' => $_POST['delete_id']]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  } catch (PDOException $e) {
    echo "Erreur PDO lors de la suppression du post : " . $e->getMessage();
    exit();
  }
}
?>

<?php
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "ECF-PHP" . DIRECTORY_SEPARATOR . "header.php";
?>


<div class="container mt-4">
  <a href="addPost.php" class="btn btn-warning">Ajouter un post</a>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">ID post</th>
        <th scope="col">Title</th>
        <th scope="col">Body</th>
        <th scope="col">Date</th>
        <th scope="col">Username</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($posts as $post) : ?>
        <tr>
          <th scope="row"><?= $post->getId() ?></th>
          <td><?= $post->getTitle() ?></td>
          <td><?= $post->getBody() ?></td>
          <td><?= $post->getCreatedAt() ?></td>

          <td><?= $post->getUsername() ?></td>
          <td>
            <a href="edit.php?id=<?= $post->getId() ?>" class="btn btn-success">Modifier</a>
            <form method="POST" action="">
              <input type="hidden" name="delete_id" value="<?= $post->getId() ?>">
              <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>

  </table>
</div>