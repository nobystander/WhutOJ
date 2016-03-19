<?php



$CONFIG['language_filename'] = array(
    1   =>  'code.c',
    2   =>  'code.cpp',
    3   =>  'Main.java'
    
);


$CONFIG['judge_status'] = array(
    'JUDGE_SE' => -1,
    'JUDGE_PD' => 0, // Pending
    'JUDGE_RJ' => 1,    // Running & judging
    'JUDGE_CE' => 2,     // Compile Error
    'JUDGE_AC' => 3,     // Accepted
    'JUDGE_RE' => 4,     // Runtime Error
    'JUDGE_WA' => 5,     // Wrong Answer
    'JUDGE_TLE' => 6,    // Time Limit Exceeded
    'JUDGE_MLE' => 7,    // Memory Limit Exceeded
    'JUDGE_OLE' => 8,    // Output Limit Exceeded
    'JUDGE_PE' => 9,     // Presentation Error
    
);

$CONFIG['common'] = array(
    'problemdata_path'  => './data',
    'code_path'  => './run'
);

$CONFIG['mq'] = array(
    'mq_host'   =>  'localhost',
    'mq_port'   =>  '5672',
    'mq_user'   =>  'guest',
    'mq_password'   =>  'guest',
    'mq_qos'    =>  1,
    'mq_queue'  =>  'duang'

);

$CONFIG['socket'] = array(
    'socket_host'  =>  'localhost',
    'socket_port'  =>  '2333',
    'secret_key'    =>  sha1('singledog')

);

?>