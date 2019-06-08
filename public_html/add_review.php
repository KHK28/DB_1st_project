<?php include ("header.php"); ?>
﻿<?php include ("dbconfig.php"); ?>
﻿<div id="main">
	<br>
	<form name="search_form" action="check_add_review.php" method="post">
		도서명&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type="text" name="title"><br>
		출판사&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type="text" name="press"><br>
		저자명&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type="text" name="artist"><br>
		평점&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
		<select name="rating">
			<option value=1>1</option>
			<option value=2>2</option>
			<option value=3>3</option>
			<option value=4>4</option>
			<option value=5>5</option>
		</select>
		<br>
		아이디&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type="text" name="id"><br>
		비밀번호&nbsp;:&nbsp;<input type="text" name="password"><br>
		리뷰쓰기&nbsp;:<br><textarea name="review" cols="60" rows="10">400자 이내로 리뷰를 남겨주세요</textarea>
		<input type="submit" name="save" value="저장">
	</form>
﻿</div>
﻿<?php include ("footer.php"); ?>