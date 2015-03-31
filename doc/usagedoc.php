<?php
$headless = isset($_GET['headless']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>DrPublishWebClient doc</title>
    <script type="text/javascript" src="inc/jquery-2.1.0.min.js"></script>
    <script src="inc/bootstrap.min.js"></script>
    <script type="text/javascript" src="inc/prism.js"></script>
    <link rel="stylesheet" href="inc/bootstrap.min.css"/>
    <link rel="stylesheet" href="inc/prism.css"/>
    <link rel="stylesheet" href="inc/type.css"/>
    <link rel="stylesheet" href="inc/docstyles.css" type="text/css" media="all" charset="utf-8" />
</head>
<body class="<?=$headless ? 'headless':''?> language-php">
<? if (!$headless) { ?>
<nav class="navbar">
    <div class="app-name">API Client</div>
    <ul class="nav">
        <li class="active"><a href="usagedoc.php">PHP API Client Doc</a></li>
        <li><a href="apidoc.php">API Request Doc</a></li>
        <li><a href="example/">API Playground</a></li>
        <li><a href="https://github.com/aptoma/no.aptoma.drpublish.api.client.php" target="_blank">Download the API client from GitHub</a></li>
    </ul>
</nav>
<? } ?>
<div id="wrapper" class="doc-wrapper">
    <h2 class="no-sec">Table of contents</h2>
    <ul class="toc"></ul>

    <?php include 'usagedoc_contents.html' ?>

</div>
<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            // Open all links in content in tab
            $('.doc-wrapper a').attr('target', '_blank');

            var currentLevel;
            var headerLevelCounts = [0, 0, 0, 0, 0];
            var $toc = $('.toc');
            $('h2, h3, h4, h5').not('.no-sec').each(function () {
                var i;
                currentLevel = this.nodeName.match(/H([2-6])/)[1] - 2;
                headerLevelCounts[currentLevel]++;
                for (i = 0; i < headerLevelCounts.length; i++) {
                    if (i > currentLevel) {
                        headerLevelCounts[i] = 0;
                    }
                }

                $(this).html('<a href="#' + generateId(this) + '">' + $(this).html() + '</a>');
                $toc.append(
                    $('<li>' + $(this).html() + '</li>').addClass('level-' + currentLevel)
                );
            });

            function generateId(elem) {
                if (!elem.id) {
                    elem.id = slugify($(elem).text()) + '-' + (1 + currentLevel) + '-' + headerLevelCounts[currentLevel];
                }

                return elem.id;
            }

            function slugify(text) {
                return text.toLowerCase().replace(/[^a-z0-9]/g, '-');
            }
        });
    }(jQuery));
</script>
</body>
</html>
