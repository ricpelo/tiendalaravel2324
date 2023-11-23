<?php

function dinero($s)
{
    return number_format($s, 2, ',', ' ') . ' €';
}

function truncar($s, $long = 20)
{
    if (mb_strlen($s) > $long) {
        return mb_substr($s, 0, $long) . '...';
    }

    return $s;
}
