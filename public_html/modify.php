<?php include ("header.php"); ?>
﻿<?php include ("dbconfig.php"); ?>
﻿<div id="main">
	<br>
	<?
	$conn = dbconnect($host, $dbid, $dbpass, $dbname);
	$review_id = $_GET['review_id'];
	echo "<form name='modify_form' action='manage_review_with_result.php?review_id={$review_id}' method='post'>";
	$query = "SELECT * FROM review WHERE review_id='$review_id'";
	$res = mysqli_query($conn, $query);
	if(!$res)
	{
		echo "<textarea name='review' cols='60' rows='10'></textarea>";
		echo "<input type='submit' name='search' value='저장'>";
	}
	else
	{
		$row = mysqli_fetch_array($res);
		$review = $row['review'];
		echo "<textarea name='review' cols='60' rows='10'>{$review}</textarea>";
		echo "<input type='submit' name='save' value='저장'>";
	}
	?>
	</form>
	<br>
﻿</div>
﻿<?mysqli_close($conn);?>
﻿<?php include ("footer.php"); ?>