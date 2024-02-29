<?php
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "ECF-PHP" . DIRECTORY_SEPARATOR . "header.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "session.php";


use ECF\Mabase;
use ECF\Posts;
use ECF\Comments;

$success = null;
$pdo = new Mabase();

// Affichage du post
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT title, body, createdAt, posts.id, user.username FROM posts INNER JOIN user ON posts.userId = user.id WHERE posts.id = :idpost ");
    $stmt->execute(['idpost' => $_GET['id']]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, Posts::class);
    $posts = $stmt->fetch();
} else {
    echo "marche po";
}

//Affichage des commentaires
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT comments.id, name, email, comments.body, comments.createdAt FROM comments INNER JOIN posts ON comments.postId = posts.id WHERE posts.id = :idcomment LIMIT 2");
    $stmt->execute(['idcomment' => $_GET['id']]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, Comments::class);
    $comments = $stmt->fetchAll();
} else {
    echo "marche po";
}
?>


<div class="container mt-3">

    <h1>Article numéro : <?= $posts->getId() ?></h1>

    <div class="card text-bg-dark  mb-3">
        <img src="annexes/photoholder.jpg" class="card-img" alt="...">
        <div class="card-img-overlay">
            <h3 class="card-title text-dark"><?= $posts->getTitle() ?></h3>
            <p class="card-text text-dark"><?= $posts->getBody() ?></p>
            <p class="card-text text-dark"> Créé par : <?= $posts->getUsername() ?> le <?= $posts->getCreatedAt() ?></p>
        </div>
    </div>

    <div class="container">

        <h2>Commentaires : </h2>
        <?php foreach ($comments as $comment) : ?>
            <div class="bg-secondary mt-3 mb-3" id="comm">

                <ul class="list-group">
                    <li class="list-group-item"><strong>Auteur :</strong> <?= $comment->getEmail() ?></li>
                    <li class="list-group-item"><strong>Sujet :</strong> <?= $comment->getName() ?></li>
                    <li class="list-group-item"><strong>Contenu :</strong> <?= $comment->getBody() ?></li>
                    <li class="list-group-item"><strong>Envoyé le : </strong> <?= $comment->getCreatedAt() ?></li>
                </ul>
            </div>
        <?php endforeach ?>

        <button class="btn btn-success mb-3 mt-2" id="voirPlus" name="voirplus">Voir plus</button>


    </div>



</div>