<?
$url = urldecode($dpWebClient->getRequestUri());
$searchServerUrl = $dpWebClient->getSearchQueryUri();
$url = str_replace('&debug', '', $url);
?>
<div class="request-info">
    <? // "'$searchServerUrl'"?>
    DrPublish API request: <a href="<?=$url ?>" target="_blank"><?=$url ?></a><br/>
    Search server request: <a href="<?=str_replace('"', '%22', $searchServerUrl )?>" target="_blank"><?=$searchServerUrl ?></a>
</div>


</div>

