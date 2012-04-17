<?
$url = urldecode($dpWebClient->getRequestUri());
$serchServerUrl = $dpWebClient->getSearchQueryUri();
$url = str_replace('&debug', '', $url);
?>
<h2>DrPublish API request</h2>
<div class="result">
    <a href="<?=$url ?>" target="_blank"><?=$url ?></a>
</div>

<h2>Search server request</h2>
<div class="result">
    <a href="<?=str_replace('"', '%22', $serchServerUrl)?>" target="_blank"><?=$serchServerUrl ?></a>
</div>

