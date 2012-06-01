<?
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
    <? // "'$searchServerUrl'"?>
    API request parameters: <input type="text" class="api-request" value="<?= $params ?>" /><br/>
    API request URL: <a href="<?=$url ?>" target="_blank"><?=$url ?></a><br/>
    Search server URL: <a href="<?=str_replace('"', '%22', $searchServerUrl )?>" target="_blank"><?=$searchServerUrl ?></a>
<div>
    <strong>Process time</strong> curl request: <?=round($curlTime,3) ?>sec, processing and rendering: <span id="procRendTime"></span>,
    total: <span id="procTime"></span>

</div>
</div>

</div>
