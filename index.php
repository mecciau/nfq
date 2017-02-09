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


		// skaiciuojam kiek table turi rows
		if(!empty($_GET['search'])) {
			$search = $conn->real_escape_string($_GET['search']);
			$count = $conn->query("SELECT * FROM mock_data WHERE (title LIKE '% $search%') OR (title LIKE '$search%')")->num_rows;
		}
		else {
			$count = $conn->query('SELECT * FROM mock_data')->num_rows;
		}
		
		// items per page
		$perPage = 30;
		$offset = 0; 


		$nrOfPages = $count / $perPage;



		if(!empty($_GET['page'])){
		$offset = $_GET['page'];
		}

		$offset = $offset * $perPage;


		
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

			$sql = "SELECT * FROM mock_data WHERE (title LIKE '% $search%') OR (title LIKE '$search%') ORDER BY $orderby $sort LIMIT $offset, $perPage";

		} else {
			if(isset($_GET['search'])){
				echo 'Please enter a valid keyword.';
			}

			$sql = "SELECT * FROM mock_data ORDER BY $orderby $sort LIMIT $offset, $perPage";
			
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
<ul class="pagination">
	<?php


	if(empty($_GET['page'])) {
		$_GET['page'] = 1;
	}

	$previousPage = $_GET['page'] - 1; 
	if($_GET['page'] > 1) {
		if(!empty($_GET['search'])) {
			$link = "<li><a href='?page=$previousPage&&search=$search'>Previous </a><li>";
		} else {
			$link = "<li><a href='?page=$previousPage'>Previous </a><li>";
		}
		echo $link;
	}


	for($i=1; $i<$nrOfPages; $i++) {
		if(!empty($_GET['search'])) {
			$link = "<li><a href='?page=$i&&search=$search'>$i </a><li>";
		} else {
			$link = "<li><a href='?page=$i'>$i </a><li>";
		}
		echo $link;
	}
	if(empty($_GET['page'])) {
		$nextPage = 1;
	}



	$nextPage = $_GET['page'] + 1;
	if($_GET['page'] < floor($nrOfPages)) {
		if(!empty($_GET['search'])) {
			$link = "<li><a href='?page=$nextPage&&search=$search'>Next </a><li>";
		} else {
			$link = "<li><a href='?page=$nextPage'>Next </a><li>";
		}
		echo $link;		
	}


?>
</ul>
</div>
</body>
</html>