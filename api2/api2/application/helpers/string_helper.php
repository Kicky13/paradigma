<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

function pretty_json($json=array(), $istr='  '){
	$json = json_encode($json);
    $result = '';
    for($p=$q=$i=0; isset($json[$p]); $p++)
    {
        $json[$p] == '"' && ($p>0?$json[$p-1]:'') != '\\' && $q=!$q;
        if(!$q && strchr(" \t\n\r", $json[$p])){continue;}
        if(strchr('}]', $json[$p]) && !$q && $i--)
        {
            strchr('{[', $json[$p-1]) || $result .= "\n".str_repeat($istr, $i);
        }
        $result .= $json[$p];
        if(strchr(',{[', $json[$p]) && !$q)
        {
            $i += strchr('{[', $json[$p])===FALSE?0:1;
            strchr('}]', $json[$p+1]) || $result .= "\n".str_repeat($istr, $i);
        }
    }
    return $result;
}

function to_json($json){
    header('Content-Type: application/json');
    print pretty_json($json);
    exit();
}

function ret_json($json){
    return pretty_json($json);
}

function obj_to_array($arr){
    $var = get_object_vars($arr);
    foreach ($var as &$value) {
        if (is_object($value) && method_exists($value,'getJsonData')) {
            $value = $value->getJsonData();
        }
    }
    return $var;
}

function short_opco($kd=''){
    switch ($kd) {
        case '3000':
            $name = 'SP';
            break;
        case '4000':
            $name = 'ST';
            break;
        case '5000':
            $name = 'SG';
            break;
        case '6000':
            $name = 'TLCC';
            break;
        
        default:
            $name ='';
            break;
    }
    return $name;
}
