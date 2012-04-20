<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
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

<h2>Instantiating the DrPublishApiWebClient</h2>
<pre class="code">
require('/path/to/drpublish/api/web/client/lib/' . 'DrPublishWebApiClient.php');
$drPublishApiUrl = 'http://stefan.aptoma.no:9000';
$publicationName = 'Solarius';
$drPublishApiWebClient = new DrPublishApiWebClient($drPublishApiUrl, $publicationName);
</pre>


<h2>Sending article search request to API</h2>

<pre class="code">
$query = 'title="Lorem ipsum"&category="nonsense"&order=published desc';
</pre>
<div class="code-comment">
    Any valid API query as defined in the <a href="apidoc.php">DrPublish API query documentation</a>
</div>
<pre class="code">
$drPublishApiClientSearchList = $drPublishApiWebClient->searchArticles($query);
</pre>
<div class="code-comment">
    DrPublishApiWebClient::searchArticles($query) returns an object of type DrPublishApiClientSearchList, which is a traversable list of article items. In addition this object contains all relevant search meta data.
</div>

<h2>Parsing the response</h2>

<h3>Simple output</h3>
<pre class="code">
foreach ($drPublishApiClientSearchList as $drPublisApiWebClientArticle) {
</pre>

<pre class="code indent1">
$published = $drPublisApiWebClientArticle->getPublished();
$categories = $drPublisApiWebClientArticle->getCategories();
$title = $drPublisApiWebClientArticle->getTitle();
$preamble = $drPublisApiWebClientArticle->getPreamble();
</pre>
<div class="code-comment indent1">
   Each article element and article meta data can be fetched by using it's appropriate get method.The return type depends on the nature of the requested element and can be
           <ul>
               <li>a string (Simple meta data, as published date or article id)</li>
               <li>a simple object (advanced meta data)</li>
               <li>a DrPublishApiClientTextElement (plain article content elements)</li>
               <li>a DrPublishApiClientXmlElement (XML/XHTML article content elements)</li>
           </ul>
</div>
<pre class="code indent1">
print $published;
</pre>
<div class="output indent1">
    Fri, 10 Feb 2012 15:35:00 +0100
</div>

<pre class="code indent1">
print $preamble;
</pre>
<div class="output indent1">
    <strong>Lobaldore</strong> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<i> At vero eos et accusam et justo duo dolores et ea rebum.</i> Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet
</div>
<div class="code-comment indent1">
   Any returned article element has a toString method (or is a string by itself) and can be outputted directly
</div>
<pre class="code">
 }
</pre>


<h3>Data extraction</h3>
<pre class="code">
foreach ($drPublishApiClientSearchList as $drPublisApiWebClientArticle) {
</pre>

<pre class="code">
 }
</pre>




</div>

<script type="text/javascript">
    $(document).ready(function () {
             var h = [0, 0, 0, 0, 0], i, s, level, toc = $('.toc');
             $('h2, h3').each(function () {
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