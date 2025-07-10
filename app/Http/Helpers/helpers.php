<?php
 function score_story($score)
{
    if ($score < 10) {
        $score = '0'.$score;
    }
    return $score;
}

function story_color($type){
    if ($type == 'M') {
        $color = 'red';
    }elseif ($type == 'T') {
        $color  = 'blue';
    }else {
        $color  = 'orange';
    }
    return $color;
}