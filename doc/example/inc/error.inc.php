<em class="error-message">
    An exception has been raised: <?php print($e->getMessage()) ?>
    <br/>
    Cause: <?php print($e->getCause()) ?>
    <br/>
    Request URL: <a href="<?php print($e->getRequestUrl()) ?>" target="_blank"><?php print($e->getRequestUrl()) ?></a>
</em>
