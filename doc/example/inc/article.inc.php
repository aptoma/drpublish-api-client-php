
<h3>Title [DrPublishApiClientArticleElement DrPublishApiWebClient::getTitle()]</h3>
<div class="result">
    <h4><?php print($drPublishApiClientArticle->getTitle()) ?></h4>
</div>

<h3>Preamble [DrPublishApiClientArticleElement DrPublishApiWebClient::getPreamble()]</h3>
<div class="result">
    <div class="content-container"><b> <?php print($drPublishApiClientArticle->getPreamble()) ?>
    </b></div>
</div>

<h3>LeadAsset [DrPublishApiClientArticleElement DrPublishApiWebClient::getLeadAsset()]</h3>
<div class="result">
    <?php $leadAsset = $drPublishApiClientArticle->getLeadAsset() ?>
    <div class="content-container"><?php print($leadAsset) ?>
    <div style="clear: both"></div>
    </div>
</div>

<h3>Body Text [DrPublishApiClientArticleElement DrPublishApiWebClient::getBodyText()]</h3>
<div class="result">
    <div class="content-container"><?php print($drPublishApiClientArticle->getBodyText()) ?></div>
</div>


<h2>-- Article Meta --</h2>

<h3>Published [DrPublishApiClientArticleElement DrPublishApiWebClient::getPublished()]</h3>
<div class="result">
    <?php print($drPublishApiClientArticle->getPublished()) ?>
</div>

<h3>Modified [DrPublishApiClientArticleElement DrPublishApiWebClient::getModified()]</h3>
<div class="result">
    <?php print($drPublishApiClientArticle->getModified())?>
</div>

<h3>Tags [DrPublishApiClientList DrPublishApiWebClient::getTagNames()]</h3>
<div class="result">
    <?php print($drPublishApiClientArticle->getTags()) ?>
</div>

<h3>DPTags as dedicated DrPublishApiClientTag objects [DrPublishApiClientList
DrPublishApiWebClient::getDPTags()]</h3>
<div class="result">
 <pre>
<?php print(printResult($drPublishApiClientArticle->getDPTags())) ?>
</pre>
</div>

<h3>Categories [DrPublishApiClientList DrPublishApiWebClient::getCategories()]</h3>
<div class="result">
    <?php print($drPublishApiClientArticle->getCategories()) ?>
</div>

<h3>DPCategories as dedicated DrPublishApiClientCategory objects [DrPublishApiClient::getDPCategories()]</h3>
<div class="result">
<pre>
<?php print(printResult($drPublishApiClientArticle->getDPCategories())) ?>
</pre>
</div>

<h3>DPDossiers as dedicated DrPublishApiClientDossier objects [DrPublishApiClient::getDPDossiers()]</h3>
<div class="result">
<pre>
<?php print(printResult($drPublishApiClientArticle->getDPDossiers())) ?>
</pre>
</div>

<h3>Main category [DrPublishApiClientArticleElement DrPublishApiWebClient::getMainCategoryName()]</h3>
<div class="result">
<?php print($drPublishApiClientArticle->getMainDPCategory()) ?>
</div>

<h3>Authors as simple list [DrPublishApiClientList DrPublishApiWebClient::getAuthorNames()]</h3>
<div class="result">
    <?php print($drPublishApiClientArticle->getDPAuthors()) ?>
    <pre>
        <?php print(printResult($drPublishApiClientArticle->getDPAuthors())) ?>
    </pre>
</div>

<h3>Authors as advanced list [DrPublishApiClientList DrPublishApiWebClient::getDPAuthors(true)]. Extended author data are getting fetched by a separate API request</h3>
<div class="result">
    <?php $dpAuthors = $drPublishApiClientArticle->getDPAuthors(true) ?>
    <?php print($dpAuthors) ?>
    <pre>
        <?php print(printResult($dpAuthors)) ?>
    </pre>
</div>

<h3>Source [DrPublishApiClientArticleElement DrPublishApiWebClient::getSourceName()]</h3>
<div class="result">
    <?php print($drPublishApiClientArticle->getSource()) ?>
</div>

<h2>Enrichments</h2>

<h3>DPImages</h3>
<div class="result">
    <h4>All images including wrapping markups [DrPublishApiClientList DrPublishApiWebClient::getDPImages()]</h4>
    <?php $drPublishApiClientImages = $drPublishApiClientArticle->getDPImages(); ?>
    <div class="content-container">
        <?php
        foreach ($drPublishApiClientImages as $drPublishApiClientImage) {
            print "bild!";
            print $drPublishApiClientImage;
            print "<br/> title: " . $drPublishApiClientImage->getTitle();
            print "<br/> description: " . $drPublishApiClientImage->getDescription();
            print "<br/> photographer (simple): " . $drPublishApiClientImage->getPhotographer();
            print "<br/> source: " . $drPublishApiClientImage->getSource();
            print "<br/> url: " . $drPublishApiClientImage->getSrc();
            print "<br/> width: " . $drPublishApiClientImage->getWidth();
            print "<br/> height: " . $drPublishApiClientImage->getHeight();
            print "<br/><br/> photographer (advanced, DrPublishApiClientImage::getDPPhotographer() ";
            print "<pre>";
            print printResult($drPublishApiClientImage->getDPPhotographer());
            print "</pre>";
            print "<hr/>";
        }
        ?>
    <h4>Thumbnails [DrPublishApiWebClientArticleElement
    DrPublishApiWebClientImageElement::getThumbnail(size)]</h4>
        <pre>
<?php
foreach ($drPublishApiClientImages as $drPublishApiClientImageElement) {
    $drPublishApiClientImage = $drPublishApiClientImageElement->getResizedImage(75);
    print printResult($drPublishApiClientImage);
    print ($drPublishApiClientImage);
    print " width=" . $drPublishApiClientImage->getWidth();
    print " src=" . $drPublishApiClientImage->getUrl();
}
?>
        </div>
    </pre>
</div>


<h4>Thumbnails [DrPublishApiWebClientArticleElement
    DrPublishApiWebClientImageElement:getSquareCropResizedImage(&lt;edge length>)]</h4>

<?php
$drPublishApiClientImages = $drPublishApiClientArticle->getDPImages();
foreach ($drPublishApiClientImages as $drPublishApiClientImageElement) {
    $drPublishApiClientImage = $drPublishApiClientImageElement->getSquareCropResizedImage(200);
    print ($drPublishApiClientImage);

}

?>


<h3>Fact Boxes [DrPublishApiClientList DrPublishApiWebClient::getFactBoxes()]</h3>
<div class="result">
    <div class="content-container"><?php print($drPublishApiClientArticle->getFactBoxes()) ?></div>
</div>
<?php print(printSourceCode()) ?>