<?php

include('DAO.php');

if(isset($_POST['submit'])){
	$customer_id = $_POST['customer_id'];
	$f_name = $_POST['first_name'];
	$l_name = $_POST['last_name'];
	$email = $_POST['email'];
	$phone_no = $_POST['phone_no'];
	$amount = $_POST['amount'];

	$insert_data = "INSERT INTO payment_details(customer_id,f_name, l_name,email, phone_no, amount) VALUES ('$customer_id','$f_name','$l_name','$email','$phone_no','$amount')";
	$run_data = mysqli_query($con,$insert_data);

	if($run_data){
		$added = true;
	}else{
		echo "Data not insert into database";
	}
}

?>