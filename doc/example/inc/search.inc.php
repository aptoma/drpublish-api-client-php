<h2>Search articles [DrPublishApiWebClient::searchArticle('<?=$query?>', <?=$limit?>, <?=$offset?>)]</h2>
    <? $searchMeta = $drPublishApiClientSearchList->getSearch() ?>
total: <?=$searchMeta->getTotal(); ?> | offset : <?=$searchMeta->getOffset(); ?> | limit : <?=$searchMeta->getLimit(); ?>


<?
//print_r($drPublishApiClientSearchList->getSearch())
?>
<ul>

<?php
	foreach ($drPublishApiClientSearchList as $drpublishApiClientArticle) {
		?>
		<li>
				[<?=$drpublishApiClientArticle->getId()?>]
				<strong><?=$drpublishApiClientArticle->getTitle()?></strong>
                <br/>
            <span style="color: #555">
                published: <?=$drpublishApiClientArticle->getPublished() ?> | written by: <?=$drpublishApiClientArticle->getDPAuthors() ?> |
                categories: <?=$drpublishApiClientArticle->getDPCategories() ?> |
                tags:  <?=$drpublishApiClientArticle->getDPTags() ?>
                <br/>
               <?=$drpublishApiClientArticle->getPreamble()?>
                </span>
		</li>
		<?php
	}
?>
</ul>


<? foreach (array('first', 'prev', 'next', 'last') as $label) { ?>
    <? if($drPublishApiClientSearchList->hasLink($label)) { ?>
        <?
            $parameters =  str_replace('"',"%22", $drPublishApiClientSearchList->getLink($label)->parameters);
        ?>
           <a href="#" onclick="DrPublishApiClientExmample.sendGetRequest('action=search&readyRequest=true&<?=$parameters?>'); return false;"><?=$label?></a>
    &nbsp;
    <? } ?>
<? } ?>
