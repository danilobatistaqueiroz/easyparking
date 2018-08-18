<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Log\Log;

class LinkHelper extends Helper
{
    public function url_mini($id)
    {
        $id = str_pad($id, 8, "0", STR_PAD_LEFT);
        $url_mini = 'parkings/minis/' . $id . '.png';
        return $url_mini;   
    }
}