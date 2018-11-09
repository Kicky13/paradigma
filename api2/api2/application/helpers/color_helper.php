<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

function getFixColor($idx){
    $idx = is_numeric($idx) ? $idx:0;
    $idx = ($idx > 9 ) ? makeOneDigit($idx):$idx;
    $color = array( 0 => "176,196,222", #light steel blue
                    1 => "176,0,186",   #purple
                    2 => "0,255,0",     #lime
                    3 => "0,0,255",     #blue
                    4 => "255,255,0",   #yellow
                    5 => "255,0,255",   #magenta
                    6 => "0,255,255",   #cyan/aqua
                    7 => "0,255,127",   #spring green
                    8 => "138,43,226",  #blue violet
                    9 => "255,228,225"  #misty rose
                );

    return $color[$idx];
}

function monthColor($idx){
    $idx = is_numeric($idx) ? ($idx-1):0;
    $color = array(
                0 => "69,166,245",  #JAN - Sapphire
                1 => "251,70,167",  #FEB - Rose
                2 => "35,169,20",   #MAR - Emerald
                3 => "162,89,207",  #APR - Lavender
                4 => "245,216,50",  #MAY - Sunshine
                5 => "145,145,145", #JUN - Cloud
                6 => "46,82,130",   #JUL - Royal
                7 => "51,196,153",  #AGS - Turquoise
                8 => "248,172,37",  #SEP - Honey
                9 => "246,88,41",   #OCT - Pumpkin
                10 => "115,68,14",  #NOV - Cocoa
                11 => "206,21,18"   #DEC - Gamet
            );
    return $color[$idx];
}

function getDash($idx){
    $idx = is_numeric($idx) ? $idx:0;
    $idx = ($idx > 9 ) ? makeOneDigit($idx):$idx;
    $dash = array( 0 => "solid",       # _______
                    1 => "dot",        # . . . .
                    2 => "dash",       # - - - -
                    3 => "longdash",   # _ _ _ _
                    4 => "dashdot",    # - . - .
                    5 => "solid",      # _______
                    6 => "dot",        # . . . .
                    7 => "dash",       # - - - -
                    8 => "longdash",   # _ _ _ _
                    9 => "dashdot"     # - . - .
                );
    return $dash[$idx];
}

function makeOneDigit($num){
    $num = is_numeric($num) ? $num:strlen($num);
    $ctr = str_split($num);
    $res = 0;
    for ($i=0; $i < count($ctr); $i++) {
        $res += $ctr[$i];
    }

    if (count(str_split($res)) > 1) {
        $res = makeOneDigit($res);
    }

    return $res;
}

function getRandomColor($num) {
    $hash = md5('warnawarni' . $num);
    return array(hexdec(substr($hash, 0, 2)), hexdec(substr($hash, 2, 2)), hexdec(substr($hash, 4, 2)));
}

function getRankColor($rank){
    $color = array(
        1 => '#C98910', #Gold
        2 => '#A8A8A8', #Silver
        3 => '#965A38', #Bronze
        4 => '#edeaea'  #Gallery
    );
    return $color[$rank];
}

function company_color_rgb($code){
    $idx = is_numeric($code) ? $code:2000;
    $color = array( 2000 => "255,5,5",    #SMIG
                    3000 => "140,112,124",#PADANG
                    4000 => "144,134,125",#TONASA
                    5000 => "34,64,152",  #GRESIK
                    6000 => "206,208,194" #TANGLONG
                );

    return $color[$idx];
}

function company_color_rgb2($code){
    $idx = is_numeric($code) ? $code:2000;
    $color = array( 2000 => "255,5,5",    #SMIG
                    3000 => "255,0,0",    #PADANG
                    4000 => "0,255,0",    #TONASA
                    5000 => "0,0,255",    #GRESIK
                    6000 => "255,255,0"   #TANGLONG
                );

    return $color[$idx];
}

function company_color($code, $idx=0){
    switch (trim($code)) {
        case '2000': #SMIG
            $color  = "#FF0505";
            $color2 = "#FF0505";
            $color3 = "#FF0505";
            break;

        case '3000': #PADANG
            $color  = "#8C707C"; #Warna Inti
            $color2 = "#C4B0B8";
            $color3 = "#D3C6CB";
            break;

        case '4000': #TONASA
            $color  = "#90867D"; #Warna Inti
            $color2 = "#A5998E";
            $color3 = "#BAB2AB";
            break;

        case '5000': #GRESIK
            $color  = "#224098"; #Warna Inti
            $color2 = "#3B5DBA";
            $color3 = "#7096EF";
            break;

        case '6000': #TANGLONG
            $color  = "#CED0C2"; #Warna Inti
            $color2 = "#CECECC";
            $color3 = "#DDDDD2";
            break;

        default:
            $color  = "#FFBF00";
            $color2 = "#FF0505";
            $color3 = "#FF0505";
            break;
    }

    $col = array($color, $color2, $color3);
    return $col[$idx];
}
