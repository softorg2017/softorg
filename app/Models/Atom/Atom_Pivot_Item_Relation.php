<?php
namespace App\Models\Atom;
use Illuminate\Database\Eloquent\Model;

class Atom_Pivot_Item_Relation extends Model
{
    //
    protected $connection = 'mysql_atom';
    protected $table = "pivot_item_relation";
    protected $fillable = [
        'active', 'category', 'type', 'relation', 'relation_active', 'relation_category', 'relation_type',
        'mine_item_id', 'relation_item_id'
    ];
    protected $dateFormat = 'U';


    // mine
    function mine_item()
    {
        return $this->belongsTo('App\Models\Atom\Atom_Item','mine_item_id','id');
    }

    // relation
    function relation_item()
    {
        return $this->belongsTo('App\Models\Atom\Atom_Item','relation_item_id','id');
    }

    // relations
    function relation_items()
    {
        return $this->hasMany('App\Models\Atom\Atom_Item','relation_item_id','id');
    }


}
