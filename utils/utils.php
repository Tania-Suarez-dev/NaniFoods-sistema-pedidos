<?php

function formatDateTime($dateTimeStr)
{
    $dateTime = new DateTime($dateTimeStr);
    return $dateTime->format('d M Y, H:i');
}

function showStars($estrellas)
{
    $stars_html = '';
    for ($i = 0; $i < 5; $i++) {
        if ($i < $estrellas) $stars_html .= '<i class="bx bxs-star" style="color: #ffcd3c;"></i>';
        else $stars_html .= '<i class="bx bxs-star" style="color: #ccc;"></i>';
    }
    echo '<div class="estrellas">' . $stars_html . '</div>';
}
