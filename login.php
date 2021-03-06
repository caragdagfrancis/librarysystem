<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to process page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: process.php");
    exit;
}
 
// Include connection file
require_once "connection.php";
 
// Define variables and initialize with empty values
$studentnumber = $password = "";
$studentnumErr = $passwordErr = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if studentnumber is empty
    if(empty(trim($_POST["studentnumber"]))){
        $studentnumErr = "Please enter Student Number.";
    } else{
        $studentnumber = trim($_POST["studentnumber"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $passwordErr = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($studentnumErr) && empty($passwordErr)){
        // Prepare a select statement
        $sql = "SELECT id ,studentnumber ,password FROM users WHERE studentnumber = ?";
        
        if($statement = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($statement, "s", $paramstudentnum);
            
            // Set parameters
            $paramstudentnum = $studentnumber;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($statement)){
                // Store result
                mysqli_stmt_store_result($statement);
                
                // Check if studentnumber exists, if yes then verify password
                if(mysqli_stmt_num_rows($statement) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($statement, $id, $studentnumber, $hashed_password);
                    if(mysqli_stmt_fetch($statement)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["studentnumber"] = $studentnumber;                            
                            
                            // Redirect user to process page
                            header("location: process.php");
                        } else{
                            // Display an error message if password is not valid
                            $passwordErr = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if studentnumber doesn't exist
                    $studentnumErr = "No account found with that studentnumber.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($statement);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPYE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">   

</head>   
<body>
    <div id="container">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($studentnumErr)) ? 'has-error' : ''; ?>">
                <label>Student Number</label>
                <input type="text" name="studentnumber" class="form-control" value="<?php echo $studentnumber; ?>">
                <span class="help-block"><?php echo $studentnumErr; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($passwordErr)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $passwordErr; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="registration.php">Sign up now</a>.</p>
        </form>
    </div>    
</body>
</html>