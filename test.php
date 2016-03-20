<?php
    $connection = ssh2_connect('localhost', 22);
    ssh2_auth_password($connection, 'msi', 'msi');

    ssh2_scp_recv($connection, '/Main', './Main');
?>