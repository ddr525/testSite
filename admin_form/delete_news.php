<?php 
include "../includes/config.php"; 
include "../libs/db_rb.php";
// echo $_SESSION['id'];
// mysqli_query($connection, "DELETE FROM `comments` WHERE `comments`.`article_id` = " . $_SESSION['id']);
// mysqli_query($connection, "DELETE FROM `articles` WHERE `articles`.`id` = " .$_SESSION['id']);

R::exec("DELETE FROM `comments` WHERE `comments`.`idarticle` = :id", array(
    ':id' => $_SESSION['id']
));

R::exec("DELETE FROM `articles` WHERE `articles`.`id` = :id", array(
    ':id' => $_SESSION['id']
));

?>

<script>
    // document.location.href="/";
</script>