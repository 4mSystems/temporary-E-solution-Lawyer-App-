<?php
if (!function_exists('getParentId')) {
    function getParentId()
    {
        if (auth()->user()->parent_id != null) {
            return auth()->user()->parent_id;
        } else {
            return auth()->user()->id;
        }
    }
}

