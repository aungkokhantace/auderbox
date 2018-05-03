<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 11/2/2016
 * Time: 3:11 PM
 */

namespace App\Setup\FrontendClient;

use Illuminate\Database\Eloquent\Model;

class FrontendClient extends Model
{
    protected $table = 'front_end_client';

    protected $fillable = [
        'backend_id','front_end_id','tablet_id',
        'status','description','start_date','end_date','created_at','updated_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    
}
