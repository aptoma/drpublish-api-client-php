<?php
function printResult($result) {
	ob_start();
	var_dump($result);
	$out = ob_get_contents();
	ob_end_clean();
	return $out;
}