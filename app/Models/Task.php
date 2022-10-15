<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, ModelTrait;
    public static $folder = "task_images";
    public $default_avatar ="default_user.png";
    protected $fillable = ['name','content','status','image','group_id','user_id'];
    protected $appends = ['status_text'];

    public function group(){
        return $this->belongsTo(Group::class,'group_id');
    }

    public function getStatusTextAttribute($value){
        return get_group_status_text($this->status);
    }

    public function image():Attribute{
        return Attribute::make(
            get: fn ($val)=> is_null($val) ?
                asset('images/'.Task::$folder . '/' . $this->default_avatar) :
                asset('images/'.Task::$folder . '/' . $val)
        );
    }
}
