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
    <link type="text/css" rel="stylesheet" media="all" href="inc/styles.css" />
</head>
<body>
    DrPublish API URL
      <input type="text" value="" id="dp-url" name="dp-url" style="width: 300px"/>
    Publication
       <input type="text" value="" id="dp-publication" name="dp-publication" style="width: 100px" />
<hr/>
        <fieldset>
            <legend>Search articles</legend>
           <form action="search">
            <span style="vertical-align: top;">Search query:</span>
                <textarea name="query"></textarea>
            <br/>
                Offset:<input type="text" name="offset" value="0" style="width: 40px"/>
                Limit:<input type="text" name="limit" value="5" style="width: 40px"/>
                <br/><br/>
                <button name="run-search" onclick="DrPublishApiClientExmample.submitForm(this); return false;">Search</button>
            </form>

        </fieldset>

        <fieldset>
            <legend>Get article</legend>
            <form action="article">
            Article id:
            <input type="text" value="" name="article-id" style="width: 80px" />
            <button name="run-article"  onclick="DrPublishApiClientExmample.submitForm(this); return false;">Show article</button>
             </form>
        </fieldset>

        <fieldset>
            <legend>Search Authors</legend>
            <form action="search-authors">
             <span style="vertical-align: top;">Search query:</span>
                 <textarea name="query"></textarea>
              <br/>
                <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" val="Search" />
             </form>
        </fieldset>

        <fieldset>
            <legend>Get author</legend>
            <form action="" >
             </form>
        </fieldset>

        <fieldset>
            <legend>Search tags</legend>
            <form action="" id="">
             </form>
        </fieldset>

        <fieldset>
            <legend>Get tag</legend>
            <form action="" id="">
             </form>
        </fieldset>

        <fieldset>
            <legend>Search categories</legend>
            <form action="" id="">
             </form>
        </fieldset>

        <fieldset>
            <legend>Get category</legend>
            <form action="" id="">
             </form>
        </fieldset>


    <div style="clear: both"></div>
    <div id="api-response">
    </div>

</body>
</html>