<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 7/14/2016
 * Time: 4:02 PM
 */

namespace App\Core\SyncsTable;

use Illuminate\Database\Eloquent\Model;

class SyncsTable extends Model
{
    protected $table = 'core_syncs_tables';

    protected $fillable = [
        'id',
        'table_name',
        'version',
        'active'
    ];


}
