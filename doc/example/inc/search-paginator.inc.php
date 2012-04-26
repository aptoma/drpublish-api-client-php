<div class="paginator">
<? foreach (array('first', 'prev', 'next', 'last') as $label) { ?>
    <? if($drPublishApiClientSearchList->hasLink($label)) { ?>
        <?
            $parameters =  str_replace(array('"', ' '), array("%22", '+'), $drPublishApiClientSearchList->getLink($label)->parameters);
        ?>

           <a href="#" onclick="DrPublishApiClientExmample.sendGetRequest('action=<?=$_GET['action']?>&readyRequest=true&<?=$parameters?>'); return false;"><?=$label?></a>
    &nbsp;
    <? } ?>
<? } ?>
</div>