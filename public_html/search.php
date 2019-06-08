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
﻿</div>
﻿<?php include ("footer.php"); ?>