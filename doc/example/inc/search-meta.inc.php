<? $searchMeta = $drPublishApiClientSearchList->getSearch() ?>
<div class="search-meta">
    total: <?=$searchMeta->getTotal(); ?> | offset : <?=$searchMeta->getOffset(); ?> | limit : <?=$searchMeta->getLimit(); ?>
</div>