<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "session.php";

use ECF\Mabase;
use ECF\Posts;

try {
    $pdo = new Mabase();
    
    $limit = 12;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // intval convertit la valeur en nombre entier
    $offset = ($page - 1) * $limit;

    $stmtTotal = $pdo->query("SELECT COUNT(*) as total FROM posts");
    $totalPosts = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    
    $totalPages = ceil($totalPosts / $limit); // ceil Arrondit au nombre supérieur

    $stmt = $pdo->prepare("SELECT title, body, createdAt, posts.id, user.username FROM posts INNER JOIN user ON posts.userId = user.id LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_CLASS, Posts::class); 
} catch (PDOException $e) {
    echo "Erreur PDO : " . $e->getMessage();
    exit();
}
?>

<?php
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "ECF-PHP" . DIRECTORY_SEPARATOR . "header.php";
?>

<div class="container mt-3 mb-2">
  <div class="row">
    <?php foreach($posts as $post) : ?>
      <div class="card mt-4 col-6 ms-auto" style="width: 18rem;">
        <img src="annexes/photoholder.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title"><?= $post->getTitle()?></h5>
          <p class="card-text"><?php
          $charMax = 20;
          $chaine = $post->getBody();
          if(strlen($post->getBody()) >= $charMax){
              $chaine = substr($chaine, 0, 40) . "...";
              echo $chaine;
          } ?></p>
          <p class="card-text"><?= $post->getCreatedat()?></p>
          <p class="card-text"><?= $post->getUsername()?></p>
          <a href="article.php?id=<?= $post->getId()?>" class="btn btn-primary">Voir l'article complet</a>
        </div>
      </div>
    <?php endforeach ?>
  </div>
  
  <div class="mt-4 mb-5 container justify-content-center text-center">
    <?php if($page > 1): ?>
      <a href="?page=<?= $page - 1 ?>" class="btn btn-secondary">Page précédente</a>
    <?php endif; ?>
    <?php if($page < $totalPages): ?>
      <a href="?page=<?= $page + 1 ?>" class="btn btn-success">Page suivante</a>
    <?php endif; ?>
  </div>
</div>
