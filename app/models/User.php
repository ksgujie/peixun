<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

require_once app_path().'/libs/functions.php';

class User extends Eloquent implements UserInterface, RemindableInterface {
	
	public $timestamps=false;

    protected $guarded=[];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

    public static $rulesAdd = array(
        'username'	=>	'required',
        'password'	=>	'required',
        'sfz'	=>	'required',
        'email'	=>	'required',
        'address'	=>	'required',
        'tel'	=>	'required',
        'school_id'	=>	'required',
    );

    public static $rulesEdit = array(
        'username'	=>	'required',
//        'password'	=>	'required',
        'sfz'	=>	'required',
        'email'	=>	'required',
        'address'	=>	'required',
        'tel'	=>	'required',
        'school_id'	=>	'required',
    );

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
	
	public static function getAll() {
		$users=User::orderby('username','asc')->get();
		$r[0]='请选择';
// 		$r['admin']='管理员';
		foreach ($users as $user) {
			if ($user->school_id) {
				$pinyin=pinyin($user->username);
				$showname = strlen($user->username)==6 ? $user->username.'　' : $user->username;
				$r[strtoupper($pinyin[0])][$user->id]= $showname.' '.$user->school->name;
				
			} else {
				$r['1'][$user->id]=$user->username;
			}
		    
		    
		}
		ksort($r, SORT_STRING);	

		return $r;
	}

	public function school() {
		return $this->belongsTo('School');
	}


	

}