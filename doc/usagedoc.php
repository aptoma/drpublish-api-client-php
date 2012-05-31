<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>DrPublishWebClient doc</title>
    <script type="text/javascript" src="inc/jquery.js"></script>
    <link type="text/css" rel="stylesheet" media="all" href="inc/docstyles.css" />
    <link type="text/css" rel="stylesheet" media="all" href="inc/toc.css" />
</head>
<body>
<div id="wrapper">


<h1>How to use the Web Client</h1>
    <h3 class="no-sec">Table of contents</h3>
    	<ul class="toc"> </ul>

<h2 id="instantiating">Instantiating the DrPublishApiWebClient</h2>
<code>
require('/path/to/drpublish/api/web/client/lib/' . 'DrPublishWebApiClient.php');
$drPublishApiUrl = 'http://stefan.aptoma.no:9000';
$publicationName = 'Solarius';
$drPublishApiWebClient = new DrPublishApiWebClient($drPublishApiUrl, $publicationName);
</code>


<h2 id="api-request">Sending article search request to the API</h2>
<div class="code-comment">
    Any valid API query as defined in the <a href="apidoc.php">DrPublish API query documentation</a>. <br/>Example: searching all articles with category "nonsense" in decending order:
</div>
<code>
$query = 'title="Lorem ipsum"&category="nonsense"&order=published desc';
</code>
<div class="code-comment">
    DrPublishApiWebClient::searchArticles($query) returns an object of type DrPublishApiClientSearchList, which is a traversable list of article items. In addition this object contains all relevant search meta data.
</div>
<code>
$drPublishApiClientSearchList = $drPublishApiWebClient->searchArticles($query);
</code>

<h2 id="articles">Articles</h2>
<h3 id="article-retrieving">Retrieving article data</h3>
<div class="code-comment">
   The tow ways for accessing articles are
    1.) the search:
</div>
<code>
    $drPublishApiClientSearchList = $drPublishApiWebClient->searchArticles($query);
</code>
<div class="code-comment">
   .. and 2.) the article request by id
</div>
<code>
    $drPublishApiClientSearchList = $drPublishApiWebClient->article(123);
</code>

<h3 id="response-parsing">Parsing the response</h3>
<h4 id="simple-output">Simple output</h4>
    Used for output any article element from API response "like it is". No parsing, no overhead
<code>
$drPublishApiClientSearchList = $drPublishApiWebClient->searchArticles($query);
foreach ($drPublishApiClientSearchList as $drPublishApiWebClientArticle) {
</code>

<div class="code-comment indent1">
   Each article element and article meta data can be fetched by using it's appropriate get method.The return type depends on the nature of the requested element and can be
   <ul>
       <li>a string (Simple meta data, as published date or article id)</li>
       <li>a simple object (advanced meta data)</li>
       <li>a DrPublishApiClientTextElement (plain article content elements)</li>
       <li>a DrPublishApiClientXmlElement (XML/XHTML article content elements)</li>
   </ul>
</div>
<code class="indent1">
$published = $drPublishApiWebClientArticle->getPublished();
$categories = $drPublishApiWebClientArticle->getCategories();
$title = $drPublishApiWebClientArticle->getTitle();
$preamble = $drPublishApiWebClientArticle->getPreamble();
</code>
<code class="indent1">
print $published;
</code>
<div class="output indent1">
    Fri, 10 Feb 2012 15:35:00 +0100
</div>
<code class="indent1">
$someElement = $drPublishWebClientArticle->find('div.foo')->item(0);
print $someElement->content();
print $someElement->innerContent();
print $someElement->html();
print $someElement->innerHtml();
</code>
<div class="code-comment indent1">
While the toString method and the content() method return the complete content including the found element itself, the innerContent() method returns only the content of the element.
The html() and innerHtml() methods return a HTML interpretation of the value returned by content()/innerContent(), which means avoid non-empty tags compliant to W3C standards.
</div>

<div class="output indent1">
    &lt;div class="foo"&gt;This is &lt;strong&gt;really&lt;/strong&gt; important &lt;iframe src="http://somewhere" /&gt; &lt;/div&gt;

    This is &lt;strong&gt;really&lt;/strong&gt; important &lt;iframe src="http://somewhere" /&gt;

    &lt;div class="foo"&gt;This is &lt;strong&gt;really&lt;/strong&gt; important &lt;iframe src="http://somewhere" &gt;&lt;/iframe&gt; &lt;/div&gt;

    This is &lt;strong&gt;really&lt;/strong&gt; important &lt;iframe src="http://somewhere" &gt;&lt;/iframe&gt;

</div>

<div class="code-comment indent1">
   Any returned article element has a toString method (or is a string by itself) and can be outputted directly
</div>
<code class="indent1">
print $preamble;
</code>
<div class="output indent1">
    &lt;strong&gt;Lobaldore&lt;/strong&gt; Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.&lt;i&gt; At vero eos et accusam et justo duo dolores et ea rebum.&lt;/i&gt; Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet
</div>
<code class="code">
 }
</code>


<h4 id="data-extraction">Data extraction</h4>
Advanced use of the output, used on XML/XHTML structured article elements. You can extract any sub-element via querying elements using a <a href="#querying-syntax">jQuery like syntax</a>


<code class="indent">
$drPublisApiWebClientArticle = $drPublishApiClient->getArticle(123);
$story = $drPublisApiWebClientArticle->getStory();
</code>
<div class="code-comment indent">
   Getting the story (body) element from the artilce. The returned element is of type DrPublishApiClientXmlElement.
</div>
<code class="indent">
$drPublishDomElementList = $story->find('a');
</code>
    <div class="code-comment indent">
        DrPublishApiClientXmlElement provides a method "find()" to extracting any element that matches the $query parameter. It returns an object of type
        DrPublishDomElementList which is a collection of DrPublishDomElement objects
    </div>
<code class="indent">
foreach ($drPublishDomElementList as $drPublishDomElement) {
</code>
<div class="code-comment indent1">
    This list can now be traversed by using the for-each construct
</div>
<code class="indent1">
print $drPublishDomElement;
</code>
<div class="output indent1">
    &lt;a href="http://somelink/1"&gt;Jahrhunderte überlebt&lt;a&gt;
</div>
<div class="output indent1">
    &lt;a href="http://somelink/2"&gt;Stet cilt kasd&lt;a&gt;
</div>
<div class="code-comment indent1">
    ...or you can just extract single elements/attributes
</div>
<code class="indent1">
print $drPublishDomElement->getAttribute('href');
</code>
<div class="output indent1">
    http://somelink/1
</div>
<div class="output indent1">
    http://somelink/2
</div>
<code class="code">
}
</code>


<h4 id="querying-syntax">Querying syntax</h4>

<h4 id="replacing-elements">Replacing elements</h4>
<div class="code-comment">
 You can replace any XHTML element in the content using the either DrPublishDomElementList::replaceBy() or DrPublishDomElement::replaceBy().
    <br/>
    Example: Finding all "iframe" elements int the story (body) and replace them with "<b>Foo!</b>"
</div>

<code>
$story = $drPublisApiWebClientArticle->getStory();
$drPublishDomElementList = $story->find('iframe');
$drPublishDomElementList->replaceBy('&lt;b&gt;Foo!&lt;/b&gt;');
</code>

<div class="code-comment">
 Changing the "src" parameter in all image elements of the article:
</div>
<code>
$drPublishDomElementList = $story->find('img');
foreach( $drPublishDomElementList as $drPublishDomElement) {
    $href = $drPublishDomElement->getAttribute('src');
    $newHref = str_replace('http://server1', 'http://newserver', );
    $drPublishDomElement->setAttribute($newHref);
}
</code>
<div class="code-comment">
  Adding the label "external link" to all links in the story element of the article:
</div>
<code>
$links = $drPublishApiClientArticle->getStory()->find('a');
foreach ($links as $link) {
    $newContent =   $link . ' (external link)';
    $link->replaceBy($newContent);
}
</code>

<h4 id="removing-elements">Removing elements</h4>
<div class="code-comment">
 You can remove any XHTML element in the content using the either DrPublishDomElementList::remove() or DrPublishDomElement::remove().
    <br/>
    Example: Removing all images from the article:
</div>
<code>
$drPublishDomElementList = $drPublishApiWebClientArticle->find('img');
$drPublishDomElementList->remove();
</code>
<div class="code-comment">
 Removing all images only from the story (body) field:
</div>
<code>
$drPublishDomElementList = $drPublishApiWebClientArticle->getStory()->find('img');
$drPublishDomElementList->remove();
</code>

<h3 id="article-images">Handle article images</h3>
<div class="code-comment">
 Images including their wrapping markup can be extracted by calling DrPublishApiClientArticle::getDPImages(). The returned list objects of type DrPublishApiClientArticleImageElement
 provide methods for getting all properties of the image as well as the content of the describing elements
</div>
<code>
$drPublishApiClientList = $drPublishApiClient->getDPImages();
$drPublishApiClientArticleImageElement = $drPublishApiClientList->item(0);

// extracting article image properties
print $drPublishApiClientArticleImageElement->getTitle();
print $drPublishApiClientArticleImageElement->getDescription();
print $drPublishApiClientArticleImageElement->getPhotographer();
print $drPublishApiClientArticleImageElement->getSource();
print $drPublishApiClientArticleImageElement->getSrc();
print $drPublishApiClientArticleImageElement->getWidth();
print $drPublishApiClientArticleImageElement->getHeight();
</code>

<div class="code-comment">
 It's also possible only to extract images from one specific article element
</div>
<code>
// extract only images located in the "leadAsset" element of the article
$drPublishApiClientList = $drPublishApiClient->getLeadAsset()->getDPImages();
</code>

<h4 id="article-images">Resizing images on the fly</h4>
<div class="code-comment">
The DrPublishApiClient provides functionality for generating resized images in any format on the fly. Doing this will send a request to the DrPublish image converter service which will check if an image with the requested size already exists. If not, the service will create it and store it on disk.<br/>
    DrPublishApiClient automatically change the appropriate parameters of the image object to match the generated one.
</div>
<code>
$drPublishApiClientList = $drPublishApiClient->getDPImages();
foreach ($drPublishApiClientList as $drPublishApiClientArticleImageElement) {
    $drPublishApiClientArticleImageElement->resizeImage(325);
}
</code>
<h4 id="article-images-slideshows">Slide shows (image galleries)</h4>
<div class="code-comment">
</div>
 You can easily extract and transform slide shows generated by journalists with the help of the DrPublish image app slide show builder.
<br/>
Slide shows can be fetched either global with DrPublishApiClientArticle::getSlideShows() or from just one specific article element by calling  DrPublishApiClientXmlElement::getSlideShows().
<br/>
Now you can build you own HTML/ JavaScript code based on the data from the DrPublishApiClientArticleSlideShowElements and replace the original code.

<code>
// Fetch slide shows from all article elements
$drPublishApiClientSlideShows = $drPublishApiClientArticle->getDPSlideShows();
// or just from from, let's say the leadAsset element
$drPublishApiClientSlideShows = $drPublishApiClientArticle->getLeadAsset()->getDPSlideShows();

foreach ($drPublishApiClientSlideShows as $drPublishApiClientSlideShow) {
    // customize the slide show code
    $yourHtmlCode = doYourStuff($drPublishApiClientSlideShow);
    // replace the original code
    $drPublishApiClientSlideShow->replaceBy($yourHtmlCode);
}

function doYourStuff(DrPublishApiClientArticleSlideShowElement $drPublishApiClientSlideShow)
{
    $slideShowId = $drPublishApiClientSlideShow->getId();
    $dpImages = $drPublishApiClientSlideShow->getDPImages();
    $slideShowImageUrls = array();
    foreach($dpImages as $dpImage) {
        $previewImage = $dpImage->getResizedImage(350);
        $enlargedImage = $dpImage->getResizedImage(950);
        $slideShowImageUrls[] = array(
               'preview' => $previewImage->getUrl(),
               'enlarged' => $enlargedImage->getUrl()
            );
    }
    $jsonImageUrls = json_encode($slideShowImageUrls);
    $out = "&lt;div id=\"{$slideShowId}\"&gt;";
    $out .= "&lt;script type=\"text/javascript\"&gt;";
    $out .= "SlideShow.init('{$slideShowId}', {$jsonImageUrls})";
    $out .= "&lt;/script&gt;";
    $out .= "&lt;/div&gt;";
    return $out;
}
</code>

<h3 id="article-preview">Article preview, including unpublished changes</h3>
<div class="code-comment">
Use the DrPublishApiClient::articlePreview() for previewing articles. This method will run either one or two requests to the API, dependent on if the article
has unpublished changes or not. <br/>
First call goes to the internal data core to check if there exists an article with unpublished changes. If so, the changed article will be returned. </br>
When no article data can be found in the internal core (the article has probably been published or re-published), the public core will be requested. <br/>
If the article can't be found there neither, a DrPublishApiClientExceptions will be thrown.
</div>
<code>
$apiKey = 'DREF12FU78PAUYYI9902E474';
$apiUrl = 'http://stefan.aptoma.no:9000';
$internalScopeApiUrl = 'https://stefan.aptoma.no:9443';
$drPublishApiWebClient = new DrPublishApiClient($apiUrl, 'Solarius');
$drPublishApiWebClient->articlePreview(12345, $apiKey, $internalScopeUrl);
</code>

<h3 id="internal-articles">Accessing unpublished articles for internal use</h3>
<div class="code-comment">
 Internal data can be accessed via HTTPS and the use of an API key. This key can be generated for any user in the DrPublish account admin area.<br/>
 The default address of the internal scope is: <strong>https://your-host:9443</strong>, but the address/port may differ from this dependent on your server setup. Please ask your system administrator.
</div>
<code>
$apiKey = 'DREF12FU78PAUYYI9902E474';
$internalScopeUrl = 'https://stefan.aptoma.no:9443';
$internalScopeClient = $drPublishApiWebClient->internalScopeClient($apiKey, $internalScopeUrl);
$drPublishApiClientSearchList = $internalScopeClient->searchArticles($query);
$drPubishApiClientArticle = $internalScopeClient->getArticle(23422);
</code>
<div class="code-comment">
 $internalScopeClient in the example above is a secured instance of DrPublishApiClient, thus it includes all its functionality but the data will be accessed in an encrypted way.
</div>


<h2 id="authors">Authors</h2>
<div class="code-comment">
    Request a list of authors or fetch a specific author by its id:
</div>
<code>
$drPublishApiClientSearchList = $drPublishApiClient->searchAuthors('username=mschulze');
$drPublishApiClientAuthor = $drPublishApiClient->getAuthor(123);
</code>
<div class="code-comment">
 For processing a search result, the received DrPublishApiClientSearchList can be traversed as a list of DrPublishApiClientAuthor objects
   Use the appropriate getter method og access the properties of a DrPublishApiClientAuthor object.
</div>
<code>
foreach($drPublishApiClientSearchList as $drPublishApiClientAuthor) {
    $fullName = $drPublishApiClientAuthor->getFullName();
}
</code>

<h2 id="categories">Categories</h2>
<div class="code-comment">
    You can either request a list of categories by sending a search query or request a specific category by id:
</div>
<code>
$drPublishApiClientSearchList = $drPublishApiClient->searchCategories('parentId=2');
$drPublishApiClientCategory = $drPublishApiClient->getCategory(234);
</code>
<div class="code-comment">
 For processing a search result, the received DrPublishApiClientSearchList can be traversed as a list of DrPublishApiClientCategory objects
   Use the appropriate getter method og access the properties of a category object.
</div>
<code>
foreach($drPublishApiClientSearchList as $drPublishApiClientCategory) {
    $categoryName = $drPublishApiClientCategory->getName();
    $categoryParentName = $drPublishApiClientCategory->getParentName();
}
</code>

<h2 id="tags">Tags</h2>
<div class="code-comment">
    Same procedure as for <a href=#categories">categories</a>, apart from the the objects are of type DrPublishApiClientTag
</div>
<code>
$drPublishApiClientSearchList = $drPublishApiClient->searchTag('name=Sports');
$drPublishApiClientTag = $drPublishApiClient->getTag(362);
</code>
<div class="code-comment">
 For processing a search result, the received DrPublishApiClientSearchList can be traversed as a list of DrPublishApiClientTag objects
   Use the appropriate getter method og access the properties of a DrPublishApiTag object.
</div>
<code>
foreach($drPublishApiClientSearchList as $drPublishApiClientTag) {
    $tagName = $drPublishApiClientTag->getName();
}
</code>

<h2 id="dossiers">Dossiers</h2>
<div class="code-comment">
    Same procedure as for <a href=#categories">categories</a>, apart from the the objects are of type DrPublishApiClientDossier
</div>
<code>
$drPublishApiClientSearchList = $drPublishApiClient->searchDossier('parentId=9876');
$drPublishApiClientDossier = $drPublishApiClient->getDossier(76);
</code>
<div class="code-comment">
 For processing a search result, the received DrPublishApiClientSearchList can be traversed as a list of DrPublishApiClientDossier objects
   Use the appropriate getter method og access the properties of a dossier object.
</div>
<code>
foreach($drPublishApiClientSearchList as $drPublishApiClientTag) {
    $tagName = $drPublishApiClientTag->getName();
}
</code>


<h2 id="sources">Sources</h2>
<div class="code-comment">
    Same procedure as for <a href=#categories">categories</a>, apart from the the objects are of type DrPublishApiClientSource
    <br/>See <a href="apidoc.php#sources" target="_blank">API doc</a> for available search options
</div>
<code>
$drPublishApiClientSearchList = $drPublishApiClient->searchSource('name=NTB');
$drPublishApiClientSource = $drPublishApiClient->getSource(76);
</code>
<div class="code-comment">
 For processing a search result, the received DrPublishApiClientSearchList can be traversed as a list of DrPublishApiClientSource objects
   Use the appropriate getter method og access the properties of a DrPublishApiClientSource object.
</div>
<code>
foreach($drPublishApiClientSearchList as $drPublishApiClientTag) {
    $tagName = $drPublishApiClientTag->getName();
}
</code>

<h2 id="error-handling">Error handling</h2>
<div class="code-comment">
    Several methods in DrPublishApiClient may throw an exception of type <strong>DrPublishApiClientException</strong>. This object contains the information
    <ul>
        <li>Error type</li>
        <li>Error message</li>
        <li>Request URL that provoked the error</li>
    </ul>
</div>

<code>
try {
    $drpublishApiClientArticle = $drPublishApiClient->getArticle(123);
} catch (DrpublishApiClientException $e) {
    $message = $e->getMessage();
    $errorCode = $e->getCause();
    $requestUrl = $e->getRequestUrl();
    $this->myErrorHandler($message, $errorCode, $requestUrl);
}
</code>

<div class="code-comment">
    Non-critical errors trigger a PHP warning (E_USER_WARNING)
</div>





</div>
<script type="text/javascript">
    $(document).ready(function () {
         var h = [0, 0, 0, 0, 0], i, s, level, toc = $('.toc');
         $('h2, h3, h4').each(function () {
             if (!$(this).hasClass('no-sec')) {
                 s = [];
                 level = this.nodeName.match(/H([2-6])/)[1] - 2;
                 h[level]++;
                 for (i = 0; i < h.length; i++) {
                     if (i > level) {
                             h[i] = 0;
                     } else {
                             s.push(h[i]);
                     }
                 }
                 $(this).html('<span class="secnum">' + s.join('.') + '</span><a href="#' + this.id + '">' + $(this).text() + '</a>');
                 $(toc).append(
                    $('<li>' + $(this).html() + '</li>').find('span').css('width', (4 + level) + 'em').end()
                 );
             }
         });

         $('.example-code').each(function () {
                 elem = $(this);
         });
     });
</script>
</body>
</html>