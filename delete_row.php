<?php // connect.php allows connection to the database

  require 'connect.php'; //using require will include the connect.php file each time it is called.

    if (isset($_POST['id']))
       
		
      
  {
	$validation_errors = array();  
	
    $id     = assign_data($conn, 'id');
    
    $query  = "SELECT * FROM books WHERE id = $id";
	$result = $conn->query($query);
	$rows = $result->num_rows;
	
    $validation_passed = Validate($validation_errors, $rows);
    if ($validation_passed) {
    
	$query    = "DELETE FROM books WHERE id = $id";
	
    $result   = $conn->query($query);
    if (!$result) echo "<br><br>DELETE failed: $query<br>" .
	
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
      
    <input type="submit" value="DELETE RECORD">
	
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
		if ($rows < 1) {
			$error = "No record exists with that ID!";
			$validation_errors[count($validation_errors)] = $error;
		}
		if (empty($_POST['id'])) {
			$error = "No ID submitted!";
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


