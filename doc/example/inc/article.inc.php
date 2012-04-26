
<h2>-- Article Meta --</h2>

paywall: <?=$drpublishApiClientArticle->getEnableComments()?>
<h3>Published [DrPublishApiClientArticleElement DrPublishApiWebClient::getPublished()]</h3>
<div class="result">
    <?=$drpublishApiClientArticle->getPublished()?>
</div>

<h3>Modified [DrPublishApiClientArticleElement DrPublishApiWebClient::getModified()]</h3>
<div class="result">
    <?=$drpublishApiClientArticle->getModified()?>
</div>

<h3>Tags [DrPublishApiClientList DrPublishApiWebClient::getTagNames()]</h3>
<div class="result">
    <?=$drpublishApiClientArticle->getTags() ?>
</div>

<h3>DPTags as dedicated DrPublishApiClientTag objects [DrPublishApiClientList
DrPublishApiWebClient::getDPTags()]</h3>
<div class="result">
    <pre>
<?= printResult($drpublishApiClientArticle->getDPTags()) ?>

    </pre>
</div>

<h3>Categories [DrPublishApiClientList DrPublishApiWebClient::getCategories()]</h3>
<div class="result">
    <?=$drpublishApiClientArticle->getCategories() ?>
</div>

<h3>DPCategories as dedicated DrPublishApiClientCategory objects [DrPublishApiClient::getDPCategories()]</h3>
<div class="result">
<pre>
<?=printResult($drpublishApiClientArticle->getDPCategories())   ?>
</pre>
</div>

<h3>Main category [DrPublishApiClientArticleElement DrPublishApiWebClient::getMainCategoryName()]</h3>
<div class="result">
<?= $drpublishApiClientArticle->getMainDPCategory() ?>
</div>

<h3>Authors as simple list [DrPublishApiClientList DrPublishApiWebClient::getAuthorNames()]</h3>
<div class="result">
    <?= $drpublishApiClientArticle->getDPAuthors() ?>
    <pre>
        <?=printResult($drpublishApiClientArticle->getDPAuthors()) ?>
    </pre>
</div>

<h3>Authors as advanced list [DrPublishApiClientList DrPublishApiWebClient::getDPAuthors(true)]. Extended author data are getting fetched by a separate API request</h3>
<div class="result">
    <? $dpAuthors = $drpublishApiClientArticle->getDPAuthors(true) ?>
    <?=$dpAuthors?>
    <pre>
        <?=printResult($dpAuthors)  ?>
    </pre>
</div>


<h3>Source [DrPublishApiClientArticleElement DrPublishApiWebClient::getSourceName()]</h3>
<div class="result">
    <?=$drpublishApiClientArticle->getSource()?>
</div>


<h2>-- Article Content --</h2>

<h3>Title [DrPublishApiClientArticleElement DrPublishApiWebClient::getTitle()]</h3>
<div class="result">
    <h4><?=$drpublishApiClientArticle->getTitle()?></h4>
</div>

<h3>Preamble [DrPublishApiClientArticleElement DrPublishApiWebClient::getPreamble()]</h3>
<div class="result">
    <div class="content-container"><b> <?=$drpublishApiClientArticle->getPreamble()?>
    </b></div>
</div>

<h3>LeadAsset [DrPublishApiClientArticleElement DrPublishApiWebClient::getLeadAsset()]</h3>
<div class="result">
    <?php $leadAsset = $drpublishApiClientArticle->getLeadAsset() ?>
    <div class="content-container"><?=$leadAsset?>
    <div style="clear: both"></div>
    </div>
</div>

<h3>Body Text [DrPublishApiClientArticleElement DrPublishApiWebClient::getBodyText()]</h3>
<div class="result">
    <div class="content-container"><?=$drpublishApiClientArticle->getBodyText()?></div>
</div>

<h3>All images [DrPublishApiClientList DrPublishApiWebClient::getImages()]</h3>
<div class="result">
    <div class="content-container"><?=$drpublishApiClientArticle->findImages()?>
    <h4>Image URL's [array DrPublishApiClientList::getAttributes('src')]</h4>
        <pre>
             <? print_r($drpublishApiClientArticle->findImages()->getAttributes('src'))?>
        </pre>
</div>
</div>


<h3>DPImages</h3>
<div class="result">
    <h4>Including wrapping markups [DrPublishApiClientList DrPublishApiWebClient::getDPImages()]</h4>
    <? $drpublishApiClientImages = $drpublishApiClientArticle->getDPImages(); ?>
    <div class="content-container">
        <?=$drpublishApiClientImages?>
        
        <?php
        foreach ($drpublishApiClientImages as $drpublishApiClientImage) {
            print "<br/><br/> photographer: ";
            printResult($drpublishApiClientImage->getPhotographer());
            print "<br/> title: " . $drpublishApiClientImage->getTitle();
            print "<br/> description: " . $drpublishApiClientImage->getDescription();
            print "<br/> source: " . $drpublishApiClientImage->getSource();
            //print "<br/> image element " . 	$drpublishApiClientImage->getImage();
        }

        ?>
    <h4>Thumbnails [DrPublishApiWebClientArticleElement
    DrPublishApiWebClientImageElement::getThumbnail(size)]</h4>
    <pre>
    <?php
    foreach ($drpublishApiClientImages as $drpublishApiClientImageElement) {
        $drpublishApiClientImage = $drpublishApiClientImageElement->getResizedImage(75);
        print printResult($drpublishApiClientImage);
        print ($drpublishApiClientImage);
        print " width=" . $drpublishApiClientImage->getWidth();
        print " src=" . $drpublishApiClientImage->getUrl();
    }
    exit;
    ?>
    </div>
    </pre>
</div>

<h3>Fact Boxes [DrPublishApiClientList DrPublishApiWebClient::getFactBoxes()]</h3>
<div class="result">
    <div class="content-container"><?=$drpublishApiClientArticle->getFactBoxes();?></div>
</div>