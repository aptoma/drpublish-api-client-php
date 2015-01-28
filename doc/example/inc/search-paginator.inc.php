<div class="paginator">
<?php foreach (array('first', 'prev', 'next', 'last') as $label) { ?>
    <?php if($drPublishApiClientSearchList->hasLink($label)) { ?>
        <?php
            $parameters =  str_replace(array('"', ' '), array("%22", '+'), $drPublishApiClientSearchList->getLink($label)->parameters);
        ?>
           <a href="#" onclick="DrPublishApiClientExample.sendGetRequest('action=<?php print($_GET['action']) ?>&readyRequest=true&<?php print($parameters) ?>'); return false;"><?php print($label) ?></a>
    &nbsp;
    <?php } ?>
<?php } ?>
</div>