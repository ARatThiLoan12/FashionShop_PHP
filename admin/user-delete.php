<?php
	require_once("../model/connect.php");
	error_reporting(2);

	if (isset($_GET['idUser']))
	{
		$idUser = $_GET['idUser'];
		$sql = "DELETE FROM users WHERE id = " . $idUser;
		$result = mysqli_query($conn,$sql);
		if ($result) {
			header("location:user-list.php?us=success");
		}
		else {
			header("location:user-list.php?uf=fail");
		}
	}
?>