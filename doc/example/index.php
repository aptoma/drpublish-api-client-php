<?
if (file_exists(dirname(__FILE__) . '/config.php')) {
    $configs = array();
    include (dirname(__FILE__) . '/config.php');
    $dpUrl = $configs['dp-url'];
    $dpUrlInternal = $configs['dp-url-internal'];
    $publication = $configs['publication'];
    $apikey = $configs['apikey'];
} else {
    $dpUrl = 'http://stefan.aptoma.no:9000';
    $dpUrlInternal = 'https://stefan.aptoma.no:9443';
    $publication = 'Solarius';
    $apikey = '';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>DrPublisch API client example implementation</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <script type="text/javascript" src="inc/jquery.min.js"></script>
    <script type="text/javascript" src="inc/DrPublishApiClientExample.js"></script>
    <script type="text/javascript">
    </script>
    <link type="text/css" rel="stylesheet" media="all" href="../inc/toc.css"/>
    <link type="text/css" rel="stylesheet" media="all" href="inc/styles.css"/>
</head>
<body>
<h1>DrPublishApiClient example implementation</h1>

<div id="global-properties">
    Public API URL
    <input type="text" id="dp-url" name="dp-url" value="<?=$dpUrl?>" style="width: 300px"/>
    Internal API URL
    <input type="text" id="dp-url-internal" name="dp-url-url" value="<?=$dpUrlInternal?>" style="width: 300px"/>
    <br/>
    Publication
    <input type="text" id="dp-publication" name="dp-publication" value="<?=$publication?>" style="width: 100px"/>
    API key
        <input type="text" id="dp-apikey" name="dp-apikey" value="<?=$apikey?>" style="width: 200px"/>
</div>
<div id="active-form">
    <fieldset>
        <legend>Search articles</legend>
        <form action="search">
            <? printSelectex('', 'title') ?>
            <? printLimit(true) ?>
            <? printSubmit(true) ?>
            <? printApiDocLink('articles') ?>
        </form>
    </fieldset>
    <fieldset>
        <legend>Get article</legend>
        <form action="article">
            Article id:
            <input type="text" value="" name="article-id" style="width: 80px"/>
            <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Show article"/>
            <? printApiDocLink('article') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Search authors</legend>
        <form action="search-authors">
            <? printSelectex('users', 'fullname') ?>
            <? printLimit() ?>
            <? printSubmit() ?>
            <? printApiDocLink('users') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Get author</legend>
        <form action="author">
            Author id: <input type="text" value="1" name="author-id" style="width: 80px"/>
            <br/><br/>
            <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Show author"/>
            <? printApiDocLink('user') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Search tags</legend>
        <form action="search-tags">
            <? printSelectex('tags', 'name') ?>
            <? printLimit() ?>
            <? printSubmit() ?>
            <? printApiDocLink('tags') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Get tag</legend>
        <form action="tag">
            Tag id: <input type="text" name="tag-id" style="width: 80px"/>
            <br/><br/>
            <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Show tag"/>
            <? printApiDocLink('tag') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Search categories</legend>
        <form action="search-categories">
            <? printSelectex('categories', 'name') ?>
            <? printLimit() ?>
            <? printSubmit() ?>
            <? printApiDocLink('category') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Get category</legend>
        <form action="category">
            Category id: <input type="text" name="category-id" style="width: 80px"/>
            <br/><br/>
            <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Show category"/>
            <? printApiDocLink('category') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Search dossiers</legend>
        <form action="search-dossiers">
            <? printSelectex('dossiers', 'name') ?>
            <? printLimit() ?>
            <? printSubmit() ?>
            <? printApiDocLink('dossiers') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Get dossier</legend>
        <form action="dossier">
            Dossier id: <input type="text" name="dossier-id" style="width: 80px"/>
            <br/><br/>
            <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Show dossier"/>
            <? printApiDocLink('dossier') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Search sources</legend>
        <form action="search-sources">
            <? printSelectex('sources', 'name') ?>
            <? printLimit() ?>
            <? printSubmit() ?>
            <? printApiDocLink('sources') ?>
        </form>
    </fieldset>

    <fieldset>
        <legend>Get source</legend>
        <form action="source">
            <input type="text" name="source-id" style="width: 80px"/>
            <br/><br/>
            <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" val="Show source"/>
            <? printApiDocLink('source') ?>
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
</body>
</html>

<?
function printSelectex($name, $defaultField = "-- fulltext --", $defaultFieldDataType = 'string')
{
    ?>
<div class="selectex">
    <div class="labels">
        <div>Filter field</div>
        <div>Search query</div>
    </div>
    <div class="row first">
        <select class="field-name" name="filterFields[1][key]" size="1" data-core='<?=$name?>'>
            <option class="default-field"><?=$defaultField ?></option>
        </select>
        <span class="type"><?=$defaultFieldDataType?></span>
        <input type="text" name="filterFields[1][value]"/>

        <div class="plus">+</div>
        <div class="minus">-</div>
    </div>
</div>
<?
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
<? if ($showOrder) { ?>
Order:
<select name="order" size="1">
    <option>--relevance--</option>
    <option>published asc</option>
    <option>published desc</option>
    <option>modified asc</option>
    <option>modified desc</option>
</select>
<? } ?>
<br/><br/>
<?
}

function printApiDocLink($item)
{
    ?>
<div class="doclinks">
<a href="../apidoc.php#<?=$item?>" target="_blank">API documentation</a>
    &nbsp;
<a href="../usagedoc.php#<?=$item?>" target="_blank">How to process the retrieved data</a>
</div>
<? }

function printSubmit($providesInternalSearch)
{ ?>
<div class="submit-div">
<? if (0 and $providesInternalSearch) { ?>
        Request the internal core <input type="radio" name="internal" value="0" checked="checked" />no <input type="radio" name="internal" value="1" />yes
<? } ?>
<input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Search"/>
</div>
<? }
