<!--



-->

        <footer class="footer">
            <div class="footer-info">
                Developer: Wumpus<br />
                Copyright © 2015 WhutOJ. All Rights Reserved.
            </div>
        </footer>
          

        <script type="text/javascript" src="view/js/jquery.min.js"></script>
        <script type="text/javascript" src="view/js/bootstrap.js"></script>
        

        <script type="text/javascript" src="view/js/naive.js<?php echo '?random='.rand() ?>"></script>
        <script type="text/javascript" src="view/js/header.js<?php echo '?random='.rand() ?>"></script>
  
        <?php
            if(isset($enable_mathjax))
            {
                echo '<script type="text/javascript" src="view/js/mathjax/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>';
            }
        ?>


        <?php
            if(isset($script))
                echo $script;
        ?>

    </body>
</html>