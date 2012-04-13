<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>Web client test</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="inc/jquery.min.js"></script>
    <script type="text/javascript">
    function setDPApiUrl(url)
    {
    	document.getElementById('dpurl2').value= url;
    	document.getElementById('dpurl3').value= url;
    }
    function submitForm(action) {
        document.getElementById('action').value = action;
          var params = $('#request-form').serialize();
           $('#api-response').fadeOut( function() {
              jQuery.get('web-client-test.php?' + params, function(data) {
                  $('#api-response').html(data);
                  $('#api-response').fadeIn();

              });
              return false;
           })
    }
    </script>
    <link type="text/css" rel="stylesheet" media="all" href="inc/styles.css" />
</head>
<body>
    <form action="" id="request-form">
        DrPublish API URL
        <input type="text" value="" name="dp-url" style="width: 300px" onchange="setDPApiUrl(this.value)"/>
        Publication
        <input type="text" value="" name="publication" style="width: 100px" />
        <hr/>
        <span style="vertical-align: top;">Search query:</span>
            <textarea name="query" style="width: 600px" style="vertical-align: top"></textarea>
        <br/>
            Start:<input type="text" name="start" value="0" style="width: 40px"/>
            Limit:<input type="text" name="limit" value="5" style="width: 40px"/>

            <br/><br/>
            <button name="run-search" onclick="submitForm('search'); return false;">Search</button>
        <hr/>
        Article id:
        <input type="text" value="" name="article-id" style="width: 60px" />
        <button name="run-article"  onclick="submitForm('article'); return false;">Show article</button>
        <input type="hidden" name="action" id="action" />
    </form>



    <div id="api-response">

    </div>

</body>