<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $table = "items";
    protected $fillable = [
        'sort', 'type', 'sort', 'org_id', 'admin_id', 'menu_id', 'itemable_id', 'itemable_type', 'content'
    ];
    protected $dateFormat = 'U';

    /**
     * 获得拥有此条目的模型。
     */
    public function itemable()
    {
        return $this->morphTo();
    }



}
