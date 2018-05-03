<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/28/2016
 * Time: 5:12 PM
 */

namespace App\Core\Config;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'core_configs';

    protected $fillable = [
        'code',
        'type',
        'description',
        'description'

    ];


}
