<?php include ("header.php"); ?>
﻿<?php include ("dbconfig.php"); ?>
﻿<div id="main">
	<b>제목, 저자명, 출판사명을 통해 검색할 수 있습니다.</b>
	<br>
	<form name="search_form" action="search_result.php" method="post">
		<input type="checkbox" name="use_title">&nbsp;도서명&nbsp;:&nbsp;<input type="text" name="title"><br>
		<input type="checkbox" name="use_press">&nbsp;출판사&nbsp;:&nbsp;<input type="text" name="press"><br>
		<input type="checkbox" name="use_artist">&nbsp;저자명&nbsp;:&nbsp;<input type="text" name="artist"><br>
		<input type="submit" name="search" value="검색">
	</form>
	<br>
	
	<? 
	$conn = dbconnect($host, $dbid, $dbpass, $dbname);
	$use_title_checked = ($_POST['use_title']) ? 1 : 0;
	$use_press_checked = ($_POST['use_press']) ? 1 : 0;
	$use_artist_checked = ($_POST['use_artist']) ? 1 : 0;
	if($use_title_checked == 0 && $use_press_checked == 0 && $use_artist_checked == 0)
	{
		echo "No input";
		mysqli_close($conn);
		exit;
	}
	else if ($use_title_checked == 0 && $use_press_checked == 0 && $use_artist_checked == 1)
	{
			$query = "SELECT * FROM book NATURAL JOIN (SELECT book_id, AVG(rating) AS avg_rating FROM review NATURAL JOIN review_to_book NATURAL JOIN book GROUP BY book_id)a WHERE writer='{$_POST['artist']}'";
	}
	else if ($use_title_checked == 0 && $use_press_checked == 1 && $use_artist_checked == 0)
	{
			$query = "SELECT * FROM book NATURAL JOIN (SELECT book_id, AVG(rating) AS avg_rating FROM review NATURAL JOIN review_to_book NATURAL JOIN book GROUP BY book_id)a WHERE press='{$_POST['press']}'";
	}
	else if ($use_title_checked == 0 && $use_press_checked == 1 && $use_artist_checked == 1)
	{
			$query = "SELECT * FROM book NATURAL JOIN (SELECT book_id, AVG(rating) AS avg_rating FROM review NATURAL JOIN review_to_book NATURAL JOIN book GROUP BY book_id)a WHERE writer='{$_POST['artist']}' AND press='{$_POST['press']}'";
	}
	else if ($use_title_checked == 1 && $use_press_checked == 0 && $use_artist_checked == 0)
	{
			$query = "SELECT * FROM book NATURAL JOIN (SELECT book_id, AVG(rating) AS avg_rating FROM review NATURAL JOIN review_to_book NATURAL JOIN book GROUP BY book_id)a WHERE book_name='{$_POST['title']}'";
	}
	else if ($use_title_checked == 1 && $use_press_checked == 0 && $use_artist_checked == 1)
	{
			$query = "SELECT * FROM book NATURAL JOIN (SELECT book_id, AVG(rating) AS avg_rating FROM review NATURAL JOIN review_to_book NATURAL JOIN book GROUP BY book_id)a WHERE book_name='{$_POST['title']}' AND writer='{$_POST['artist']}'";
	}
	else if ($use_title_checked == 1 && $use_press_checked == 1 && $use_artist_checked == 0)
	{
			$query = "SELECT * FROM book NATURAL JOIN (SELECT book_id, AVG(rating) AS avg_rating FROM review NATURAL JOIN review_to_book NATURAL JOIN book GROUP BY book_id)a WHERE book_name='{$_POST['title']}' AND press='{$_POST['press']}'";
	}
	else if ($use_title_checked == 1 && $use_press_checked == 1 && $use_artist_checked == 1)
	{
			$query = "SELECT * FROM book NATURAL JOIN (SELECT book_id, AVG(rating) AS avg_rating FROM review NATURAL JOIN review_to_book NATURAL JOIN book GROUP BY book_id)a WHERE book_name='{$_POST['title']}' AND press='{$_POST['press']}' AND writer='{$_POST['artist']}'";
	}
    $res = mysqli_query($conn, $query);
    if (!$res) 
    {
        echo "<p>DB Error</p>";
    }?>
    
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>제목</th>
            <th>저자</th>
            <th>출판사</th>
            <th>상세보기</th>
        </tr>
        </thead>
        <tbody>
    <?
    while ($row = mysqli_fetch_array($res))
    {
        echo "<tr>";
        echo "<td>{$row['book_name']}</td>";
        echo "<td>{$row['writer']}</td>";
        echo "<td>{$row['press']}</td>";
        //echo "<td>{$row['avg_rating']}</td>";
        echo "<td><a href='load_review.php?book_id={$row['book_id']}'><button class='primary small'>상세보기</button></a></td>"; 
        echo "</tr>";
    }?>
    </tbody>
    </table>
	
	<br>
	
﻿</div>
﻿﻿<?mysqli_close($conn);?>
﻿<?php include ("footer.php"); ?>