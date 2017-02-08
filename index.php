<?php

// Database login
require_once('mysql_connection.php');

$sql = "SELECT * FROM books";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$title = $row['name'];
    	$author = $row['author'];
    	$year = $row['year'];

        echo "Book Title: $title, Author: $author, Year: $year !!!";
    }
} else {
    echo "0 results, Please try again";
}
$conn->close();

?>