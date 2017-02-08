<!DOCTYPE html>
<html>
<head>
	<title>NFQ Akademijos uzduotis</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">
<?php

// Database login
require_once('mysql_connection.php');

$sql = "SELECT * FROM mock_data";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo"
		<div class='table-responsive'>
				<table class='table'>
					<tr>
						<th>Book Title</th>
						<th>Author</th>
						<th>Year</th>
					</tr>
	";
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$title = $row['title'];
    	$author = $row['author'];
    	$year = $row['year'];

    	echo"
    		<tr>
	    		<td>$title</td>
	    		<td>$author</td>
	    		<td>$year</td>
    		</tr>
    	";
		


    }
    echo"
    		</table>
    	</div>
    ";


} else {
    echo "0 results, Please try again";
}
$conn->close();

?>
</div>
</body>
</html>

