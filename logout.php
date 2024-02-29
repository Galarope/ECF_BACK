<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "session.php";

session_destroy();

header('Location: index.php');

?>