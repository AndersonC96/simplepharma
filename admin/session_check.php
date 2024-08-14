<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION['sess_username']) || $_SESSION['sess_userrole'] != 'admin'){
        header('Location: ../index.php?err=2');
        exit();
    }
    if(!isset($_SESSION['sess_regenerated'])){
        session_regenerate_id(true);
        $_SESSION['sess_regenerated'] = true;
    }