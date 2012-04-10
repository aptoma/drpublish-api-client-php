<form action="" id="request-form">
	DrPublish API URL
	<input type="text" value="<?=$dpUrl?>" name="dp-url" style="width: 300px" onchange="setDPApiUrl(this.value)"/>
    Publication
	<input type="text" value="<?=$publication?>" name="publication" style="width: 100px" />
	<hr/>
    Search query:
    	<input type="text" name="query" value="<?=$query?>" style="width: 300px"/>
    	Limit:<input type="text" name="limit" value="<?=$limit?>" style="width: 40px"/>
    	Start:<input type="text" name="start" value="<?=$start?>" style="width: 40px"/>
    	<button name="run-search" onclick="submitForm('search'); return false;">Search</button>
    <hr/>
	Article id:
	<input type="text" value="<?=$articleId?>" name="article-id" style="width: 60px" />
	<button name="run-article"  onclick="submitForm('article'); return false;">Show article</button>
	<input type="hidden" name="action" id="action" />
</form>
<script type="text/javascript">
    function submitForm(action) {
        document.getElementById('action').value = action;
        document.getElementById('request-form').submit();
    }
</script>