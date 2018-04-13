<?php
$log_path = '/var/log/yiban-byr-gitlab-webhook-autopoll.log';
$exec_pair = [
    "a-hash-key" => "cd /path/to/the/project && git pull"
];
function request_log($txt) {
    global $log_path;
    file_put_contents($log_path, "\n".$txt, FILE_APPEND | LOCK_EX);
}

function log_msg($msg) {
    request_log(date("YmdHis")." - ".$msg." - ".$_SERVER['REQUEST_METHOD']." - ".$_SERVER['REQUEST_URI']." - ".$_SERVER['REMOTE_ADDR']);
}

$key = isset($_SERVER['HTTP_X_GITLAB_TOKEN']) ? $_SERVER['HTTP_X_GITLAB_TOKEN'] : false;
if (!$key) {
    log_msg("EXPECTED HEADER NOT FOUND");
    die('1');
}

if (! isset($exec_pair[$key])) {
    log_msg("KEY NOT IN KEY PAIR");
    die('2');
}

$r = exec($exec_pair[$key]);

log_msg("EXECUTED '".$exec_pair[$key]."' with return '".$r."'");
echo "done";
?>
