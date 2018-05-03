<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 11/2/2016
 * Time: 5:14 PM
 */

namespace App\Setup\FrontEndLog;

use Illuminate\Database\Eloquent\Model;

class FrontEndLog extends Model
{
    protected $table = 'front_end_log';

    protected $fillable = [
        'front_end_id','description',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];

    
}
