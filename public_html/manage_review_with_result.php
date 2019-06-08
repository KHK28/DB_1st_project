<?php include ("header.php"); ?>
<?php include ("dbconfig.php");?>

<?
	$conn = dbconnect($host, $dbid, $dbpass, $dbname);
	$user_id = $_POST['id'];
	$pw = $_POST['password'];
	$query = "SELECT * FROM account WHERE user_id='$user_id' AND pw='$pw'";
	$res = mysqli_query($conn, $query);
	if(!res) 
	{
		echo "DB Error";
		mysqli_close($conn);
		include ("footer.php");
	}
?>

<div id="main">
	<br>
	<?
	if(array_key_exists('review_id', $_GET))
	{
		if(array_key_exists('review', $_POST))
		{
			//수정
			$new_review = $_POST['review'];
			$review_id = $_GET['review_id'];
			$query = "UPDATE review SET review='$new_review' WHERE review_id='$review_id'";
			mysqli_query($conn, $query);
			echo "query : $query";
			echo "<br>";
			echo "new review : $new_review";
			echo "<br>";
			echo "수정 완료";
			echo "<br>";
		}
		else
		{
			//삭제
			$query = "DELETE FROM review WHERE review_id='{$_GET['review_id']}'";
			mysqli_query($conn, $query);
			$query = "DELETE FROM write_to_review WHERE review_id='{$_GET['review_id']}'";
			mysqli_query($conn, $query);
			$query = "DELETE FROM review_to_book WHERE review_id='{$_GET['review_id']}'";
			mysqli_query($conn, $query);
			echo "삭제 완료";
			echo "<br>";
		}
		echo "<form name='search_form' action='manage_review_with_result.php' method='post'>";
		echo "아이디&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='id'><br>";
		echo "비밀번호&nbsp;:&nbsp;<input type='text' name='password'><br>";
		echo "<input type='submit' name='save' value='검색'>";
		echo "</form>";
		echo "</div>";
		mysqli_close($connection);
		include ("footer.php");
		exit;
	}
	else 
	{
		if(!($row = mysqli_fetch_array($res)))
		{
			echo "해당하는 계정이 없음";
			echo "<form name='search_form' action='manage_review_with_result.php' method='post'>";
			echo "아이디&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='id'><br>";
			echo "비밀번호&nbsp;:&nbsp;<input type='text' name='password'><br>";
			echo "<input type='submit' name='save' value='검색'>";
			echo "</form>";
			echo "</div>";
			mysqli_close($connection);
			include ("footer.php");
			exit;
		} 
	}
	?>
	
	<form name="search_form" action="manage_review_with_result.php" method="post">
		아이디&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type="text" name="id"><br>
		비밀번호&nbsp;:&nbsp;<input type="text" name="password"><br>
		<input type="submit" name="save" value="검색">
	</form>
	
	<table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>제목</th>
            <th>저자</th>
            <th>출판사</th>
            <th>삭제</th>
            <th>수정</th>
        </tr>
        </thead>
        <tbody>
    <?
    $query = "SELECT * FROM account NATURAL JOIN write_to_review NATURAL JOIN review NATURAL JOIN review_to_book NATURAL JOIN book WHERE user_id='$user_id' AND pw='$pw'";
	$res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($res))
    {
        echo "<tr>";
        echo "<td>{$row['book_id']}</td>";
        echo "<td>{$row['book_name']}</td>";
        echo "<td>{$row['writer']}</td>";
        echo "<td>{$row['press']}</td>";
        echo "<td><a href='manage_review_with_result.php?review_id={$row['review_id']}'><button class='primary small'>삭제</button></a></td>";
        echo "<td><a href='modify.php?review_id={$row['review_id']}&'><button class='primary small'>수정</button></a></td>"; 
        echo "</tr>";
    }?>
    </tbody>
    </table>
	
</div>
<?mysqli_close($conn);?>
<?php include ("footer.php"); ?>