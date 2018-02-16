#!/usr/bin/php
<?php
$q=str_split('qwertyuiop');$z=str_split('sdfghjkl');$x=str_split('zxcvbnm');$p[0]='NO';for($i=0;$i<9;$i++){$s=trim(fgets(STDIN));$c=str_split($s);if(h($q,$c))array_push($p,$s);if(h($z,$c))array_push($p,$s);if(h($x,$c))array_push($p,$s);}usort($p,'s');print$p[0];function h($a,$b){return array_intersect($b,$a)==$b;}function s($a,$b){return strlen($b)-strlen($a);}