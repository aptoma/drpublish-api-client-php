<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Web client test</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: verdana, sans-serif;
            font-size: 12px;
            background: #ddd;

        }

        h2 {
            background-color: #eee;
            font-size: 12px;
            margin: 0;
            padding: 5px;
            clear: both;
            font-weight: normal;
            border-radius: 3px 3px 0 0;
            color: #555;
        }

        #main {
            width: 735px;
        }

        pre {
            font-size: 10px;
            max-height: 150px;
            overflow-y: auto;
            overflow-x: hidden;
            background: #def;
            padding: 5px;
         }

        .result {
            background: #fff    ;
            padding: 5px;
            margin-bottom: 5px;
            border-radius: 0 0 3px 3px;;
        }

        .content-container {
            width: 710px;

            padding: 5px;
            clear: both;
        }
        .error-message {
            display: block;
            padding: 10px;
            margin: 20px;
            background-color: #FFA500;
            width: 600px
        }

        #request-form {
            margin: 5px 0 8px 0;
            border: solid #777 2px;
            padding: 8px;
            border-radius: 3px;
            background: #ccc;
        }
    </style>
</head>
<body>
<div id="main">
<div>
<? include('form.inc.php') ?>
    <!--
<br /> ...or..<br />
<form action="">
	<input type="hidden" id="dpurl2" value="<?=$dpUrl?>" name="dp-url" style="width: 400px" />
	Search query:
	<input type="text" name="query" value="<?=$query?>" style="width: 300px"/>
	Limit:<input type="text" name="limit" value="<?=$limit?>" style="width: 40px"/>
	Start:<input type="text" name="start" value="<?=$start?>" style="width: 40px"/>
	<input type="submit" name="run-search" value="Search" />
	<input type="hidden" name="run" value="true" />
</form>
<br /> ...or..<br />
<form action="">
	<input type="hidden" id="dpurl3" value="<?=$dpUrl?>" name="dp-url" style="width: 400px" />
	Author id:
	<input type="text" value="<?=$authorId?>" name="author-id" style="width: 60px" />
	<input type="submit" name="run-author" value="Show author" />
	<input type="hidden" name="run" value="true" />
</form>
-->
<script>
function setDPApiUrl(url)
{
	document.getElementById('dpurl2').value= url;
	document.getElementById('dpurl3').value= url;
}
</script>


