<?php
	require 'conexao.php';
	session_start();
	$username = "";
	$password = "";
	if(isset($_POST['username'])){
		$username = $_POST['username'];
	}
	if (isset($_POST['password'])) {
		$password = $_POST['password'];
		}
	$q = 'SELECT * FROM usuarios WHERE username=:username AND password=:password';
	$query = $dbh->prepare($q);
	$query->execute(array(':username' => $username, ':password' => $password));
	if($query->rowCount() == 0){
		header('Location: index.php?err=1');
	}else{
		$row = $query->fetch(PDO::FETCH_ASSOC);
		session_regenerate_id();
		$_SESSION['sess_user_id'] = $row['id'];
		$_SESSION['sess_username'] = $row['username'];
		$_SESSION['sess_userrole'] = $row['role'];
		$_SESSION['sess_usersisname']=$row['nome'];
		echo $_SESSION['sess_userrole'];
		session_write_close();
		switch($_SESSION['sess_userrole']){
			case "admin":
			header('Location: admin/adminHome.php');
			break;
			case "tecnico":
			header('Location: tecnico/tecnicoHome.php');
			break;
			case "subadim":
			header('Location: subAdmin/subadminHome.php');
			break;
		}
	}
	$dbh = null;
?>