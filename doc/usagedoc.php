<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>DrPublishWebClient doc</title>
    <script type="text/javascript" src="inc/jquery.min.js"></script>
    <link type="text/css" rel="stylesheet" media="all" href="inc/docstyles.css" />
    <link type="text/css" rel="stylesheet" media="all" href="inc/toc.css" />
</head>
<body>
<div id="wrapper">


<h1>How to use the Web Client</h1>
    <h2 class="no-sec">Table of contents</h2>
    	<ul class="toc"> </ul>

<h2 id="instantiating">Instantiating the DrPublishApiWebClient</h2>
<code>
require('/path/to/drpublish/api/web/client/lib/' . 'DrPublishWebApiClient.php');
$drPublishApiUrl = 'http://stefan.aptoma.no:9000';
$publicationName = 'Solarius';
$drPublishApiWebClient = new DrPublishApiWebClient($drPublishApiUrl, $publicationName);
</code>


<h2 id="api-request">Sending article search request to API</h2>
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

<h2 id="response-parsing">Parsing the response</h2>
<h3 id="simple-output">Simple output</h3>
    Used for output any article element from API resonste "like it is". No parsing, no overhead
<code>
foreach ($drPublishApiClientSearchList as $drPublisApiWebClientArticle) {
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
$published = $drPublisApiWebClientArticle->getPublished();
$categories = $drPublisApiWebClientArticle->getCategories();
$title = $drPublisApiWebClientArticle->getTitle();
$preamble = $drPublisApiWebClientArticle->getcodeamble();
</code>
<code class="indent1">
print $published;
</code>
<div class="output indent1">
    Fri, 10 Feb 2012 15:35:00 +0100
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


<h3 id="data-extraction">Data extraction</h3>
Advanced use of the output, used on XML/XHTML structured article elements. You can extract any sub-element via querying elements using a <a href="#querying-syntax">jQuery like syntax</a>
<code>
foreach ($drPublishApiClientSearchList as $drPublisApiWebClientArticle) {
</code>

<code class="indent1">
$story = $drPublisApiWebClientArticle->getStory();
</code>
<div class="code-comment indent1">
   Getting the story (body) element from the artilce. The returned element is of type DrPublishApiClientXmlElement.
</div>
<code class="indent1">
$drPublishDomElementList = $story->find('a');
</code>
    <div class="code-comment indent1">
        DrPublishApiClientXmlElement provides a method "find()" to extracting any element that matches the $query parameter. It returns an object of type
        DrPublishDomElementList which is a collection of DrPublishDomElement objects
    </div>
<code class="indent1">
foreach ($drPublishDomElementList as $drPublishDomElement) {
</code>
<div class="code-comment indent2">
    This list can now be traversed by using the for-each construct
</div>
<code class="indent2">
print $drPublishDomElement;
</code>
<div class="output indent2">
    &lt;a href="http://somelink/1"&gt;Jahrhunderte überlebt&lt;a&gt;
</div>
<div class="output indent2">
    &lt;a href="http://somelink/2"&gt;Stet cilt kasd&lt;a&gt;
</div>
<div class="code-comment indent2">
    ...or you can just extract single elements/attributes
</div>
<code class="indent2">
print $drPublishDomElement->getAttribute('href');
</code>
<div class="output indent2">
    http://somelink/1
</div>
<div class="output indent2">
    http://somelink/2
</div>

<code class="indent1">
}
</code>

<code class="code">
}
</code>

<h4 id="querying-syntax">Querying syntax</h4>

<h3 id="replacing-elements">Replacing elements</h3>
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
$links = $drpublishApiClientArticle->getStory()->find('a');
foreach ($links as $link) {
    $newContent =   $link . ' (external link)';
    $link->replaceBy($newContent);
}
</code>



<h3 id="removing-elements">Removing elements</h3>
<div class="code-comment">
 You can remove any XHTML element in the content using the either DrPublishDomElementList::remove() or DrPublishDomElement::remove().
    <br/>
    Example: Removing all images from the article:
</div>
<code>
$drPublishDomElementList = $drPublisApiWebClientArticle->find('img');
$drPublishDomElementList->remove();
</code>
<div class="code-comment">
 Removing all images only from the story (body) field:
</div>
<code>
$drPublishDomElementList = $drPublisApiWebClientArticle->getStory()->find('img');
$drPublishDomElementList->remove();
</code>



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