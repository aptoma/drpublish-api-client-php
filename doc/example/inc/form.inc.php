<form action="" id="request-form">
	DrPublish API URL
	<input type="text" value="<?php print($dpUrl) ?>" name="dp-url" style="width: 300px" onchange="setDPApiUrl(this.value)"/>
    Publication
	<input type="text" value="<?php print($publication) ?>" name="publication" style="width: 100px" />
	<hr/>
    <span style="vertical-align: top;">Search query:</span>
    	<textarea name="query" style="width: 600px" style="vertical-align: top"><?php print(htmlentities($query)) ?></textarea>
    <br/>
    	Limit:<input type="text" name="limit" value="<?php print($limit) ?>" style="width: 40px"/>
    	Start:<input type="text" name="start" value="<?php print($start) ?>" style="width: 40px"/>
        <!--Fields: <input type="text" name="fields" value="<?php print($fields) ?>" style="width: 70px"/>-->
        <br/><br/>
    	<button name="run-search" onclick="submitForm('search'); return false;">Search</button>
    <hr/>
	Article id:
	<input type="text" value="<?php print($articleId)?>" name="article-id" style="width: 60px" />
	<button name="run-article"  onclick="submitForm('article'); return false;">Show article</button>
	<input type="hidden" name="action" id="action" />
</form>
<script type="text/javascript">
    function submitForm(action) {
        document.getElementById('action').value = action;
        document.getElementById('request-form').submit();
    }
</script>