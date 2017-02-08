<!DOCTYPE html>
<html>
<head>
	<title>NFQ Akademijos uzduotis</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">
<?php
$output = NULL;

// Database login
require_once('mysql_connection.php');

if(isset($_POST['submit'])){

	$search = $conn->real_escape_string($_POST['search']);

	$sql = "SELECT * FROM mock_data WHERE title LIKE '$search%'";
	$resultSet = $conn->query($sql);

	if($resultSet->num_rows > 0)
	{
		while($row = $resultSet->fetch_assoc())
		{
			$title = $row['title'];
			$author = $row['author'];
			$output .= "Title: $title<br /> Author: $author <br> <br>";


		}
	}
	else
	{
			$output = "No Results";
	}

}
?>
<form method='POST'>
		<input type='TEXT' name='search' />
		<input type='SUBMIT' name='submit' value='Search' /><p />

<?php 
	echo $output;
?>
</div>
</body>
</html>
