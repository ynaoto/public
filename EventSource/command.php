<?php
/*
    Command launcher.
    Copyright (c) 2013 Naoto Yoshioka
*/
$cmd = $_REQUEST['command'];

    putenv("PATH=/usr/local/bin:" . getenv("PATH")); // for 'wget' on MacPorts
    putenv("DYLD_LIBRARY_PATH="); // disable /Applications/MAMP/Library/bin/envvars

    header("Content-type: text/event-stream; charset=utf-8");
    header('Cache-Control: no-cache');

    //chdir("..");
    $proc = popen($cmd . ' 2>&1', 'r');
    while ($s = fgets($proc)) {
        //$s = htmlspecialchars($s); // use this line to produce HTML elem.
        echo "data: $s\n";
        flush();
    }
    pclose($proc);
