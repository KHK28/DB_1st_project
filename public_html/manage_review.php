<?php include ("header.php"); ?>
﻿<?php include ("dbconfig.php");?>
﻿
﻿<div id="main">
﻿	<br>
﻿	<form name="search_form" action="manage_review_with_result.php" method="post">
		아이디&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type="text" name="id"><br>
		비밀번호&nbsp;:&nbsp;<input type="text" name="password"><br>
		<input type="submit" name="save" value="검색">
	</form>
﻿</div>
﻿<?php include ("footer.php"); ?>