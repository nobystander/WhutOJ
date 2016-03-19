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

       
        <?php
            if(isset($script))
                echo $script;
        ?>

    </body>
</html>