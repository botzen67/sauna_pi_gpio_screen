<?php
$f1 = fopen("on_off.dat", 'r');
$on_off = intval(stream_get_line($f1,0));
fclose($f1);
if($on_off > 0) {
    $on_off = $on_off - 1;
    $f1 = fopen("on_off.dat",'w');
    fwrite($f1, strval($on_off));
    fclose($f1);
}
?>