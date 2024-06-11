<?php 

session_start();
if (isset($_GET["id"])) {
    $id = $_GET['id'];
    unset($_SESSION['perpustakaan'][$id]);
    header("Location: index.php");
    exit;
}

?>