<!DOCTYPE html>
<html>
<head>
	<title>NFQ Akademijos uzduotis</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<style>body {
		padding:25px;
	}
	</style>
</head>
<body>
<p />
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

		
		if(isset($_GET['orderby'])){
			$orderby = $_GET['orderby'];
		}else{
			$orderby = 'title';
		}


		if(isset($_GET['sort'])){
			$sort = $_GET['sort'];
		}else{
			$sort = 'ASC';
		}



		if(!empty($_GET['search'])) {


			

			$search = $conn->real_escape_string($_GET['search']);

			$sql = "SELECT * FROM mock_data WHERE (title LIKE '% $search%') OR (title LIKE '$search%') ORDER BY $orderby $sort";

		} else {
			if(isset($_GET['search'])){
				echo 'Please enter a valid keyword.';
			}

			$sql = "SELECT * FROM mock_data ORDER BY $orderby $sort";
		}


		$resultSet = $conn->query($sql);

		if($resultSet->num_rows > 0)
		{
			$sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';
?>
					<p />
					<div class='table-responsive '>
							<table class='table table-hover'>
							<thead>
								<tr>
									<th><a href='?orderby=title&&sort=<?php echo $sort; if(isset($_GET["search"])){ echo "&&search=$search";} ?>'>Book Title</a></th>
									<th><a href='?orderby=author&&sort=<?php echo $sort; if(isset($_GET["search"])){ echo "&&search=$search";} ?>'>Author</a></th>
									<th><a href='?orderby=year&&sort=<?php echo $sort; if(isset($_GET["search"])){ echo "&&search=$search";} ?>'>Year</a></th>
								</tr>
							</thead>
<?php
			
			while($row = $resultSet->fetch_assoc())
			{
				$title = $row['title'];
				$author = $row['author'];
				$year = $row['year'];
				$id = $row['id'];
?>
							<tbody>
								<tr onclick="window.document.location='book.php?id=<?php echo $id; ?>'" style="cursor:pointer;">
						    		<td><?php echo $title ?></td>
						    		<td><?php echo $author ?></td>
						    		<td><?php echo $year ?></td>
					    		</tr>
				    		</tbody>

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
