<?php include ("header.php"); ?>
﻿<?php include ("dbconfig.php"); ?>
﻿
<div id="main">

	<? $conn = dbconnect($host, $dbid, $dbpass, $dbname); ?>

	<h2><b>환영합니다!</b></h2>
	<p>도서 평가 사이트에 오신 것을 환영합니다!<br>
	여러분의 독서 경험을 나누어 더욱 풍요로운 독서 생활을 누리십시오!<br>
	이곳에서는 여러 서적들의 다채로운 리뷰와 평점을 제공합니다.<br>많은 추천을 받는 책들을 찾아보세요.<br>마음에 드는 리뷰를 찾아보세요.<br>
	여러분만의 평을 남겨주세요.<br>여러분의 족적 하나하나가 모두의 풍요로운 독서 생활을 만듭니다.
	</p>
	<br>

	<h2><b>평점 높은 도서</b></h2>
	
	<? $query = "SELECT * FROM book NATURAL JOIN (SELECT book_id, AVG(rating) AS avg_rating FROM review NATURAL JOIN review_to_book GROUP BY book_id)a ORDER BY avg_rating DESC";
    $res = mysqli_query($conn, $query);
    if (!$res) 
    {
        //echo "<p>No result</p>";
        //die('Query Error : ' . mysqli_error());
    }?>
    
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>제목</th>
            <th>저자</th>
            <th>출판사</th>
            <th>평균평점</th>
        </tr>
        </thead>
        <tbody>
    <?$count = 0;
    while ($count < 5 && $row = mysqli_fetch_array($res))
    {
        echo "<tr>";
        echo "<td>{$row['book_name']}</td>";
        echo "<td>{$row['writer']}</td>";
        echo "<td>{$row['press']}</td>";
        echo "<td>{$row['avg_rating']}</td>";
        echo "</tr>";
    	$count = $count + 1;
    }?>
    </tbody>
    </table>
	
	<br>
	
	<h2><b>리뷰 많은 도서</b></h2>
	
	<? $query = "SELECT * FROM book NATURAL JOIN
				(SELECT book_id, count(review) as cnt_review FROM review NATURAL JOIN review_to_book NATURAL JOIN book GROUP BY book_id)a NATURAL JOIN
				(SELECT book_id, AVG(rating) AS avg_rating FROM review NATURAL JOIN review_to_book GROUP BY book_id)b ORDER BY cnt_review DESC";
    $res = mysqli_query($conn, $query);
    if (!$res) 
    {
        //echo "<p>No result</p>";
        //die('Query Error : ' . mysqli_error());
    }?>
    
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>제목</th>
            <th>저자</th>
            <th>출판사</th>
            <th>평균평점</th>
        </tr>
        </thead>
        <tbody>
    <?$count = 0;
    while ($count < 5 && $row = mysqli_fetch_array($res))
    {
        echo "<tr>";
        echo "<td>{$row['book_name']}</td>";
        echo "<td>{$row['writer']}</td>";
        echo "<td>{$row['press']}</td>";
        echo "<td>{$row['avg_rating']}</td>";
        echo "</tr>";
    	$count = $count + 1;
    }?>
    </tbody>
    </table>
	
	<br>
	
	<p>since 2019</p>
</div>
﻿<?mysqli_close($conn);?>
<?php include ("footer.php"); ?>