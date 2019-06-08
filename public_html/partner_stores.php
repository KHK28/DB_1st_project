<?php include ("header.php"); ?>
﻿<?php include ("dbconfig.php"); ?>
﻿<div id="main">
﻿	<?
		$conn = dbconnect($host, $dbid, $dbpass, $dbname);
﻿	?>
﻿	<br>
	<form name="select_form" action="partner_stores.php" method="post">
		<b>서점 선택</b>&nbsp;&nbsp;:
		<select name="store">
			<?
				$query = "SELECT * FROM partner_store";
				$res = mysqli_query($conn, $query);
				$count = 0;
				while($row = mysqli_fetch_array($res))
				{
					if($count == 0)
					{
						if(array_key_exists('store_name', $_GET))
						{
							$init_store_name = $_GET['store_name'];
						}
						else if(array_key_exists('store', $_POST))
						{
							$init_store_name = $_POST['store'];
						}
						else
						{
							$init_store_name = $row['store_name'];
						}
					}
					echo "<option value='{$row['store_name']}'>{$row['store_name']}</option>";
					$count = $count + 1;
				}
			?>
		</select>
		<input type="submit" name="save" value="선택"><br><br>
		</form>
		
		<?
			$store_name = $init_store_name;
			if(array_key_exists('store_name', $_GET) && array_key_exists('review', $_POST))
			{
				if(!empty($_POST['review']))
				{
					$review = $_POST['review'];
					$time = time();
					$store_review_id = "SR_{$time}";
					//store_review 저장
					$query = "INSERT INTO store_review (review_id, review) VALUES ('$store_review_id', '$review')";
					mysqli_query($conn, $query);
					//comment_to_review 저장
					$query = "INSERT INTO comment_to_store (review_id, store_name) VALUES ('$store_review_id', '$store_name')";
					mysqli_query($conn, $query);
				}
			}
			
			$query = "SELECT * FROM partner_store WHERE store_name='$store_name'";
			$res = mysqli_query($conn, $query);
			$row = mysqli_fetch_array($res);
			$location = $row['location'];
			echo "<font size = 5>STORE : {$store_name}, 위치 : {$location}</font>";
		?>
		
		<br>
		<br>
		<b>이달의 추천도서</b><br>
		
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
    				<?
    					$query = "SELECT * FROM book NATURAL JOIN recommends NATURAL JOIN partner_store  NATURAL JOIN (SELECT book_id, avg(rating) as avg_rating FROM book NATURAL JOIN review_to_book NATURAL JOIN review GROUP BY book_id)a WHERE store_name = '$store_name'";
    					$res = mysqli_query($conn, $query);
    					if(($row = mysqli_fetch_array($res)))
    					{
    				    	echo "<tr>";
    				    	echo "<td>{$row['book_name']}</td>";
        					echo "<td>{$row['writer']}</td>";
    						echo "<td>{$row['press']}</td>";
        					echo "<td>{$row['avg_rating']}</td>";
        					echo "</tr>";
    					}
    				?>
    		</tbody>
    	</table>
    	
    	<? echo "<form name='feedback_form' action='partner_stores.php?store_name={$store_name}' method='post'>"; ?>
			<b>서점에 직접 피드백을 남기세요!(120자 이내)</b><br>
			<input type="text" name="review">&nbsp;&nbsp;<input type="submit" name="save" value="저장">
			<?
				$query = "SELECT * FROM partner_store NATURAL JOIN comment_to_store NATURAL JOIN store_review WHERE store_name='$store_name'";
				$res = mysqli_query($conn, $query);
				$count = 1;
				while($row =  mysqli_fetch_array($res))
				{
					echo "<br>";
					echo "{$count}.   {$row['review']}";
					$count = $count + 1;
				}
			?>
			<br>
		</form>
﻿</div>
﻿﻿<?mysqli_close($conn);?> 
﻿<?php include ("footer.php"); ?>