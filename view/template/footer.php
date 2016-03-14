<!--



-->

        <footer class="footer">
            <div class="footer-info">
                Developer: Wumpus
            </div>
            <div class="copyright">
                Copyright © 2015 WhutOJ. All Rights Reserved.
            </div>
        </footer>
          

        <script type="text/javascript" src="view/js/jquery.min.js<?php echo '?random='.rand() ?>"></script>
        <script type="text/javascript" src="view/js/bootstrap.js<?php echo '?random='.rand() ?>"></script>
        <script type="text/javascript" src="view/js/naive.js<?php echo '?random='.rand() ?>"></script>
        <script type="text/javascript" src="view/js/header.js<?php echo '?random='.rand() ?>"></script>

		<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/highlight.min.js"></script>
		<script>hljs.initHighlightingOnLoad();</script> <!--代码高亮-->
</script>
        <?php
            if(isset($script))
                echo $script;
        ?>

    </body>
</html>
