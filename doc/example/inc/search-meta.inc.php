<?php $searchMeta = $drPublishApiClientSearchList->getSearch() ?>
<div class="search-meta">
    total: <?php print($searchMeta->getTotal()) ?> | offset : <?php print($searchMeta->getOffset()) ?> | limit : <?php print($searchMeta->getLimit()) ?>
</div>