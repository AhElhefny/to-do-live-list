<?php

if (!function_exists('group_types')){
     function group_types(){
        return [
          ['id'=>0,'name'=>'Public'],
          ['id'=>1,'name'=>'Private']
        ];
    }
}

if (!function_exists('group_status')){
    function group_status(){
        return [
            ['id'=>0,'name'=>'Pending'],
            ['id'=>1,'name'=>'Active'],
            ['id'=>2,'name'=>'In-Active']
        ];
    }
}

if (!function_exists('get_group_type_text')){
    function get_group_type_text($type){
        if (!deep_in_array($type,group_types())){
            return 'undefined type';
        }
        return group_types()[$type]['name'];
    }
}

if (!function_exists('get_group_status_text')){
    function get_group_status_text($status){
        if (!deep_in_array($status,group_status())){
            return 'undefined status';
        }
        return group_status()[$status]['name'];
    }
}

//search in deep array (array of arrays)
if (!function_exists('deep_in_array')) {
    function deep_in_array($needle, $haystack)
    {
        if (in_array($needle, $haystack)) {
            return true;
        }
        foreach ($haystack as $element) {
            if (is_array($element) && deep_in_array($needle, $element))
                return true;
        }
        return false;
    }
}
