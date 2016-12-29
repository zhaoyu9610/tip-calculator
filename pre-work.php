<!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <title>Tip-calculator</title>
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <style>
     .error {color: #FF0000;}
 </style>
 <body>
 <?php
 $subtotal = $percentage = "";
 $split = 1;
 $choice = "";
 $subtotalErr = $percentageErr = $splitErr = "";
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (empty($_POST["subtotal"])) {
         $subtotalErr = "Subtotal is required";
     } elseif($_POST["subtotal"] < 0){
		 $subtotalErr = "Subtotal must be positive!";
	 } else {
         $subtotal = test_input($_POST["subtotal"]);
     }
	 
     if (empty($_POST["percentage"])) {
         $percentageErr = "Percentage is required";
     } elseif($_POST["percentage"] == "custom"){
		 if($_POST["custom"] < 0){
			 $percentageErr = "Percentage must be positive!";
		 } else {
			$percentage = $_POST["custom"];
			$choice = 1;
		 }
	 } else {
         $percentage = test_input($_POST["percentage"]);
		 $choice = $percentage / 5;
     }
	 
	 if (empty($_POST["split"])) {
         $split = 1;
     } elseif($_POST["split"] < 0){
		 $splitErr = "Percentage must be positive";
	 } else {
		$split = test_input($_POST["split"]);
	 }  
 }
 
 function test_input($data) {
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
 }
 ?>
 <div class="container text-center">
	 <div>
		<h2>Tip-calculator</h2>
		<p><span class="error">* Required Field</span></p>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			Bill Subtotal: <span class="error">* <?php echo $subtotalErr;?></span>
			$<input type="text" name="subtotal" value="<?php echo $subtotal;?>" size="7">
			<br><br>
			Tip percentage：<span class="error">* <?php echo $percentageErr;?></span>
			<br><br>
			<?php
				for($i=10; $i<=20; $i+=5){
					echo "<input type=\"radio\" name=\"percentage\" ";
						if($choice == ($i / 5))
							echo "checked";
					echo"value=\"$i\">$i%";
				}
			?>
			<br><br>
			<input type="radio" name="percentage" <?php if (isset($percentage) && $choice == 1) echo "checked";?> value="custom">Custom
			<input type="text" name="custom" size="5" value="<?php if($choice == 1)echo $percentage;?>">%
			<br><br>
			Split：<input type="text" value="<?php echo $split;?>" name="split" size="5"> person(s)
			<span class="error"><?php echo $splitErr;?></span>
			<br><br>
			<input type="submit" name="submit" value="Submit">
		</form>
	</div>
	
	<?php
	 if($subtotal > 0 and $percentage > 0 and $split > 0){
		echo "<div>";
		echo "<h2>Result: </h2>";
		echo "Tip: "; 
		echo $subtotal * ($percentage / 100.0);
		echo "<br>";
		echo "Total: ";
		echo $subtotal * (1 + $percentage / 100.0);
		echo "<br>";
		if($split > 1){
				echo "Tip each: ";
				echo $subtotal * ($percentage / 100.0);
				echo "<br>";
				echo "Total each: ";
				echo $subtotal * (1 + $percentage / 100.0);
				echo "<br>";
		}
		echo "</div>";
	 }
	 ?> 
 </div>
 
 </body>
 </html>