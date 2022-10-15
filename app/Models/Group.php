<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory, ModelTrait;
    public static $folder = "group_images";
    public $default_avatar ="default_user.png";
    protected $fillable = ['name','description','type','status','image','user_id'];
    protected $appends = ['type_text','status_text'];

    protected static function booted()
    {
        static::addGlobalScope('getUserGroups', function ($query) {
            if (!auth()->user()->hasRole('super_admin')){
                $query->where('user_id', auth()->user()->id);
            }
        });
    }

    public function image():Attribute{
        return Attribute::make(
            get: fn ($val)=> is_null($val) ?
                asset('images/'.Group::$folder . '/' . $this->default_avatar) :
                asset('images/'.Group::$folder . '/' . $val)
        );
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function getTypeTextAttribute($value){
        return get_group_type_text($this->type);
    }

    public function getStatusTextAttribute($value){
        return get_group_status_text($this->status);
    }
}
