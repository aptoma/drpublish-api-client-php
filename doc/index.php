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


<h1>DrPublishAPIClient</h1>
<!--
    <h2 class="no-sec">Table of contents</h2>
    	<ul class="toc"> </ul>

-->

</div>

<a href="https://github.com/aptoma/no.aptoma.drpublish.api.client.php" target="_blank">Download the API client from GitHub</a>
<br/>
<a href="usagedoc.php">How to use the API client</a>
<br/>
<a href="apidoc.php">API request documentation</a>
<br/>
<a href="example/">The example client application. Try it out!</a>


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