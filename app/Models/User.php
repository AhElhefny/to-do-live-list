<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    public static $folder = "users images";
    public $default_avatar ="default user.png";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'userPhoto'
    ];

    protected $filters = [
        'id'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $appends = ['photo'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getFilters()
    {
        return $this->filters ?? [];
    }

    public function scopeOfId($query,$id){
        return $query;
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('Y-m-d'),
        );
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) =>Hash::make($value),
        );
    }

    public function photo():Attribute{
        return Attribute::make(
            get: fn ($val)=> is_null($this->userPhoto) ?
                asset('images/'.User::$folder . '/' . $this->default_avatar) :
                asset('images/'.User::$folder . '/' . $this->userPhoto)
        );
    }

}
