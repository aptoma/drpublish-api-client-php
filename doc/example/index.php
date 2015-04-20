<?php
if (file_exists(dirname(__FILE__) . '/config.php')) {
    $configs = array();
    include (dirname(__FILE__) . '/config.php');
    $dpUrl = $configs['dp-url'];
    $dpUrlInternal = $configs['dp-url-internal'];
    $publication = $configs['publication'];
    $apikey = $configs['apikey'];
} else {
    $dpUrl = 'http://drlib-dev.aptoma.no';
    $dpUrlInternal = 'https://drlib-dev.aptoma.no:443';
    $publication = 'Solarius';
    $apikey = '';
    $apikey = '';
}
$headless = isset($_GET['headless']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DrPublish API client example implementation</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <script src="../inc/jquery-2.1.0.min.js"></script>
    <script src="../inc/prism.js"></script>
    <script src="../inc/bootstrap.min.js"></script>
    <script src="inc/DrPublishApiClientExample.js"></script>
    <link rel="stylesheet" href="../inc/bootstrap.min.css" />
    <link rel="stylesheet" href="../inc/prism.css"/>
    <link type="text/css" rel="stylesheet" media="all" href="../inc/type.css"/>
    <link type="text/css" rel="stylesheet" media="all" href="../inc/docstyles.css"/>
    <link type="text/css" rel="stylesheet" media="all" href="inc/styles.css"/>
</head>
<body class="<?=$headless? 'headless' : ''?>">
<? if (!$headless) { ?>
    <nav class="navbar">
        <div class="app-name">API Client</div>
        <ul class="nav">
            <li><a href="../usagedoc.php">PHP API Client Doc</a></li>
            <li><a href="../apidoc.php">API Request Doc</a></li>
            <li class="active"><a href="./">API Playground</a></li>
            <li><a href="https://github.com/aptoma/no.aptoma.drpublish.api.client.php" target="_blank">Download the API client from GitHub</a></li>
        </ul>
    </nav>
<? } ?>
<div id="outer">
<div id="global-properties">
    Public API URL
    <input type="text" id="dp-url" name="dp-url" value="<?php print($dpUrl) ?>" style="width: 300px"/>
    Internal API URL
    <input type="text" id="dp-url-internal" name="dp-url-internal" value="<?php print($dpUrlInternal)?>" style="width: 300px"/>
    <br/>
    Publication
    <input type="text" id="dp-publication" name="dp-publication" value="<?php print($publication)?>" style="width: 100px"/>
    API key
    <input type="text" id="dp-apikey" name="dp-apikey" value="<?php print($apikey)?>" style="width: 200px"/>
</div>
<div id="active-form">
    <fieldset>
        <legend>Search articles</legend>
        <a href="#" class="active-search search-ui-link" onclick="$(this).parent().find('form').toggle(); $(this).parent().find('a.search-ui-link').toggleClass('active-search');return false;">Query builder</a>
        <a href="#" class="search-ui-link" onclick="$(this).parent().find('form').toggle().find('a'); $(this).parent().find('a.search-ui-link').toggleClass('active-search');return false;">Raw query</a>
        <br/><br/>
        <form action="search" id="search-query-builder">
            <?php printSelectex('', 'title') ?>
            <?php printLimit(true) ?>
            <?php printSubmit(true) ?>
        </form>
        <form action="search" id="search-raw-query" style="display:none">
        <textarea name="raw-query" id="raw-query"></textarea>
        <input type="submit" value="Search" onclick="DrPublishApiClientExample.submitForm(this); return false;"  />
        </form>
        <?php printApiDocLink('articles') ?>
    </fieldset>

    <fieldset>
        <legend>Get article</legend>
        <form action="article">
            Article id:
            <input type="text" value="" name="article-id" id="article-id" style="width: 80px"/>
            <br/>
            <br/>
            Which core shall be requested?
            <br/>
            <input type="radio" name="internal" value="0" checked="checked" />published
            <input type="radio" name="internal" value="1" />internal
            <input type="radio" name="internal" value="2" />both (for article preview)
            <br/>
            <input type="submit" id="search-article-submit" onclick="DrPublishApiClientExample.submitForm(this); return false;" value="Show article"/>
            <?php printApiDocLink('article') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Search authors</legend>
        <form action="search-authors">
            <?php printSelectex('users', 'fullname') ?>
            <?php printLimit() ?>
            <?php printSubmit() ?>
            <?php printApiDocLink('users') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Get author</legend>
        <form action="author">
            Author id: <input type="text" value="1" name="author-id" style="width: 80px"/>
            <br/><br/>
            <input type="submit" onclick="DrPublishApiClientExample.submitForm(this); return false;" value="Show author"/>
            <?php printApiDocLink('user') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Search tags</legend>
        <form action="search-tags">
            <?php printSelectex('tags', 'name') ?>
            <?php printLimit() ?>
            <?php printSubmit() ?>
            <?php printApiDocLink('tags') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Get tag</legend>
        <form action="tag">
            Tag id: <input type="text" name="tag-id" style="width: 80px"/>
            <br/><br/>
            <input type="submit" onclick="DrPublishApiClientExample.submitForm(this); return false;" value="Show tag"/>
            <?php printApiDocLink('tag') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Search categories</legend>
        <form action="search-categories">
            <?php printSelectex('categories', 'name') ?>
            <?php printLimit() ?>
            <?php printSubmit() ?>
            <?php printApiDocLink('category') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Get category</legend>
        <form action="category">
            Category id: <input type="text" name="category-id" style="width: 80px"/>
            <br/><br/>
            <input type="submit" onclick="DrPublishApiClientExample.submitForm(this); return false;" value="Show category"/>
            <?php printApiDocLink('category') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Search sources</legend>
        <form action="search-sources">
            <?php printSelectex('sources', 'name') ?>
            <?php printLimit() ?>
            <?php printSubmit() ?>
            <?php printApiDocLink('sources') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Get source</legend>
        <form action="source">
            <input type="text" name="source-id" style="width: 80px"/>
            <br/><br/>
            <input type="submit" onclick="DrPublishApiClientExample.submitForm(this); return false;" val="Show source"/>
            <?php printApiDocLink('source') ?>
        </form>
    </fieldset>
</div>
<div id="form-pool">

</div>
<div style="clear: both"></div>
<div id="api-response-wrap">
    <div id="api-response">
    </div>
</div>
</div>
</body>
</html>

<?php
function printSelectex($name, $defaultField = "-- fulltext --", $defaultFieldDataType = 'string')
{
    ?>
<div class="selectex">
    <div class="labels">
        <div>Filter field</div>
        <div>Search query</div>
    </div>
    <div class="selrow first">
        <select class="field-name" name="filterFields[1][key]" size="1" data-core='<?php print($name)?>'>
            <option class="default-field"><?php print($defaultField) ?></option>
        </select>
        <span class="type"><?php print($defaultFieldDataType)?></span>
        <input type="text" name="filterFields[1][value]"/>

        <div class="plus">+</div>
        <div class="minus">-</div>
    </div>
</div>
<?php
}

function printLimit($showOrder = false)
{
    ?>
<span class="condition">
Condition: <select class="condition-type" name="conditionType" size="1">
    <option>AND</option>
    <option>OR</option>
</select>
</span>
Offset:<input type="text" name="offset" value="0" style="width: 20px"/>
Limit:<input type="text" name="limit" value="5" style="width: 20px"/>
<?php if ($showOrder) { ?>
Order:
<select name="order" size="1">
    <option>--relevance--</option>
    <option>published asc</option>
    <option>published desc</option>
    <option>modified asc</option>
    <option>modified desc</option>
</select>
<?php } ?>
<br/><br/>
<?php
}

function printApiDocLink($item)
{
    ?>
<div class="doclinks">
<a href="../apidoc.php#<?php print($item) ?>" target="_blank">API documentation</a>
    &nbsp;
<a href="../usagedoc.php#<?php print($item) ?>" target="_blank">How to process the retrieved data</a>
</div>
<?php }

function printSubmit($providesInternalSearch = false)
{ ?>
<div class="submit-div">
<?php if ($providesInternalSearch) { ?>
        <input type="radio" name="internal" value="0" checked="checked" />published <input type="radio" name="internal" value="1" />internal &nbsp;
<?php } ?>
<input type="submit" onclick="DrPublishApiClientExample.submitForm(this); return false;" value="Search"/>
</div>
<?php }
