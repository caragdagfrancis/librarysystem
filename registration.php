<?php
    require_once 'connection.php';
        // $studentnumber = '';
        // $password = '';
        // $confirmPass = '';
        //studentnum = '';
        // $passwordErr = '';
        // $conPassErr = '';


        $studentnumber = $password = $confirmPass = '';
        $studentnumErr = $passwordErr = $conPassErr = '';
        $name = $nameErr = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty(trim($_POST['studentnumber']))) {
                $studentnumErr = 'Please enter your valid student number';
            } else {
                $sql = 'SELECT * FROM users WHERE studentnumber = ?';
                if ($statement = mysqli_prepare($link, $sql)) {
                    mysqli_stmt_bind_param($statement, 's', $paramstudentnum);
                    $paramstudentnum = trim($_POST["studentnumber"]);
                    //s -> string
                    //d-> double
                    //i->integer
                    //blob ->image binary object
    
                    if (mysqli_stmt_execute($statement)) {
                        mysqli_stmt_store_result($statement);
    
                        if (mysqli_stmt_num_rows($statement) == 1) {
                    $studentnumErr= "This student number is already taken";
                        } else {
                            $studentnumber =trim($_POST['studentnumber']);
                        }
                    } else {
                      echo 'Oops! Something went wrong';
                    }
                
                mysqli_stmt_close($statement);
                }
            }
                if (empty(trim($_POST['name']))) {
                    $nameErr = 'Please enter your name';
                } else {
                    $sql = 'SELECT * FROM users WHERE name = ?';
                    if ($statement = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($statement, 's', $paramname);
                        $name = trim($_POST['name']);
                        //s -> string
                        //d-> double
                        //i->integer
                        //blob ->image binary object

                        if (mysqli_stmt_execute($statement)) {
                             mysqli_stmt_store_result($statement);
        
                        //     if (mysqli_stmt_num_rows($statement) == 1) {
                        // $nameErr= 'HOY! This Name is already Available';
                        //     } else {
                        //         $nameErr = $paramname;
                        //     }
                        }
                        } else {
                          echo 'Oops! Something went wrong';
                        
                    }
                    mysqli_stmt_close($statement);
                }
    
            if (empty(trim($_POST['password']))) {
                $passwordErr = 'Please enter your password ';
            } elseif (strlen(trim($_POST['password'])) < 6) {
                $passwordErr = 'Password must have 6 characters';
            } else {
                $password = trim($_POST['password']);
            }
    
            if (empty(trim($_POST['confpassword']))) {
                $conPassErr = 'Please enter a confirm password';
            } else {
                $confirmPass = trim($_POST['confpassword']);
                if (empty($passwordErr) && ($password != $confirmPass)) {
                    $conPassErr = 'Password does not match';
                }
            }
    
            if (empty($studentnumErr) && empty($nameErr) && empty($passwordErr) && empty($conPassErr)) {
                $sql = 'INSERT INTO users (studentnumber, name, password) VALUES (?, ?, ?)';
                $statement = mysqli_prepare($link, $sql);
                if ($statement) {
                    $paramstudentnum = $studentnumber;
                    $paramname = $name;
                    $paramPassword = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($statement, 'sss', $paramstudentnum, $paramname, $paramPassword);
    
                    if (mysqli_stmt_execute($statement)) {
                        header("location: login.php");
                    } else {
                        echo 'Something went wrong. Please try again later.';
                    }
    
                    mysqli_stmt_close($statement);
                }
            }
        }
    
        mysqli_close($link);
    ?>



<!DOCTYPYE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<title> registration/Sign Up </title>
	<link rel="stylesheet" type="text/css" href="style2.css">	
</head>
<body>
	<div id="container2">

    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
    <br>
    SIGN UP PAGE 
    <br><br>
      <div class="form-group <?= !empty($studentnumErr) ? 'has-error' : ''; ?>">
        <label>Student Number: </label>
        <input type="text" name="studentnumber" class="form-control" value="<?= $studentnumber ?>">
        <span class="help-block"><?$studentnumErr?></span>
        <br><br>
      </div>

      <div class="form-group <?= !empty($nameErr) ? 'has-error' : ''; ?>">
        <label>Student Name: </label>
        <input type="text" name="name" class="form-control" value="<?= $name ?>">
        <span class="help-block"><?$nameErr ?></span>
        <br><br>
      </div>


      <div class="form-group <?= !empty($passwordErr) ? 'has-error' : ''; ?>">
        <label>Password: </label>
        <input type="password" name="password" class="form-control" value="">
        <span class="help-block"><?= $passwordErr ?></span>
        <br><br>
      </div>

      <div class="form-group <?= !empty($conPassErr) ? 'has-error' : ''; ?>">
        <label>Confirm Password: </label>
        <input type="password" name="confpassword" class="form-control" value="">
        <span class="help-block"><?= $conPassErr ?></span>
        <br><br>
      </div>

      <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Submit">
        <input type="reset" class="btn btn-default" value="Reset">
        <p>Already have an account? <a href="login.php">Login here</a> -->
      </div>
    </form>
  </div>
</body>

		<!-- <form action="login.php" method="POST">
            <br>
            SIGN UP PAGE <br>
            ADMIN <br><br>
            <p>
                <label>Student Number:</label>
                <input type="text" id="num" studentnumber="num" /> 
            </p>
            <p>
                <label>    Password: </label>
                <input type="password" id="pass" studentnumber="pass" />
            <p>
                <input type="submit" id="btn" value="Sign in" />
            </p>
            </form>
            </div>
    
</body> -->
<!-- </html>
  -->
