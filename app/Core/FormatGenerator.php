<?php namespace App\Core;
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 7/20/2016
 * Time: 10:34 AM
 */

class FormatGenerator {

    //create notification params.
    public static function message($title, $body)
    {
        return ['title'=>$title, 'body'=>$body];
    }

}
