<?
//여기서는 $_GET사용
?>
﻿<?php include ("header.php"); ?>
﻿<?php include ("dbconfig.php"); ?>
﻿<div id="main">
﻿	<? $conn = dbconnect($host, $dbid, $dbpass, $dbname);
 	$book_id = $_GET['book_id']; 
 	
 	$query = "SELECT * FROM book NATURAL JOIN (SELECT book_id, AVG(rating) AS avg_rating FROM review NATURAL JOIN review_to_book NATURAL JOIN book GROUP BY book_id)a WHERE book_id='$book_id'";

 	$res = mysqli_query($conn, $query);
    if (!$res) 
    {
        echo "<p>DB Error</p>";
    }?>
    
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>제목</th>
            <th>저자</th>
            <th>출판사</th>
            <th>평균 평점</th>
        </tr>
        </thead>
        <tbody>
    <?
 	
 	if ($row = mysqli_fetch_array($res))
    {
        echo "<tr>";
        echo "<td>{$row['book_id']}</td>";
        echo "<td>{$row['book_name']}</td>";
        echo "<td>{$row['writer']}</td>";
        echo "<td>{$row['press']}</td>";
        echo "<td>{$row['avg_rating']}</td>";
        echo "</tr>";
    }
    ?>
        </tbody>
    </table>
    <?
	$query = "SELECT * FROM book NATURAL JOIN review_to_book NATURAL JOIN review NATURAL JOIN write_to_review NATURAL JOIN account WHERE book_id='$book_id'";
    $res = mysqli_query($conn, $query);
    if (!$res) 
    {
        echo "<p>No result</p>";
        die('Query Error : ' . mysqli_error());
    }
     while ($row = mysqli_fetch_array($res))
    {
       // echo "<tr>";
        echo "ID : {$row['user_id']}<br>";
        echo "Rating : {$row['rating']} /5<br>";
        echo "Review : {$row['review']}<br><br><br>";
       // echo "</tr>";
    }?>
	
	<br>
﻿</div>
﻿<?mysqli_close($conn);?>
﻿<?php include ("footer.php"); ?>