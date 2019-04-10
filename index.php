<?php
	session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<title>AES final year</title>
	<meta charset="utf-8">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
		body{
		   	height: 500px; /* You must set a specified height */
		    background-position: center; /* Center the image */
	        background-repeat: no-repeat; /* Do not repeat the image */
			background-size: cover;
			background-attachment: fixed;
		}		
	</style>


</head>
<body background="mat.png">
	<div class="container">
		<div class="row justify-content-center" style="background: rgba(176, 105, 180, 0.15); border-radius: 20px; border: 2px solid white">
			<div class="col-md-12">
				<h1 class="text-primary text-center bg-dark rounded" style="padding: 20px;">Modified Advanced Encryption Standard</h1>
				<h1 class="text-center text-white col-md-12" style="background: black;">Encryption Box</h1>
				<?php
					if (isset($_GET['msg']) && strpos($_GET['msg'], 'otCorrect')) {
						echo '<div class="alert alert-warning">
											    <strong>Warning!</strong> The Cipher Key must be 16 bytes.</div>';
					}



				?>
				<form method="POST" action="operations.php">
					<!-- <label>Enter Plain Text: </label> -->
					<textarea class="form-control" name="plain_text" placeholder="Enter Plain TEXT ..."></textarea>									
					<br>
					<input class="form-control" type="text" name="c_key" placeholder="Enter Cypher KEY ...">
					<br>
					<input type="submit" name="encr" class="btn btn-primary" value="Encrypt">
				</form>
			</div>
			
			<?php
				if (isset($_SESSION['cipher']) && isset($_SESSION['plain']) && isset($_SESSION['key'])) {
					echo '<div class="alert alert-warning col-md-8">
										    <strong>Plain Text: </strong>'.$_SESSION['plain'].'</div>';

					echo '<div class="alert alert-primary col-md-8">
										    <strong>Cipher Key: </strong>'.$_SESSION['key'].'</div>';

					$arr = array();
					$arr = str_split($_SESSION['cipher'], 8);

					

					echo '<div class="alert alert-success col-md-8">
										    <strong>Cipher Text: </strong>';
					$cipher = '';
					foreach ($arr as $value) {
						$cipher .= bin2hex(chr(bindec($value)));					
						echo " ";												
					}
					echo "$cipher<br>";
					echo '</div>';					
				}
			?>
			
		</div>

		<div class="row justify-content-center" style="background: rgba(76, 175, 80, 0.15); border-radius: 20px; border: 2px solid orange">
			<div class="col-md-12">
				<h1 class="text-center text-white col-md-12" style="background: black;">Decryption Box</h1>
				<?php
					if (isset($_GET['msg']) && strpos($_GET['msg'], 'otCorrect')) {
						echo '<div class="alert alert-warning">
											    <strong>Warning!</strong> The Cipher Key must be 16 bytes.</div>';
					}



				?>
				<form method="POST" action="operations.php">
					<!-- <label>Enter Plain Text: </label> -->
					<textarea class="form-control" name="plain_text" placeholder="Enter Encrypted Text..."></textarea>									
					<br>
					<input class="form-control" type="text" name="c_key" placeholder="Enter Cypher KEY ...">
					<br>
					<input type="submit" name="decrypt" class="btn btn-primary" value="Decrypt">
				</form>
			</div>
			
			<?php
				if (isset($_SESSION['decrr']) && isset($_SESSION['keyy'])) {

					echo '<div class="alert alert-warning col-md-8">
										    <strong>Cipher Key: </strong>'.$_SESSION['keyy'].'</div>';

					echo '<div class="alert alert-success col-md-8">
										    <strong>Decrypted Text: </strong>'.$_SESSION['decrr'].'</div>';
				}
				session_destroy();
			?>
			
		</div>
		
	</div>
</body>
</html>