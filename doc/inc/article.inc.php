<? include('api-request.inc.php') ?>

<h2>Source [DrPublishApiClientArticleElement DrPublishApiWebClient::getSourceName()]</h2>
<div class="result">
    <?=$drpublishApiClientArticle->getSourceName()?>
</div>

<h2>Published [DrPublishApiClientArticleElement DrPublishApiWebClient::getPublished()]</h2>
<div class="result">
    <?=$drpublishApiClientArticle->getPublished()?>
</div>

<h2>Modified [DrPublishApiClientArticleElement DrPublishApiWebClient::getModified()]</h2>
<div class="result">
    <?=$drpublishApiClientArticle->getModified()?>
</div>

<h2>Tags [DrPublishApiClientList DrPublishApiWebClient::getTagNames()]</h2>
<div class="result">
    <?=$drpublishApiClientArticle->getTagNames() ?>
</div>

<h2>DPTags as dedicated DrPublishApiClientTag objects [DrPublishApiClientList
DrPublishApiWebClient::getDPTags()]</h2>
<div class="result">
<? //= printResult($drpublishApiClientArticle->getDPTags()) ?>
</div>

<h2>Categories [DrPublishApiClientList DrPublishApiWebClient::getCategories()]</h2>
<div class="result">
    <?=$drpublishApiClientArticle->getCategories() ?>
</div>

<h2>DPCategories as dedicated DrPublishApiClientCategory objects [DrPublishApiClientListDrPublishApiWebClient::getDPCategories()]</h2>
<div class="result">
    <? //=printResult($drpublishApiClientArticle->getDPCategories())   ?>
</div>

<h2>DPCategorys' parent category DrPublishApiClientCategory objects [DrPublishApiClientCategory::getParent()]</h2>
<div class="result">
    <?php
    //foreach ($drpublishApiClientArticle->getDPCategories() as $drpublishApiClientCategory) {
    //	print printResult($drpublishApiClientCategory->getParent());
    //}
    ?>
</div>

<h2>Main category [DrPublishApiClientArticleElement DrPublishApiWebClient::getMainCategoryName()]</h2>
<div class="result">
<?= $drpublishApiClientArticle->getMainCategoryName() ?>
</div>

<h2>Authors as simple list DrPublishApiClientArticleElement [DrPublishApiClientList DrPublishApiWebClient::getAuthorNames()]</h2>
<div class="result">
    <?= $drpublishApiClientArticle->getAuthorNames() ?>
</div>

<h2>Authors as DrPublishApiClientAuthor list [DrPublishApiClientList DrPublishApiWebClient::getDPAuthors()]</h2>
<div class="result">
    <? //$drpublishApiClientArticle->getDPAuthors() ?>
</div>


<h1>--Content--</h1>

    <h2>Title [DrPublishApiClientArticleElement DrPublishApiWebClient::getTitle()]</h2>
<div class="result">
    <h3><?=$drpublishApiClientArticle->getTitle()?></h3>
</div>

<h2>Preamble [DrPublishApiClientArticleElement DrPublishApiWebClient::getPreamble()]</h2>
<div class="result">
    <div class="content-container"><b> <?=$drpublishApiClientArticle->getPreamble()?>
    </b></div>
</div>

<h2>LeadAsset [DrPublishApiClientArticleElement DrPublishApiWebClient::getLeadAsset()]</h2>
<div class="result">
    <?php $leadAsset = $drpublishApiClientArticle->getLeadAsset() ?>
    <div class="content-container"><?=($leadAsset != null) ? $leadAsset->content() : '' ?>
    <div style="clear: both"></div>
    </div>
</div>

<h2>Body Text [DrPublishApiClientArticleElement DrPublishApiWebClient::getBodyText()]</h2>
<div class="result">
    <div class="content-container"><?=$drpublishApiClientArticle->getBodyText()?></div>
</div>

<h2>All images [DrPublishApiClientList DrPublishApiWebClient::getImages()]</h2>
<div class="result">
    <div class="content-container"><?=$drpublishApiClientArticle->getImages()?>
    <h3>Image URL's [array DrPublishApiClientList::getAttributes('src')]</h3>
    <?= printResult($drpublishApiClientArticle->getImages()->getAttributes('src'))?></div>
</div>


<h2>DPImages</h2>
<div class="result">
    <h3>Including wrapping markups [DrPublishApiClientList DrPublishApiWebClient::getDPImages()]</h3>
    <div class="content-container"><?=$drpublishApiClientArticle->getDPImages()?> <?php
    $drpublishApiClientImages = $drpublishApiClientArticle->getDPImages();
    foreach ($drpublishApiClientImages as $drpublishApiClientImage) {
        print "<br/><br/> photographer: ";
        printResult($drpublishApiClientImage->getPhotographer());
        print "<br/> title: " . $drpublishApiClientImage->getTitle();
        print "<br/> description: " . $drpublishApiClientImage->getDescription();
        print "<br/> source: " . $drpublishApiClientImage->getSource();
        print "<br/> image element " . 	$drpublishApiClientImage->getImage();
    }
    ?>
    <h3>Thumbnails [DrPublishApiWebClientArticleElement
    DrPublishApiWebClientImageElement::getThumbnail(size)]</h3>
    <pre>
    <?php
    foreach ($drpublishApiClientImages as $drpublishApiClientImageElement) {
        $drpublishApiClientImage = $drpublishApiClientImageElement->getThumbnail(75);
        print printResult($drpublishApiClientImage);
        print ($drpublishApiClientImage);
        print " width=" . $drpublishApiClientImage->getWidth();
        print " src=" . $drpublishApiClientImage->getUrl();
    }
    ?>
    </div>
    </pre>
</div>

<h2>Fact Boxes [DrPublishApiClientList DrPublishApiWebClient::getFactBoxes()]</h2>
<div class="result">
    <div class="content-container"><?=$drpublishApiClientArticle->getFactBoxes();?></div>
</div>