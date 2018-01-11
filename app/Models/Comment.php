<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table = "comments";
    protected $fillable = [
        'sort', 'type', 'sort', 'org_id', 'admin_id', 'itemable_id', 'itemable_type', 'content'
    ];
    protected $dateFormat = 'U';

    /**
     * 获得拥有此评论的模型。
     */
    public function itemable()
    {
        return $this->morphTo();
    }



}
