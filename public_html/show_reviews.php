<?php include ("header.php"); ?>
﻿<?php include ("dbconfig.php"); ?>
﻿<div id="main">
﻿	<? $conn = dbconnect($host, $dbid, $dbpass, $dbname); ?>
	<? $query = "SELECT * FROM book NATURAL JOIN review_to_book NATURAL JOIN review NATURAL JOIN write_to_review NATURAL JOIN account";
    $res = mysqli_query($conn, $query);
    if (!$res) 
    {
        echo "<p>No result</p>";
        //die('Query Error : ' . mysqli_error());
    }?>
    <?
     while ($row = mysqli_fetch_array($res))
    {
       // echo "<tr>";
        echo "Title : {$row['book_name']}<br>";
        echo "Written by : {$row['writer']}<br>";
        echo "Press : {$row['press']}<br>";
        echo "Reviewer : {$row['user_id']}<br>";
        echo "Review : {$row['review']}<br>";
        echo "Rating : {$row['rating']} /5<br><br><br>";
       // echo "</tr>";
    }?>
﻿</div>
﻿﻿<?mysqli_close($conn);?>
﻿<?php include ("footer.php"); ?>