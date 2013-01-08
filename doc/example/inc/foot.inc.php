</div>
    <script type="text/javascript">
        document.getElementById('procRendTime').innerHTML = '<?php print(round($procDuration - $curlTime, 3)) ?> sec';
        document.getElementById('procTime').innerHTML = '<?php print(round($procDuration, 3)) ?>';
    </script>
</body>
</html>
