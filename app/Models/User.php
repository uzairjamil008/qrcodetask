<?php



namespace App\Models;



use Illuminate\Contracts\Auth\MustVerifyEmail;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;



class User extends Authenticatable implements MustVerifyEmail

{

   use Notifiable;

   protected $guarded = array();

    protected $with = ['role'];

    public function role()

    {

        return $this->belongsTo('App\Models\Role\Role', 'role_id', 'id');

    }

    public function countries()

    {

        return $this->belongsTo('App\Models\Locations\Countries', 'country', 'id');

    }

    public function cities()

    {

        return $this->belongsTo('App\Models\Locations\Cities', 'city', 'id');

    }





    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    /*protected $fillable = [

        'name',

        'email',

        'password',

    ];*/



    /**

     * The attributes that should be hidden for arrays.

     *

     * @var array

     */

    protected $hidden = [

        'password',

        'remember_token',

    ];



    /**

     * The attributes that should be cast to native types.

     *

     * @var array

     */

    protected $casts = [

        'email_verified_at' => 'datetime',

    ];

}

