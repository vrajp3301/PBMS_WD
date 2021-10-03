<?php

session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include('DAO.php');

$added = false;

if(isset($_POST['submit'])){
	$customer_id = $_POST['customer_id'];
	$f_name = $_POST['first_name'];
	$l_name = $_POST['last_name'];
	$email = $_POST['email'];
	$phone_no = $_POST['phone_no'];
	$amount = $_POST['amount'];

  	$insert_data = "INSERT INTO payment_details(customer_id,f_name,l_name,email,phone_no,amount) VALUES ('$customer_id','$f_name','$l_name','$email','$phone_no','$amount')";
  	$run_data = mysqli_query($con,$insert_data);

  	if($run_data){
		  $added = true;
  	}else{
  		echo "Data not insert";
  	}

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Payment Details</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="container">
<?php
	if($added){
		echo "
			<div class='btn-success' style='padding: 15px; text-align:center;'>
				Your Student Data has been Successfully Added.
			</div><br>
		";
	}

?>
	<a href="logout.php" class="btn btn-success"><i class="fa fa-lock"></i> Logout</a>
	<button class="btn btn-success" type="button" data-toggle="modal" data-target="#myModal">
  <i class="fa fa-plus"></i> Add New Student
  </button>
  <hr>
		<table class="table table-bordered table-striped table-hover" id="myTable">
		<thead>
			<tr>
			   <th class="text-center" scope="col">S.L</th>
				<th class="text-center" scope="col">Name</th>
				<th class="text-center" scope="col">Customer Id</th>
				<th class="text-center" scope="col">Phone</th>
				<th class="text-center" scope="col">Amount</th>
				<th class="text-center" scope="col">View</th>
				<th class="text-center" scope="col">Edit</th>
				<th class="text-center" scope="col">Completed</th>
				<th class="text-center" scope="col">Delete</th>
			</tr>
		</thead>
			<?php

        	$get_data = "SELECT * FROM payment_details order by 1 desc";
        	$run_data = mysqli_query($con,$get_data);
			$i = 0;
        	while($row = mysqli_fetch_array($run_data))
        	{
				$sl = ++$i;
				$id = $row['id'];
				$customer_id = $row['customer_id'];
				$name = $row['f_name'];
				$name2 = $row['l_name'];
				$email = $row['email'];
				$phone = $row['phone_no'];
				$amount = $row['amount'];

        		echo "

				<tr>
				<td class='text-center'>$sl</td>
				<td class='text-left'>$name   $name2</td>
				<td class='text-left'>$customer_id</td>
				<td class='text-left'>$phone</td>
				<td class='text-center'>$amount</td>
			
				<td class='text-center'>
					<span>
					<a href='#' class='btn btn-info mr-3 profile' data-toggle='modal' data-target='#view$id' title='Profile'><i class='fa fa-address-card-o' aria-hidden='true'></i></a>
					</span>
					
				</td>
				<td class='text-center'>
					<span>
					<a href='#$id' class='btn btn-warning mr-3 edituser' data-toggle='modal' data-target='#ed$id' title='Edit'><i class='fa fa-pencil-square-o fa-lg'></i></a>
					</span>
					
				</td>
				<td class='text-center'>
					<span>
					<a href='#$id' class='btn btn-success mr-3 edituser' data-toggle='modal' data-target='#completed$id' title='Edit'><i class='fa fa-check fa-lg'></i></a>
					</span>
					
				</td>
				<td class='text-center'>
					<span>
					
						<a href='#' class='btn btn-danger deleteuser' title='Delete'>
						     <i class='fa fa-trash-o fa-lg' data-toggle='modal' data-target='#$id' style='' aria-hidden='true'></i>
						</a>
					</span>
				</td>
			</tr>";
        	}
        	?>	
		</table>
	</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Add New Payment Detail</h4>
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data">
<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail4">Customer ID</label>
<input type="text" class="form-control" name="customer_id" placeholder="Enter Customer ID" maxlength="12" required>
</div>
<div class="form-group col-md-6">
<label for="inputPassword4">Mobile No.</label>
<input type="phone" class="form-control" name="phone_no" placeholder="Enter 10-digit Mobile no." maxlength="10" required>
</div>
</div>


<div class="form-row">
<div class="form-group col-md-6">
<label for="firstname">First Name</label>
<input type="text" class="form-control" name="first_name" placeholder="Enter First Name">
</div>
<div class="form-group col-md-6">
<label for="lastname">Last Name</label>
<input type="text" class="form-control" name="last_name" placeholder="Enter Last Name">
</div>
</div>

<div class="form-group col-md-6">
<label for="inputAddress">Amount</label>
<input type="text" class="form-control" name="amount" maxlength="12" placeholder="Enter Amount to be paid">
</div>
<div class='form-group col-md-6'>
<label for='email'>Email Id</label>
<input type='email' class='form-control' name='email' placeholder="Enter Email id" value='Enter your email'>
</div>     	
<input type="submit" name="submit" class="btn btn-info btn-large" value="Submit">
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>

  </div>
</div>


<!------DELETE---->

<?php

$get_data = "SELECT * FROM payment_details";
$run_data = mysqli_query($con,$get_data);

while($row = mysqli_fetch_array($run_data))
{
	$id = $row['id'];
	echo "

<div id='$id' class='modal fade' role='dialog'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title text-center'>Are you sure you want to delete ?</h4>
      </div>
      <div class='modal-body'>
        <a href='delete.php?id=$id' class='btn btn-danger' style='margin-left:250px'>Delete</a>
      </div>
      
    </div>

  </div>
</div>";

	
}
?>
<!-- VIEW -->
<?php 

$get_data = "SELECT * FROM payment_details";
$run_data = mysqli_query($con,$get_data);

while($row = mysqli_fetch_array($run_data))
{
	$id = $row['id'];
	$customer_id = $row['customer_id'];
	$name = $row['f_name'];
	$name2 = $row['l_name'];
	$email = $row['email'];
	$phone = $row['phone_no'];
	$amount = $row['amount'];
	echo "

		<div class='modal fade' id='view$id' tabindex='-1' role='dialog' aria-labelledby='userViewModalLabel' aria-hidden='true'>
		<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h5 class='modal-title' id='exampleModalLabel'>Profile <i class='fa fa-user-circle-o' aria-hidden='true'></i></h5>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</div>
			<div class='modal-body'>
			<div class='container' id='profile'> 
				<div class='row'>
					<div class='col-sm-4 col-md-2'>
						<i class='fa fa-id-card' aria-hidden='true'></i> $customer_id<br>
						<i class='fa fa-phone' aria-hidden='true'></i> $phone <br>
					</div>
					<div class='col-sm-3 col-md-6'>
						<h3 class='text-primary'>$name $name2</h3>
						<p class='text-secondary'>
						<br />
						<i class='fa fa-money fa-lg text-primary' aria-hidden='true'>$amount</i>
						<br />
					</div>
				</div>

			</div>   
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
			</div>
			</form>
			</div>
		</div>
		</div> 


    ";
}
?>

<!-- EDIT -->
<?php

$get_data = "SELECT * FROM payment_details";
$run_data = mysqli_query($con,$get_data);

while($row = mysqli_fetch_array($run_data))
{
	$id = $row['id'];
	$customer_id = $row['customer_id'];
	$name = $row['f_name'];
	$name2 = $row['l_name'];
	$email = $row['email'];
	$phone = $row['phone_no'];
	$amount = $row['amount'];
	echo "

<div id='ed$id' class='modal fade' role='dialog'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
             <button type='button' class='close' data-dismiss='modal'>&times;</button>
             <h4 class='modal-title text-center'>Edit your Data</h4> 
      </div>

      <div class='modal-body'>
        <form action='edit.php?id=$id' method='post' enctype='multipart/form-data'>

		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='inputEmail4'>Student Id.</label>
		<input type='text' class='form-control' name='customer_id' placeholder='Enter Customer ID' maxlength='12' value='$customer_id' required>
		</div>
		<div class='form-group col-md-6'>
		<label for='inputPassword4'>Mobile No.</label>
		<input type='phone' class='form-control' name='phone_no' placeholder='Enter Mobile no.' maxlength='10' value='$phone' required>
		</div>
		</div>
		
		
		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='firstname'>First Name</label>
		<input type='text' class='form-control' name='first_name' placeholder='Enter First Name' value='$name'>
		</div>
		<div class='form-group col-md-6'>
		<label for='lastname'>Last Name</label>
		<input type='text' class='form-control' name='last_name' placeholder='Enter Last Name' value='$name2'>
		</div>
		</div>
		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='email'>Email Id</label>
		<input type='email' class='form-control' name='email' placeholder='Enter Email id' value='$email'>
		</div>
		<div class='form-group col-md-6'>
		<label for='inputAddress'>Amount</label>
		<input type='text' class='form-control' name='amount' maxlength='12' placeholder='Enter Amount' value='$amount'>
		</div
			 <div class='modal-footer'>
			 <input type='submit' name='submit' class='btn btn-info btn-large' value='Submit'>
			 <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
		 </div>
        </form>
      </div>

    </div>

  </div>
</div>";

}
?>
<!-- COMPLETED -->
<?php

$get_data = "SELECT * FROM payment_details";
$run_data = mysqli_query($con,$get_data);

while($row = mysqli_fetch_array($run_data))
{
	$id = $row['id'];
	echo "

<div id='completed$id' class='modal fade' role='dialog'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title text-center'>You have completed your payment !</h4>
      </div>
      <div class='modal-body'>
        <a href='delete.php?id=$id' class='btn btn-success' style='margin-left:250px'>Done</a>
      </div>
      
    </div>

  </div>
</div>";
}


?>

<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>

</body>
</html>