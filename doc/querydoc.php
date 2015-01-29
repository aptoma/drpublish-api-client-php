<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>DrPublishWebClient doc</title>
    <script type="text/javascript" src="inc/jquery-2.1.0.min.js"></script>
    <script src="inc/bootstrap.min.js"></script>
    <link rel="stylesheet" href="inc/bootstrap.min.css"/>
    <link rel="stylesheet" href="inc/docstyles.css" type="text/css" media="all" charset="utf-8" />
</head>
<body>
<div id="wrapper">

<h1>/ <a href="index.php">API client doc</a> / how to query the API - best practices</h1>
    <h3 class="no-sec">Table of contents</h3>
    	<ul class="toc"> </ul>

<h2 id="foo">foo</h2>
    <h3 id="foobar">foobar</h3>
<code>
    q=bar*
</code>

<div class="code-comment">
    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
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