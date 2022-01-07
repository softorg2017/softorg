<?php
namespace App\Models\Def;
use Illuminate\Database\Eloquent\Model;

class Def_Pivot_Item_Relation extends Model
{
    //
    protected $connection = 'mysql_doc';
    protected $table = "pivot_item_relation";
    protected $fillable = [
        'active', 'category', 'type', 'relation', 'relation_active', 'relation_category', 'relation_type',
        'mine_item_id', 'relation_item_id'
    ];
    protected $dateFormat = 'U';


    // mine
    function mine_item()
    {
        return $this->belongsTo('App\Models\Def\Def_Item','mine_item_id','id');
    }

    // relation
    function relation_item()
    {
        return $this->belongsTo('App\Models\Def\Def_Item','relation_item_id','id');
    }

    // relations
    function relation_items()
    {
        return $this->hasMany('App\Models\Def\Def_Item','relation_item_id','id');
    }


}
