<?

$url = urldecode($dpWebClient->getRequestUri());
$searchServerUrl = $dpWebClient->getSearchQueryUri();
$url = str_replace('&debug', '', $url);
?>
<div class="request-info">
    <? // "'$searchServerUrl'"?>
    API request parameters: <input type="text" class="api-request" value="<?= substr($url, strpos($url, '?')+1) ?>" /><br/>
    API request URL: <a href="<?=$url ?>" target="_blank"><?=$url ?></a><br/>
    Search server URL: <a href="<?=str_replace('"', '%22', $searchServerUrl )?>" target="_blank"><?=$searchServerUrl ?></a>
</div>
</div>

