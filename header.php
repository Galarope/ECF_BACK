<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "session.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/annexes/style.css">
    <script src="annexes/app.js" defer></script>
  </head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Accueil</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <?php if(!isset($_SESSION['user'])) : ?>
        <a class="nav-link" href="login.php">Login</a>
        <?php else : ?>
          <a class="nav-link" href="logout.php">Logout</a>
          <?php endif ?>

          <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin') :  ?>
            <a class="nav-link" href="admin.php">Administration des posts</a>
            <a class="nav-link" href="adminUser.php">Administration des utilisateurs</a>
          <?php endif ?>  
      </div>
    </div>
  </div>
</nav>

<main class="container">

</main>
</body>
</html>