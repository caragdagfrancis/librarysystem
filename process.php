<?php

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

//require_once 'validator.php';
require_once 'account.php'; 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	
    <style type="text/css">
	
        body{ font: 14px sans-serif; text-align: left; }
		
    </style>
</head>

<body>
		<nav class = "navbar navbar- navbar-fixed-top">
			<div class = "container-fluid">
				<div class = "navbar-header">
					<p class = "navbar-text pull-right">Library System</p>
				</div>
				<ul class = "nav navbar-nav navbar-right">
				<a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
				</ul>
			</div>
		</nav>
		<div class = "container-fluid" style = "margin-top:70px;">
			<ul class = "nav nav-pills">
				
				<li class = "dropdown active">
					<a class = "dropdown-toggle" data-toggle = "dropdown" href = "#"><span class = "glyphicon glyphicon-cog"></span> Accounts <span class = "caret"></span></a>
					<ul class = "dropdown-menu">
						<li><a href = "admin.php"><span class = "glyphicon glyphicon-user"></span> Admin</a></li>
						<li><a href = "student.php"><span class = "glyphicon glyphicon-user"></span> Student</a></li>
					</ul>
				</li>
				<li><a href = "record.php"><span class = "glyphicon glyphicon-book"></span> Record</a></li>
			</ul>
			<br />
			<div class = "modal fade" id = "myModal" tabindex = "-1" role = "dialog" aria-labelledby = "myModallabel">
				<div class = "modal-dialog" role = "document">
					<div class = "modal-content panel-primary">
						<div class = "modal-header panel-heading">
							<button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close"><span aria-hidden = "true">&times;</span></button>
							<h4 class = "modal-title" id = "myModallabel">Add new Admin</h4>
						</div>
						<form method = "POST" action = "save_admin_query.php" enctype = "multipart/form-data">
							<div class  = "modal-body">
								<div class = "form-group">
									<label>Username:</label>
									<input type = "text" required = "required" name = "username" class = "form-control" />
								</div>
								<div class = "form-group">
									<label>Password:</label>
									<input type = "password" maxlength = "12" required = "required" name = "password" class = "form-control" />
								</div>
								<div class = "form-group">
									<label>Firstname:</label>
									<input type = "text" name = "firstname" required = "required" class = "form-control" />
								</div>
								<div class = "form-group">
									<label>Middlename:</label>
									<input type = "text" name = "middlename" placeholder = "(Optional)" class = "form-control" />
								</div>
								<div class = "form-group">
									<label>Lastname:</label>
									<input type = "text" name = "lastname" required = "required" class = "form-control" />
								</div>
							</div>
							<div class = "modal-footer">
								<button  class = "btn btn-primary" name = "save"><span class = "glyphicon glyphicon-save"></span> Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class = "modal fade" id = "delete" tabindex = "-1" role = "dialog" aria-labelledby = "myModallabel">
				<div class = "modal-dialog" role = "document">
					<div class = "modal-content ">
						<div class = "modal-body">
							<center><label class = "text-danger">Are you sure you want to delete this record?</label></center>
							<br />
							<center><a class = "btn btn-danger remove_id" ><span class = "glyphicon glyphicon-trash"></span> Yes</a> <button type = "button" class = "btn btn-warning" data-dismiss = "modal" aria-label = "No"><span class = "glyphicon glyphicon-remove"></span> No</button></center>
						</div>
					</div>
				</div>
			</div>
			<div class = "modal fade" id = "edit_admin" tabindex = "-1" role = "dialog" aria-labelledby = "myModallabel">
				<div class = "modal-dialog" role = "document">
					<div class = "modal-content panel-warning">
						<div class = "modal-header panel-heading">
							<button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close"><span aria-hidden = "true">&times;</span></button>
							<h4 class = "modal-title" id = "myModallabel">Edit Admin</h4>
						</div>
						<div id = "edit_query"></div>
					</div>
				</div>
			</div>
			<div class = "alert alert-info">Accounts / Admin</div>
			<div class = "">
				<button type = "button" class = "btn btn-success" data-target = "#myModal" data-toggle = "modal"><span class = "glyphicon glyphicon-plus"></span> Add new</button>
				<br />
				<br />
				<table id = "table" class = "table table-bordered">
					<thead>
						<tr class = "alert-info">
							<th>Username</th>
							<th>Password</th>
							<th>Firstname</th>
							<th>Middlename</th>
							<th>Lastname</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$q_admin = $link->query("SELECT * FROM `admin`") or die(mysqli_error());
						while($f_admin = $q_admin->fetch_array()){
					?>	
						<tr>
							<td><?php echo $f_admin['username']?></td>
							<td><?php echo md5($f_admin['password'])?></td>
							<td><?php echo $f_admin['firstname']?></td>
							<td><?php echo $f_admin['middlename']?></td>
							<td><?php echo htmlentities($f_admin['lastname'])?></td>
							<td><a class = "btn btn-danger radmin_id" name = "<?php echo $f_admin['admin_id']?>" href = "#" data-toggle = "modal" data-target = "#delete"><span class = "glyphicon glyphicon-remove"></span></a> <a class = "btn btn-warning  eadmin_id" name = "<?php echo $f_admin['admin_id']?>" href = "#" data-toggle = "modal" data-target = "#edit_admin"><span class = "glyphicon glyphicon-edit"></span></a></td>
						</tr>
					<?php
						}
					?>
					
					</tbody>
				</table>
			<br />
			<br />	
			<br />		
			</div>
		</div>
		
	</body>
</html>