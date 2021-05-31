<?php
namespace App\Models\Doc;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doc_Item extends Model
{
    use SoftDeletes;
    //
    protected $table = "doc_item";
    protected $fillable = [
        'active', 'status', 'item_active', 'item_status', 'item_category', 'item_type', 'category', 'type', 'sort',
        'owner_active',
        'owner_id', 'creator_id', 'user_id', 'belong_id', 'source_id', 'object_id', 'p_id', 'parent_id', 'quote_item_id',
        'rank', 'version',
        'org_id', 'admin_id',
        'item_id', 'menu_id',
        'name', 'title', 'subtitle', 'description', 'content', 'custom', 'custom2', 'custom3',
        'link_url', 'cover_pic', 'attachment_name', 'attachment_src',
        'tag',
        'atom_category', 'major', 'nation', 'birth_time', 'death_time',
        'time_point', 'time_type', 'start_time', 'end_time', 'address',
        'visit_num', 'share_num', 'favor_num', 'comment_num',
        'published_at'
    ];

    // 定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
//    public $timestamps = false;

    // 此属性决定插入和取出数据库的格式，默认datetime格式，'U'是int(10)
    protected $dateFormat = 'U';

    // 应被转换为日期的属性
//    protected $dates = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    // 如果数据库存的是datetime或者没定义$dateFormat，又想取出的时候是int...
//    public function getDates()
//    {
//        return array('created_at','updated_at');
//        return array(); // 原形返回；
//    }

    // 属性类型转换
//    protected $casts = [
//        'created_at' => 'int',
//        'updated_at' => 'integer',
//    ];




    /**
     * 获取当前时间
     *
     * @return int
     */
//    public function freshTimestamp() {
//        return time();
//    }

    /**
     * 避免转换时间戳为时间字符串
     *
     * @param DateTime|int $value
     * @return DateTime|int
     */
//    public function fromDateTime($value) {
//        return $value;
//    }

    /**
     * select的时候避免转换时间为Carbon
     *
     * @param mixed $value
     * @return mixed
     */
//    protected function asDateTime($value) {
//        return $value;
//    }

    /**
     * 从数据库获取的为获取时间戳格式
     *
     * @return string
     */
//    public function getDateFormat() {
//        return 'U';
//    }


    // 拥有者
    function owner()
    {
        return $this->belongsTo('App\User','owner_id','id');
    }
    // 创作者
    function creator()
    {
        return $this->belongsTo('App\User','creator_id','id');
    }
    // 用户
    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }




    // 多对多 人关联的作品
    function pivot_people_product()
    {
        return $this->belongsToMany('App\Models\Doc\Doc_Item','doc_pivot_item_relation','mine_item_id','relation_item_id')
            ->wherePivot('relation_type', 1);
//            ->withTimestamps();
    }
    // 多对多 作品关联的人
    function pivot_product_people()
    {
        return $this->belongsToMany('App\Models\Doc\Doc_Item','doc_pivot_item_relation','relation_item_id','mine_item_id')
            ->wherePivot('relation_type', 1);
//            ->withTimestamps();
    }




    // 子节点
    function items()
    {
        return $this->hasMany('App\Models\Doc\Doc_Item','item_id','id');
    }

    // 父节点
    function belong_item()
    {
        return $this->belongsTo('App\Models\Doc\Doc_Item','item_id','id');
    }

    // 转发内容
    function forward_item()
    {
        return $this->belongsTo('App\Models\Doc\Doc_Item','item_id','id');
    }

    // 父节点
    function parent()
    {
        return $this->belongsTo('App\Models\Doc\Doc_Item','p_id','id');
    }

    // 子节点
    function children()
    {
        return $this->hasMany('App\Models\Doc\Doc_Item','p_id','id');
    }

    // 内容
    function contents()
    {
        return $this->hasMany('App\Models\Doc\Doc_Item','item_id','id');
    }

    // 评论
    function communications()
    {
        return $this->hasMany('App\Models\Doc\Doc_Communication','item_id','id');
    }

    // 评论
    function comments()
    {
        return $this->hasMany('App\Models\Doc\Doc_Communication','item_id','id');
    }

    // 收藏
    function collections()
    {
        return $this->hasMany('App\Models\Doc\Doc_Pivot_User_Collection','item_id','id');
    }




    // 其他人的
    function pivot_item_relation()
    {
        return $this->hasMany('App\Models\Doc\Doc_Pivot_User_Item','item_id','id');
    }

    // 与我相关的话题
    function pivot_collection_course_users()
    {
        return $this->belongsToMany('App\User','pivot_user_collection','item_id','user_id');
    }

    // 与我相关的话题
    function pivot_collection_chapter_users()
    {
        return $this->belongsToMany('App\User','pivot_user_collection','item_id','user_id');
    }

    /**
     * 获得此人的所有标签。
     */
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }




}
