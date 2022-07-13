<?php
session_start();
include "db_connection.php";
include "authenticate.php";

//Get records from the detention table
 	$query = "SELECT * From odfu_user ORDER BY id";
	$result = mysqli_query($connection, $query);
	if (!$result) {
		echo "Select from table failed. ", mysqli_error($connection);
		exit();
	}
//Get first row from table
	$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#3162a5">
    <meta name="description" content="Germany's best freelance website">
    <title>OFDU - User List</title>
</head>
	<body>
		<main>
        	<h1>User List</h1>
        	<p>View and edit user's info</p>

			<!-- Detention List -->
			<div class="content-table">
				<table>
					<!-- Display the column headings -->
			    	<thead>
                		<tr>
                        	<th>ID</th>
                        	<th>Name</th>
							<th>Surname</th>
							<th>Description</th>
                            <th>Edit</th>
                		</tr>
					</thead>

					<tbody>
				   		<!-- Loop through and display the detentions (first detention retrieved above). -->
						<?php do {  ?>
					
				   			<tr>
								<td><?php echo $row['id'];?></td>
								<td><?php echo $row['name'];?></td>
								<td><?php echo $row['surname'];?></td>
								<td><?php echo $row['description'];?> </td>
								<td><div class="edit-flex"><a class="edit" href="edituser.php?id=<?php echo $row['id'];?>">Edit</a> <a class="delete" onclick="userid = <?php echo $row['id'];?>; showModal();">Delete</a></div></td>
				   			</tr>
						<?php } while ( $row = mysqli_fetch_assoc($result) ); ?>
					</tbody>
			   </table>  
			</div>

            <a href="newuser.php" class="new-user-btn">Add New User</a>

            <div id="modal" class="modal">
                <span onclick="hideModal()" class="close" title="Close Modal">&times;</span>
                <form id="modal-content" class="modal-content" onsubmit="confirmDelete()">
                    <div class="container">
                    <h1>Delete User</h1>
                    <p>Are you sure you want to delete this user?</p>

                    <div class="clearfix">
                        <button type="button" class="cancelbtn" onclick="hideModal()">Cancel</button>
                        <button type="button" class="deletebtn" onclick="window.location.href = './deleteuser.php?id=' + userid;">Delete</button>
                    </div>
                    </div>
                </form>
            </div>

		</main>
	
	<style>
        @font-face {
            font-family: "Montserrat", sans-serif;
            src: url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap");
            font-display: swap;
        }

        body {
            margin: 0;
            height: 100vh;
            font-size: 16px;
            font-family: "Montserrat", sans-serif;
            text-align: center;
            background-image: linear-gradient(
                120deg,
                #3162a5,
                #229bff
            );
            overflow: hidden;
        }

        h1, p {
            color: white;
        }

        .content-table {
            border-collapse: collapse;
            margin-left: auto;
            margin-right: auto;
            font-size: 0.9em;
            width: 50%;
            height: 70vh;
            border-radius: 10px;
            overflow-y: scroll;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            text-align: left;
            background-color: #ffffff;
        }

        table {
            width: 100%;
            border-radius: 10px 10px 0 0;
        }
        
        .content-table thead tr {
            background-color: #ff0000;
            color: #ffffff;
            text-align: left;
            font-weight: bold;
            border-radius: 5px 5px 0 0;
        }

        .content-table th {
            position: sticky;
            top: 0;
            background-color: #0F5DC7;
            padding: 10px 12px;
        }
        
        .content-table td {
            padding: 10px 12px;
        }
        
        .content-table tbody tr {
            background-color: #ffffff;
            border-bottom: 1px solid #dddddd;
        }
        
        .content-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }
        
        .content-table tbody tr:last-of-type {
            border-bottom: 2px solid #ff0000;
        }
        
        .content-table tbody tr.active-row {
            font-weight: bold;
            color: #ff0000;
        }

        a {
            cursor: pointer;
        }

        a:hover {
            text-decoration: underline;
        }

        .edit-flex {
            display: flex;
            justify-content: space-around;
        }

        .edit, .edit:visited {
            color: black;
            text-decoration: none;
        }

        .edit:hover {
            text-decoration: underline;
        }
        .new-user-btn {
            display: block;
            width: fit-content;
            background-color: white;
            padding: 6px 16px;
            border-radius: 500px;
            text-decoration: none;
            color: black;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.16);
            margin: 50px auto 0 auto;
        }

        /* Set a style for all buttons */
        button {
        background-color: #04AA6D;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
        }

        button:hover {
        opacity:1;
        }

        /* Float cancel and delete buttons and add an equal width */
        .cancelbtn, .deletebtn {
        float: left;
        width: 50%;
        }

        /* Add a color to the cancel button */
        .cancelbtn {
        background-color: #ccc;
        color: black;
        }

        /* Add a color to the delete button */
        .deletebtn {
        background-color: #f44336;
        }

        /* Add padding and center-align text to the container */
        .container {
        padding: 16px;
        text-align: center;
        }

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(71, 78, 93, 0.6);
            padding-top: 50px;
        }

        .modal h1, .modal p {
            color: black;
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
            border: 1px solid #888;
            width: 30%; /* Could be more or less, depending on screen size */
            border-radius: 10px;
        }

        /* Style the horizontal ruler */
        hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
        }

        /* The Modal Close Button (x) */
        .close {
        position: absolute;
        right: 35px;
        top: 15px;
        font-size: 40px;
        font-weight: bold;
        color: #f1f1f1;
        }

        .close:hover,
        .close:focus {
        color: #f44336;
        cursor: pointer;
        }

        /* Clear floats */
        .clearfix::after {
        content: "";
        clear: both;
        display: table;
        }

        /* Change styles for cancel button and delete button on extra small screens */
        @media screen and (max-width: 300px) {
            .cancelbtn, .deletebtn {
                width: 100%;
            }
        }
    </style>
    <script>
        // Get the modal
        var modal = document.getElementById('modal');
        var userid;

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function hideModal() {
            modal.style.display='none';
        }

        function showModal() {
            modal.style.display='block';
        }
    </script>
	</body>
</html>