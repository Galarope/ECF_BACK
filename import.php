<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "session.php";


use ECF\Mabase;
use ECF\Posts;
use ECF\Comments;

$success = null;
$pdo = new Mabase();

//Affichage des commentaires
$stmt = $pdo->prepare("SELECT comments.id, name, email, comments.body, comments.createdAt
FROM comments
INNER JOIN posts ON comments.postId = posts.id
WHERE posts.id = :idcomment
LIMIT 2 OFFSET  :offsetpost
");
$stmt->bindValue('idcomment', $_GET['id'], PDO::PARAM_INT);
$stmt->bindValue('offsetpost', $_GET['offsetpost'], PDO::PARAM_INT);
//$stmt->setFetchMode(PDO::FETCH_CLASS, Comments::class);
$stmt->execute();
$comments = $stmt->fetchAll();
echo json_encode($comments);