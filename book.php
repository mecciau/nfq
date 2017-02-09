<!DOCTYPE html>
<html>
<head>
	<title>NFQ Akademijos uzduotis</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script type="text/javascript">
		function goBack() {
	    	window.history.back();
		}
	</script>
	<style>
	body {
		padding:25px;
	}
	</style>
</head>
<body>






<div class="container">
	<form method='GET' id="searchform" action="index.php" class="form-inline">
		<div class="form-group">
			<input type='TEXT' name='search' class="form-control" value="<?php if(isset($_GET['search'])) { echo htmlentities ($_GET['search']); }?>"/>
		</div>
		<button type='SUBMIT' class="btn btn-default">Search</button>
	</form>
<?php
// Database login
	require_once('mysql_connection.php');

	
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



		if(isset($_GET['search'])) {

			

			$search = $conn->real_escape_string($_GET['search']);

			$sql = "SELECT * FROM mock_data WHERE title LIKE '$search%' ORDER BY $book $sort";

		} else {

			$id = $_GET['id'];

			$sql = "SELECT * FROM mock_data WHERE id = $id";
		}


		$resultSet = $conn->query($sql);

		if($resultSet->num_rows > 0)
		{

			
			while($row = $resultSet->fetch_assoc())
			{
				$title = $row['title'];
				$author = $row['author'];
				$year = $row['year'];
				$id = $row['id'];
				$description = $row['description'];
				$genre = $row['genre'];
?>
<h1><?php echo $title; ?> </h1>
<h4>by <?php echo $author; ?> <?php echo $year; ?> </h4>
<h5><?php echo $genre; ?> 
<p><?php echo $description; ?></p>

<a class="btn btn-default" onclick="goBack()" role="button">Go Back</a>

<?php
				


			}
		    echo "
	    			</table>
		    	</div>
		    ";
		}
		else
		{
			echo "No Results, please try different keyword.";
		}


?>
</div>
</body>
</html>
