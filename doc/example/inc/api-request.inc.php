<?php
$url = urldecode($dpWebClient->getRequestUri());
$searchServerUrl = $dpWebClient->getSearchQueryUri();
$url = str_replace('&debug', '', $url);

if (strpos($url, '?') !== false) {
    $params = htmlentities(substr($url, strpos($url, '?')+1));
} else {
    $params = substr($url, strrpos($url, '/') +1 );
}
?>
<div class="request-info">
    <?php // "'$searchServerUrl'"?>
    API request parameters: <input type="text" class="api-request" value="<?php print($params) ?>" /><br/>
    Entire API request URL: <a href="<?php print($url) ?>" target="_blank"><?php print($url) ?></a><br/>

<div>
    <strong>Processing time: <span id="procTime"></span> sec</strong> [curl request: <?php print(round($curlTime,3)) ?> sec, processing and rendering: <span id="procRendTime"></span>],
    download speed: <?php print($curlDLSpeed) ?> MBit/s, data transferred: <?php print($curlDLSize) ?> MB
</div>
</div>

</div>
