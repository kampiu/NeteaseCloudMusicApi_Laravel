<?php
/**
 * Created by PhpStorm.
 * Author: Administrator
 * Date: 2019/5/10
 * Time: 11:42
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    // 表名
    protected $table = 'user';
    // 主键
    protected $primaryKey = 'id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    protected $dateFormat = 'U';
    protected $hidden = ['password'];
    // 允许批量赋值
    protected $fillable = ['nickname', 'account', 'password', 'email', 'phone'];

    // 维护时间戳
    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public $guarded = [];

    public function roles(){
        return $this->belongsToMany('App\Model\Role', 'user_role', 'user_id', 'role_id')->withPivot('user_id', 'role_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function Article()
    {
        return $this->hasMany(Article::class, 'user_id', 'id');
    }

    public function Project()
    {
        return $this->hasMany(Project::class, 'user_id', 'id');
    }
}