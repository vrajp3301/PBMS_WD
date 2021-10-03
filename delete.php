<?php

include('DAO.php');
$id = $_GET['id'];
$delete = "DELETE FROM payment_details WHERE id = $id";
$run_data = mysqli_query($con,$delete);

if($run_data){
	header('location:index.php');
}else{
	echo "Donot Delete";
}


?>