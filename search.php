<!DOCTYPE html>
<html>
<head>
	<title>NFQ Akademijos uzduotis</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<p />
<div class="container">
	<form method='GET' id="searchform">
		<input type='TEXT' name='search'  value="<?php if(isset($_GET['search'])) { echo htmlentities ($_GET['search']); }?>"/>
		<input type='SUBMIT' name='submit' value='Search' /><p />
	</form>
<?php
// Database login
	require_once('mysql_connection.php');

	if(isset($_GET['submit'])){
		if(isset($_GET['book'])){
			$book = $_GET['book'];
		}else{
			$book = 'title';
		}

		if(isset($_GET['sort'])){
			$sort = $_GET['sort'];
		}else{
			$sort = 'ASC';
		}


		$search = $conn->real_escape_string($_GET['search']);

		$sql = "SELECT * FROM mock_data WHERE title LIKE '$search%' ORDER BY $book $sort";
		$resultSet = $conn->query($sql);

		if($resultSet->num_rows > 0)
		{
			$sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';
			echo"<p />
					<div class='table-responsive'>
							<table class='table'>
								<tr>
									<th><a href='?book=title&&sort=$sort&&search=$search&submit=Search'>Book Title</a></th>
									<th><a href='?book=author&&sort=$sort&&search=$search&submit=Search'>Author</a></th>
									<th><a href='?book=year&&sort=$sort&&search=$search&submit=Search'>Year</a></th>
								</tr>
			";
			while($row = $resultSet->fetch_assoc())
			{
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
		}
		else
		{
				echo "No Results, please try different keyword.";
		}

	}
?>
</div>
</body>
</html>
