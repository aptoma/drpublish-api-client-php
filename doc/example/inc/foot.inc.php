</div>
    <script type="text/javascript">
        document.getElementById('procRendTime').innerHTML = '<?=round($procDuration - $curlTime, 3) ?> sec';
        document.getElementById('procTime').innerHTML = '<?=round($procDuration, 3) ?>';
    </script>
</body>
</html>
