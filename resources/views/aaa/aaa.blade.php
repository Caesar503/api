<?php
function makeRange($l){
    for($i=0;$i<$l;$i++){
        yield $i;
    }
}
foreach(makeRange(20) as $i){
    echo $i,PHP_EOL;
}