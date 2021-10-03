<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: index.php");
  exit;
}
require_once "DAO.php";
$username = $password = "";
$username_err = $password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = ($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = ($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){        

                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            header("location: index.php");
                        } else{
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($con);
}
?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
      <title>Payments and Bill  | Login </title>
   </head>
   <style type="text/css">
        body,html{
            font: 14px sans-serif;
            background: linear-gradient(to bottom, #003399 0%, #99ccff 100%);
            height:100%;
            width:100% 
        }
        .wrapper{
            width: 350px;
        }
        .card{
            border: 4px solid lightblue;
            margin:30px;
            background-color: transparent !important;
            color:white;
            border-radius: 10px;
            margin:200px auto
        }
        .navbar-brand{
            margin-left:550px;
            margin-top:20px;
        }
        .create{
            background-color:lightblue;
            color:black;
            text-align:center;
            padding:10px;
            margin-top:10px;
            margin-bottom:10px;
        }
        .create:hover{
            background-color:white;
            color:black;
            text-align:center;
            padding:10px;
            margin-top:10px;
            margin-bottom:10px;
        }
    </style>
   <body>
      <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
         <div class="navbar-header"><a class="navbar-brand" href="#" style="font-size:30px;color:lightblue;"><strong>Payments and Bill Management System</strong></a></div>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            </ul>
            <form class="form-inline my-2 my-lg-0">
               <a href="register.php"class="btn btn-success my-2 my-sm-0 create" type="submit">Create Account</a>
            </form>
         </div>
      </nav>
      <div class="container my-4">
         <div class="card" style="width: 20rem;height:18rem;">
            <br>
            <div class="card-body">
               <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                     <label>Username</label>
                     <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                     <span class="help-block"><?php echo $username_err; ?></span>
                  </div>
                  <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                     <label>Password</label>
                     <input type="password" name="password" class="form-control">
                     <span class="help-block"><?php echo $password_err; ?></span>
                  </div>
                  <button type="submit" class="btn btn-warning"><i class="fa fa-lock">&nbsp;</i> Login</button> &nbsp; &nbsp; 
                  <button type="reset" class="btn btn-danger "><i class="fa fa-repeat">&nbsp;</i> Reset</button>
               </form>
            </div>
         </div>
      </div>
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   </body>
</html>



