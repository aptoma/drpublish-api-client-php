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
      <input type="text"  id="dp-url" name="dp-url" value="http://stefan.aptoma.no:9000" style="width: 300px"/>
    Publication
       <input type="text"  id="dp-publication" name="dp-publication" value="DinePenger" style="width: 100px" />
<hr/>
        <div id="active-form">
            <fieldset>
                <legend>Search articles</legend>
               <form action="search">
                  Filter fields:
                   <div class="selectex">
                      <div class="row">
                           <select name="filterFields[1][key]" size="1">
                                 <option>--choose filter field--</option>
                                 <option>title</option>
                                 <option>story</option>
                                 <option>author</option>
                                 <option>category</option>
                                 <option>dossier</option>
                                 <option>tag</option>
                            </select>
                           <input type="text" name="filterFields[1][value]" />
                           <div class="plus">+</div>
                           <div class="minus">-</div>
                       </div>
                   </div>

                <span style="vertical-align: top;">+ dynamic query (use only for advanced queries!):</span>
                    <textarea name="dynamicQuery"></textarea>
                <br/>
                    Offset:<input type="text" name="offset" value="0" style="width: 40px"/>
                    Limit:<input type="text" name="limit" value="5" style="width: 40px"/>
                    <br/><br/>
                    <button name="run-search" onclick="DrPublishApiClientExmample.submitForm(this); return false;">Search</button>
                </form>
            </fieldset>
        </div>
        <div id="form-pool">


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
                <!--
             <span style="vertical-align: top;">Search query:</span>
                 <textarea name="query"></textarea>
              <br/>
              -->
                <label>Username:</label> <input type="text" name="username" value="aptoma*" style="width: 250px" />
                <br/>
                <label>Name:</label> <input type="text" name="fullname"  style="width: 250px"/>
                <br/>
                Offset:<input type="text" name="offset" value="0" style="width: 40px"/>
                Limit:<input type="text" name="limit" value="5" style="width: 40px"/>
                <br/><br/>
               <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" val="Search" />
             </form>
        </fieldset>

        <fieldset>
            <legend>Get author</legend>
            <form action="author" >
                <input type="text" value="1" name="author-id" style="width: 80px" />
                <br/><br/>
               <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" val="Show author" />
             </form>
        </fieldset>


        <fieldset>
            <legend>Search Tags</legend>
            <form action="search-tags">
                <!--
             <span style="vertical-align: top;">Search query:</span>
                 <textarea name="query"></textarea>
              <br/>
              -->
                <label>Tag name:</label> <input type="text" name="name" value="" style="width: 250px" />
                <br/>
                <label>Name:</label> <input type="text" name="fullname"  style="width: 250px"/>
                <br/>
                Offset:<input type="text" name="offset" value="0" style="width: 40px"/>
                Limit:<input type="text" name="limit" value="5" style="width: 40px"/>
                <br/><br/>
               <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" val="Search" />
             </form>
         </fieldset>


        <fieldset>
            <legend>Get tag</legend>
            <form action="tag">
                <input type="text"  name="tag-id" style="width: 80px" />
                <br/><br/>
               <input type="submit" onclick="DrPublishApiClientExmample.submitForm(this); return false;" val="Show tag" />
             </form>
          </fieldset>




            <!--
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

        -->

        </div>


    <div style="clear: both"></div>
    <div id="api-response-wrap">
    <div id="api-response">
    </div>
     </div>

</body>
</html>