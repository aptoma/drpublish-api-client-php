<?php
function printResult($result) {
	ob_start();
	var_dump($result);
	$out = ob_get_contents();
	ob_end_clean();
	return $out;
}

function printSourceCode() {
   $trace = debug_backtrace(false);
   $source = file_get_contents($trace[0]['file']);
   $source = preg_replace('#<\?=\s?printSourceCode\(\)\s?\?>#', '', $source);
   $out = '<div style="clear:both"></div>';
   $out .= '<h3>Source code of the PHP template file above</h3>';
   $out .= '<pre><code class="language-php">';
   $out .= htmlentities($source);
   $out.= '</code></pre>';
   return $out;
}
