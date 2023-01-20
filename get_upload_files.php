<?php
function getUploadFiles()
{
    $out = '';
    $path = __DIR__ . '/upload';
    foreach (scandir($path) as $obj) {
        if ($obj == '.' || $obj == '..') {
            continue;
        } elseif (!is_dir($path . '/' . $obj)) {
            $out = $out.'<p>' . $obj . '</p>';
        }
    }
    echo ($out);

}