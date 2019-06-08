<?php include ("header.php"); ?>
﻿<?php include ("dbconfig.php"); ?>

﻿<div id="main">
	<?
		$conn = dbconnect($host, $dbid, $dbpass, $dbname);
		$title = $_POST['title'];
		$press = $_POST['press'];
		$artist = $_POST['artist'];
		$id = $_POST['id'];
		$password = $_POST['password'];
		$review = $_POST['review'];
		
		if(empty($title) || empty($press) || empty($artist) || empty($id) || empty($password) || empty($review))
		{
			echo "<b>저장할 수 없음 : 양식을 전부 입력하십시오</b>";
			echo "<br><br>";
			echo "<form name='search_form' action='check_add_review.php' method='post'>";
			echo "도서명&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='title'><br>";
			echo "출판사&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='press'><br>";
			echo "저자명&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='artist'><br>";
			echo "평점&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;";
			echo "<select name='rating'>";
			echo "<option value=1>1</option>";
			echo "<option value=2>2</option>";
			echo "<option value=3>3</option>";
			echo "<option value=4>4</option>";
			echo "<option value=5>5</option>";
			echo "</select><br>";
			echo "아이디&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='id'><br>";
			echo "비밀번호&nbsp;:&nbsp;<input type='text' name='password'><br>";
			echo "리뷰쓰기&nbsp;:<br><textarea name='review' cols='60' rows='10'>{$review}</textarea>";
			echo "<input type='submit' name='save' value='저장'><br>";
			echo "</form>";
			mysqli_close($conn);
			include ("footer.php");
			exit;
		}
		else
		{
			$query = "SELECT * FROM account WHERE user_id='$id'";
			$res = mysqli_query($conn, $query);
			if (!$res) 
    		{
        		echo "<b>DB Error</b>";
        		echo "<br><br>";
				echo "<form name='search_form' action='check_add_review.php' method='post'>";
				echo "도서명&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='title'><br>";
				echo "출판사&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='press'><br>";
				echo "저자명&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='artist'><br>";
				echo "평점&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;";
				echo "<select name='rating'>";
				echo "<option value=1>1</option>";
				echo "<option value=2>2</option>";
				echo "<option value=3>3</option>";
				echo "<option value=4>4</option>";
				echo "<option value=5>5</option>";
				echo "</select><br>";
				echo "아이디&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='id'><br>";
				echo "비밀번호&nbsp;:&nbsp;<input type='text' name='password'><br>";
				echo "리뷰쓰기&nbsp;:<br><textarea name='review' cols='60' rows='10'>{$review}</textarea>";
				echo "<input type='submit' name='save' value='저장'><br>";
				echo "</form>";
				mysqli_close($conn);
				include ("footer.php");
				exit;
    		}
			if(!($row = mysqli_fetch_array($res)))
			{
				//DB에 ID, PW 추가
				$query = "insert into account (user_id, pw) values ('$id', '$password')";
				mysqli_query($conn, $query);
			}
			else
			{
				if(strcmp((string)$row[pw], (string)$password) != 0)
				{
					echo "<b>저장할 수 없음 : 패스워드 오류</b>";
        			echo "<br><br>";
					echo "<form name='search_form' action='check_add_review.php' method='post'>";
					echo "도서명&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='title'><br>";
					echo "출판사&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='press'><br>";
					echo "저자명&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='artist'><br>";
					echo "평점&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;";
					echo "<select name='rating'>";
					echo "<option value=1>1</option>";
					echo "<option value=2>2</option>";
					echo "<option value=3>3</option>";
					echo "<option value=4>4</option>";
					echo "<option value=5>5</option>";
					echo "</select><br>";
					echo "아이디&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='id'><br>";
					echo "비밀번호&nbsp;:&nbsp;<input type='text' name='password'><br>";
					echo "리뷰쓰기&nbsp;:<br><textarea name='review' cols='60' rows='10'>{$review}</textarea>";
					echo "<input type='submit' name='save' value='저장'><br>";
					echo "</form>";
					mysqli_close($conn);
					include ("footer.php");
					exit;
				}
			}
			$query = "SELECT book_id FROM book WHERE book_name='$title' AND press='$press' AND writer='$artist'";
			$res = mysqli_query($conn, $query);
			$time = time();
			$book_id = "book_{$time}";
			$review_id = "review_{$time}";
			if(!($row = mysqli_fetch_array($res)))
			{
				//DB에 book 추가
				$query = "insert into book (book_id, book_name, press, writer) values ('$book_id', '$title', '$press', '$artist')";
				//echo "query is : $query";
				mysqli_query($conn, $query);
			}
			else
			{
				$book_id = $row['book_id'];
			}
			//DB에 review 추가
			$rating = (int)$_POST['rating'];
			$query = "insert into review (review_id, review, rating) values ('$review_id', '$review', $rating)";
			mysqli_query($conn, $query);
			//DB에 review_to_book 추가
			$query = "insert into review_to_book (review_id, book_id) values ('$review_id', '$book_id')";
			mysqli_query($conn, $query);
			//DB에 write_to_review 추가
			$query = "insert into write_to_review (user_id, review_id) values ('$id', '$review_id')";
			mysqli_query($conn, $query);
		}
		
		echo "<br>";
		echo "<form name='search_form' action='check_add_review.php' method='post'>";
		echo "도서명&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='title'><br>";
		echo "출판사&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='press'><br>";
		echo "저자명&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='artist'><br>";
		echo "평점&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;";
		echo "<select name='rating'>";
		echo "<option value=1>1</option>";
		echo "<option value=2>2</option>";
		echo "<option value=3>3</option>";
		echo "<option value=4>4</option>";
		echo "<option value=5>5</option>";
		echo "</select><br>";
		echo "아이디&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type='text' name='id'><br>";
		echo "비밀번호&nbsp;:&nbsp;<input type='text' name='password'><br>";
		echo "리뷰쓰기&nbsp;:<br><textarea name='review' cols='60' rows='10'>{$review}</textarea>";
		echo "<input type='submit' name='save' value='저장'><br>";
		echo "</form>";
	?>
﻿</div>
﻿﻿<?mysqli_close($conn);?>
﻿<?include ("footer.php");?>