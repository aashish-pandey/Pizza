<?php 

include('config/db_connect.php');


$email = $title = $ingredients = '';
$errors = array('email' => '', 'title' => '', 'ingredients' => '');



if (isset($_POST['submit'])) {

	if(empty($_POST['email'])){
		$errors['email'] = "An email is required <br />";
	}
	else{
		$email = $_POST['email'];
		// if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		// 	$errors['email'] = 'Enter a valid email <br />';
		// }
	}

	if(empty($_POST['title'])){
		$errors['title'] =  "A title is required <br />";
	}
	else{
		$title = $_POST['title'];

		if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
			$errors['title'] = 'title can contain only letters and space <br />';
		}
	}

	if(empty($_POST['ingredients'])){
		$errors['ingredients'] = "At least one ingredients is required <br />";
	}
	else{
		$ingredients = $_POST['ingredients'];

		if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
			$errors['ingredients'] = 'Ingredients must be a comma seperated list <br />';
		}
	}


	if(!array_filter($errors)){

		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$title = mysqli_real_escape_string($conn, $_POST['title']);
		$ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

		$sql = "INSERT INTO PIZZA(title, ingredients, email) VALUES('$title', '$ingredients', '$email')";

		if(mysqli_query($conn, $sql)){
			header("Location: index.php");
		}else{
			echo 'query error: ' . mysqli_error($conn);
		}

		
	}
	
}

 ?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<section class="container grey-text">
	<h4 class="center">Add a Pizza</h4>
	<form class="white" action="add.php" method="POST">
		<label>Your Email</label>
		<input type="text" name="email" value = "<?php echo $email;?>">
		<div class="red-text"> <?php echo $errors['email']; ?> </div>
		<label>Pizza title</label>
		<input type="text" name="title" value=" <?php echo $title; ?> ">
		<div class="red-text"> <?php echo $errors['title']; ?> </div>
		<label>Ingredients (comma seperated)</label>
		<input type="text" name="ingredients" value=" <?php echo $ingredients; ?> ">
		<div class="red-text"> <?php echo $errors['ingredients']; ?> </div>

		<div class="center">
			<input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
		</div>
	</form>
</section>

<?php include('templates/footer.php'); ?>


</html>