<?php
/*

    gitlab-webhook-autopull
    Copyright (C) 2018  FredericDT

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
    
*/

$log_path = '/var/log/gitlab-webhook-autopoll.log';
$exec_pair = [
    "secret-token" => "cd /path/to/the/project && git pull"
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
