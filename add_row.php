<?php // connect.php allows connection to the database

  require 'connect.php'; //using require will include the connect.php file each time it is called.

    if (isset($_POST['id'])   &&
        isset($_POST['title']) &&
        isset($_POST['author']) &&
        isset($_POST['genre']) &&
        isset($_POST['year']) &&
        isset($_POST['ISBN'])
		)
		
      
  {
	$validation_errors = array();
	  
    $id     = assign_data($conn, 'id');
    $title  = assign_data($conn, 'title');
    $author = assign_data($conn, 'author');
    $genre  = assign_data($conn, 'genre');
    $year   = assign_data($conn, 'year');
    $ISBN   = assign_data($conn, 'ISBN');
    
    $query  = "SELECT * FROM books WHERE id = $id";
	$result = $conn->query($query);
	$rows = $result->num_rows;
		
    $validation_passed = Validate($validation_errors, $rows);
    if ($validation_passed) {
    
	$query    = "INSERT INTO books VALUES ('$id', '$title', '$author', '$genre', '$year', '$ISBN')";
	
    $result   = $conn->query($query);
    if (!$result) echo "<br><br>INSERT failed: $query<br>" .
	
      $conn->error . "<br><br>";
    }
    else {
		for ($i = 0; $i < count($validation_errors); ++$i) {
			echo $validation_errors[$i];
			echo "<br>";
		}
	}
  }


   echo <<<_END
  <form action="  " method="post">
    <br><br>
    Book ID <input type="text" name="id"> <br><br>
    Book Title <input type="text" name="title"> <br><br>
    Author Name <input type="text" name="author"> <br><br>
    Book Genre <input type="text" name="genre"> <br><br>
    Year Published <input type="text" name="year"> <br><br>
    ISBN <input type="text" name="ISBN"> <br><br>
      
    <input type="submit" value="ADD RECORD">
	
   </form>
_END;
  
  
  
  function assign_data($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
  
  $query  = "SELECT * FROM books";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;

   echo <<<_END
  <pre> 
    <b>Here is your Books list</b>
  </pre>
_END;

    $rows = $result->num_rows;
	
	for ($i = 0 ; $i < $rows ; ++$i)
  {
    $result->data_seek($i);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    echo 'Book ID: '   . $row['id']   . '<br>';
    echo 'Title: '    . $row['title']    . '<br>';
    echo 'Author: ' . $row['author'] . '<br>';
    echo 'Genre: ' . $row['genre'] . '<br>';
    echo 'Year Published: ' . $row['year'] . '<br>';
    echo 'ISBN: ' . $row['ISBN'] . '<br><br><br>';
  }

	function Validate(&$validation_errors, $rows)
	{
		if ($rows > 0) {
			$error = "ID not unique!";
			$validation_errors[count($validation_errors)] = $error;
		}	
		if (empty($_POST['id'])) {
			$error = "No ID submitted!";
			$validation_errors[count($validation_errors)] = $error;
		}
		if (empty($_POST['author'])) {
			$error = "No author submitted!";
			$validation_errors[count($validation_errors)] = $error;
		}
		if (empty($_POST['title'])) {
			$error = "No title submitted!";
			$validation_errors[count($validation_errors)] = $error;
		}
		if (empty($_POST['genre'])) {
			$error = "No genre submitted!";
			$validation_errors[count($validation_errors)] = $error;
		}
		if (empty($_POST['year'])) {
			$error = "No year submitted!";
			$validation_errors[count($validation_errors)] = $error;
		}
		if (empty($_POST['ISBN'])) {
			$error = "No ISBN submitted!";
			$validation_errors[count($validation_errors)] = $error;
		}
		
		if (strlen($_POST['author']) > 20) {
			$error = "Author name too long!";
			$validation_errors[count($validation_errors)] = $error;
		}
		if (strlen($_POST['title']) > 30) {
			$error = "Book title too long!";
			$validation_errors[count($validation_errors)] = $error;
		}
	    if (strlen($_POST['genre']) > 10) {
			$error = "Book genre too long!";
			$validation_errors[count($validation_errors)] = $error;
		}
		if (strlen($_POST['year']) > 4) {
			$error = "Book year too long!";
			$validation_errors[count($validation_errors)] = $error;
		}
		if (strlen($_POST['ISBN']) > 20) {
			$error = "Book ISBN too long!";
			$validation_errors[count($validation_errors)] = $error;
		}
		
		if (!(is_numeric($_POST['year']))) {
			$error = "Year not numeric.
			Please enter in format YYYY";
			$validation_errors[count($validation_errors)] = $error;
		}
		if (!(is_numeric($_POST['ISBN']))) {
			$error = "ISBN not numeric. Remove any invalid
			characters such as dashes.";
			$validation_errors[count($validation_errors)] = $error;
		}
		if (!(is_numeric($_POST['id']))) {
			$error = "ID not numeric.";
			$validation_errors[count($validation_errors)] = $error;
		}
		
		if (count($validation_errors)) {
			return false;
		}
		else {
			return true;
		}
	}
  


  $result->close();
$conn->close(); 
  ?>


