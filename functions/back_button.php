<?php

//	button that automatically refers to the previous page given the return type parameter
function back_button() {
	if(isset($_GET['return_type'])) {
		$link = "index.php?type={$_GET['return_type']}";
	}else{
		$link = "index.php";
	}
	echo "<a href='{$link}'><div id='back_button'>Terug</div></a>";
}