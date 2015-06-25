<html>
<head>
<title>User Management Problem</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	
</head>

<body>

	<div class="container">
	
		<!--jumbotron for page title-->
		<div class="jumbotron">
			<h1>User Management Problem</h1>
			<br>
			<h3>By: Chaozhi Zhang</h3>
		</div>
		
		<hr class="featurette-divider">
		
		<?php
		//include database connection
		include 'db.php';
		
		//check if there's a Add User post
		if(isset($_POST['AddUsername'])){

			//add new record into the database
			$sql = "INSERT INTO  `user management system`.`users` (
			`id` ,`username` ,`password` ,`isactive` ,`modified`
			)
			VALUES (
			NULL ,  
			'" . $mysqli->real_escape_string($_POST['AddUsername']) . "',  
			'" . $mysqli->real_escape_string($_POST['AddPassword']) . "',  
			'" . $mysqli->real_escape_string($_POST['AddIsactive']) . "', 
			CURRENT_TIMESTAMP
			);";
			//execute the query
			$mysqli->query($sql);
		}

		//check if there's a Update User post
		if(isset($_POST['UpdateUsername'])){

			//update new record into the database
			$sql = "UPDATE users SET			  
			isactive = '" . $mysqli->real_escape_string($_POST['UpdateIsactive']) . "',
			username = '" . $mysqli->real_escape_string($_POST['UpdateUsername']) . "',
			password  = '" . $mysqli->real_escape_string($_POST['UpdatePassword']) . "'
			WHERE id='" . $mysqli->real_escape_string($_POST['id']) . "'";
			//execute the query	
			$mysqli->query($sql);
		}

		//query 10 records from the database         
		$query = " SELECT * FROM users LIMIT 0,10";

		//execute the query and get the result
		$result = $mysqli->query($query);

		//get the number of rows returned
		$num_results = $result->num_rows;
		
		if ($num_results > 0) { //if there is already a database record
			
			$data = array($num_results);
			$row_counter = 0;
			
			echo "
			<div class='panel panel-primary'>
			<div class='panel-heading'><h4>User Management System</h4></div>
			<div class='panel-body'>
			
			<!--table for the records-->
			<table class='table table-striped table-condensed'>
			<thead>
				<tr>
					<th>ID</th>
					<th>Username</th>
					<th>Status</th>
					<th>Password</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>";
			
			//loop to show each record			
			while ($row = $result->fetch_assoc()) {
				
				//extract row         
				//this will make $row['username'] to         
				//just $username only
				
				extract($row);
				
				$data[$row_counter++] = array($id, $username, $isactive, $password);
				
				//create new table row per record         
				echo "
				<tr>
					<td>{$id}</td>
					<td>{$username}</td>
				";
				if ($isactive) {
					echo "
					<td>Active</td>
					";
				} else {
					echo "
					<td>Not Active</td>
					";
				};
				echo "
					<td>{$password}</td>
					<td>
						<!--call update_user function on click-->         
						<a href='#' onclick='update_user( {$id} );'>
							<button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal'>Update</button>
						</a>
						<!--call delete_user function on click-->      
						<a href='#' onclick='delete_user( {$id} );'>
							<button type='button' class='btn btn-danger btn-sm'>Delete</button>
						</a>
					</td>
				</tr>";
			}
			echo "
				<tr>
				<!--use a form for last row to add new record-->
					<form role='form' id='AddUser' action='index.php' onsubmit='return validateForm(\"AddUser\")' method='post'>
						<td>
						<td><input type='text' name='AddUsername' style=\"width: 60%;\"/></td>
						<td><select name='AddIsactive' style=\"width: 80%;\">
							<option value='1'>Active</option>
							<option value='0'>Not Active</option></select></td>
						<td><input type='text' name='AddPassword' style=\"width: 60%;\"/></td>
						<td><input type='submit' class='btn btn-success btn-sm' value='Create User' style=\"width: 100%;\"></td>
					</form>
				
				</tr>
			</tbody>
			</table>
			</div>
			</div>";
		} else {
			
			//if database table is empty         
			echo "No records found.";
		}

		//disconnect from database

		$result->free();
		$mysqli->close();
		?>
		
		<hr class="featurette-divider">
		
		<!-- Footer for copyright-->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; <a href="mailto:zhangcz217@gmail.com">Chaozhi217</a> 2015</p>
                </div>
            </div>
        </footer>	
		
	</div>
	
	<!-- external script for delete_user() update_user() validateForm()-->
	<script type="text/javascript">var php_data = <?php echo json_encode($data); ?>;</script>
	<script type="text/javascript" src="ums.js"></script>
    
	
    <!-- Modal for updating record-->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Update User</h4>
				</div>
				<div class="modal-body">
			  
					<form role="form" id='UpdateUser' action='index.php' onsubmit='return validateForm("UpdateUser")' method='post'>
						<div class="form-group">
							<label for="UpdateUsername">User Name:</label>
							<input type="text" class="form-control" name="UpdateUsername" id="UpdateUsername"/>
						</div>
						<div class="form-group">
							<label for="UpdateIsactive">Status:</label>
							<select class="form-control" name="UpdateIsactive" id="UpdateIsactive">
								<option value="0" >Not Active</option>
								<option value="1" >Active</option>
							</select>
						</div>
						<div class="form-group">
							<label for="UpdatePassword">Password:</label>
							<input type="password" class="form-control" name="UpdatePassword" id="UpdatePassword"/>
							<input type="hidden" class="form-control" name="id" id="UpdateId" />
						</div>
						<button type="submit" class="btn btn-info">Update</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
			
					</form>
				
				</div>
			
			</div>
		  
		</div>
	</div>
</body>
</html>
