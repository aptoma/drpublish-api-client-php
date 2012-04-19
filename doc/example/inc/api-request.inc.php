<?
$url = urldecode($dpWebClient->getRequestUri());
$serchServerUrl = $dpWebClient->getSearchQueryUri();
$url = str_replace('&debug', '', $url);
?>
<div class="request-info">
    DrPublish API request: <a href="<?=$url ?>" target="_blank"><?=$url ?></a><br/>
    Search server request: <a href="<?=str_replace('"', '%22', $serchServerUrl)?>" target="_blank"><?=$serchServerUrl ?></a>
</div>


</div>

