<em class="error-message">
    An exception has been raised: <?= $e->getMessage()  ?>
    <br/>
    Cause: <?= $e->getCause() ?>
    <br/>
    Request URL: <a href="<?= $e->getRequestUrl() ?>" target="_blank"><?= $e->getRequestUrl() ?></a>
</em>
