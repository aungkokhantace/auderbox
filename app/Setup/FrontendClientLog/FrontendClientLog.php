<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 11/2/2016
 * Time: 5:12 PM
 */

namespace App\Setup\FrontendClientLog;

use Illuminate\Database\Eloquent\Model;

class FrontendClientLog extends Model
{
    protected $table = 'front_end_client_log';

    protected $fillable = [
        'front_end_id','description',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];

    
}
