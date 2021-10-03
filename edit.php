<?php
include('DAO.php');

$id = $_GET['id'];

if(isset($_POST['submit']))
{
	$customer_id = $_POST['customer_id'];
	$f_name = $_POST['first_name'];
	$l_name = $_POST['last_name'];
	$email = $_POST['email'];
	$phone_no = $_POST['phone_no'];
	$amount = $_POST['amount'];

	$update = "UPDATE payment_details SET customer_id='$customer_id', f_name = '$f_name', l_name = '$l_name', email = '$email', phone_no = '$phone_no', amount = '$amount'WHERE id=$id ";
	$run_update = mysqli_query($con,$update);

	if($run_update){
		header('location:index.php');
	}else{
		echo "Data not update";
	}
}

?>