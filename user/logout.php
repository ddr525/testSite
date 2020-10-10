<?php
    require "../libs/db_rb.php";
    $_SESSION = [];
    header("Location: ".$_SERVER['HTTP_REFERER']);
?>