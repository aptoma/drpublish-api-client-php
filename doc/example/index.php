<?
if (file_exists(dirname(__FILE__).'/config.php')) {
    $configs = array();
    include (dirname(__FILE__).'/config.php');
    $dpUrl = $configs['dp-url'];
    $publication = $configs['publication'];
} else {
    $dpUrl = 'http://stefan.aptoma.no:9000';
    $publication = 'Solarius';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>Web client test</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="inc/jquery.min.js"></script>
    <script type="text/javascript" src="inc/DrPublishApiClientExample.js"></script>
    <script type="text/javascript">
    </script>
    <link type="text/css" rel="stylesheet" media="all" href="../inc/toc.css" />
    <link type="text/css" rel="stylesheet" media="all" href="inc/styles.css" />
</head>
<body>
<h1>DrPublishApiClient example implementation</h1>

<div id="global-properties">
    DrPublish API URL
      <input type="text"  id="dp-url" name="dp-url" value="<?=$dpUrl?>" style="width: 300px"/>
    Publication
       <input type="text"  id="dp-publication" name="dp-publication" value="<?=$publication?>" style="width: 100px" />
</div>
<div id="active-form">
    <fieldset>

        <legend>Search articles</legend>
       <form action="search">
           <? printSelectex('', 'title') ?>
           <? printLimit(true) ?>
            <input type="submit" name="run-search" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Search" />
           See <a href="../apidoc.php" target="_blank">API doc</a> for available search options
        </form>
    </fieldset>
</div>
<div id="form-pool">
    <fieldset>
        <legend>Get article</legend>
        <form action="article">
        Article id:
        <input type="text" value="" name="article-id" style="width: 80px" />
        <input type="submit"  onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Show article" />
         </form>
    </fieldset>

    <fieldset>
        <legend>Search authors</legend>
        <form action="search-authors">
            <? printSelectex('users', 'fullname') ?>
            <? printLimit() ?>
           <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Search" />
         </form>
    </fieldset>

    <fieldset>
        <legend>Get author</legend>
        <form action="author" >
            Author id: <input type="text" value="1" name="author-id" style="width: 80px" />
            <br/><br/>
           <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Show author" />
         </form>
    </fieldset>

    <fieldset>
        <legend>Search tags</legend>
        <form action="search-tags">
            <? printSelectex('tags', 'name') ?>
            <? printLimit() ?>
           <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Search" />
         </form>
     </fieldset>

    <fieldset>
        <legend>Get tag</legend>
        <form action="tag">
            Tag id: <input type="text"  name="tag-id" style="width: 80px" />
            <br/><br/>
           <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Show tag" />
         </form>
    </fieldset>

    <fieldset>
        <legend>Search categories</legend>
        <form action="search-categories">
            <? printSelectex('categories', 'name') ?>
           <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Search" />
         </form>
     </fieldset>

    <fieldset>
        <legend>Get category</legend>
        <form action="category">
            Category id: <input type="text"  name="category-id" style="width: 80px" />
            <br/><br/>
           <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Show category" />
         </form>
    </fieldset>

    <fieldset>
        <legend>Search dossiers</legend>
        <form action="search-dossiers">
            <? printSelectex('dossiers', 'name') ?>
            <? printLimit() ?>
           <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Search" />
         </form>
     </fieldset>

    <fieldset>
        <legend>Get dossier</legend>
        <form action="dossier">
            Dossier id: <input type="text"  name="dossier-id" style="width: 80px" />
            <br/><br/>
           <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Show dossier" />
         </form>
    </fieldset>

    <fieldset>
        <legend>Search sources</legend>
        <form action="search-sources">
            <? printSelectex('sources', 'name') ?>
            <? printLimit() ?>
           <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" value="Search" />
         </form>
     </fieldset>

    <fieldset>
        <legend>Get source</legend>
        <form action="source">
            <input type="text"  name="source-id" style="width: 80px" />
            <br/><br/>
           <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" val="Show source" />
         </form>
    </fieldset>
</div>
<div style="clear: both"></div>
<div id="api-response-wrap">
    <div id="api-response">
    </div>
</div>
</body>
</html>

<?
function printSelectex($name, $defaultField = "-- fulltext --")
{ ?>
<div class="selectex">
  <div class="labels">
      <div>Filter field</div>
      <div>Search query</div>
  </div>
  <div class="row first">
      <select class="condition-type" name="filterFields[1][condition]" size="1">
            <option>AND</option>
            <option>OR</option>
       </select>
       <select class="field-name" name="filterFields[1][key]" size="1" data-core='<?=$name?>'>
             <option class="default-field"><?=$defaultField ?></option>
        </select>
       <input type="text" name="filterFields[1][value]" />
       <div class="plus">+</div>
       <div class="minus">-</div>
   </div>
</div>
 <?
}
function printLimit($showOrder = false) { ?>
Offset:<input type="text" name="offset" value="0" style="width: 40px"/>
Limit:<input type="text" name="limit" value="5" style="width: 40px"/>
<? if ($showOrder) { ?>
Sort by:
<select name="order" size="1">
    <option>--relevance--</option>
    <option>published asc</option>
    <option>published desc</option>
    <option>modified asc</option>
    <option>modified desc</option>
</select>
<? } ?>
<br/><br/>
<? }