<?php
require_once __DIR__ . '/../config/bootstrap.php';
use App\Auth;

Auth::logout();
header('Location: index.php');
exit();