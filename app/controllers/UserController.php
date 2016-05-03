<?php


class UserController extends BaseController {
	
// 	public $layout = 'layout/user';
	public function getForgetpassword() {
		return View::make('user.forgetpassword');
	}
	
	public function postForgetpassword() {
		$input = array_map('trim', Input::all());
		$User = User::where('username',$input['username'])
					->where('sfz',$input['sfz'])
					->first();
		if ($User) {
			//dd($User);
			$User->password=Hash::make('');
			$User->save();
			Session::flash('success', "恭喜：您的密码已经重置为空密码，请用空密码登陆！！");			
	        return Redirect::to('user/login');
		} else {
            Session::flash('message', "姓名或身份证号错误！");			
	        return Redirect::to('user/forgetpassword')->withInput();
		}
	}

    public function getReg() {
        //提示系统提示信息
        $info = Sysconfig::get('info');
        if ($info) {
            Session::flash('message', nl2br($info));
        }

        //判断系统是否已关闭
        $sysClosed=false;
        if (Sysconfig::get('siteClosed')==1) {
            Session::flash('danger', '系统已关闭！');
            $sysClosed = true;
        }
        if (Sysconfig::get('siteClosed')==2) {
            $closeTime = strtotime(Sysconfig::get('siteCloseTime'));
            if (time()>=$closeTime) {
                Session::flash('danger', '系统已关闭！');
            }
            $sysClosed = true;
        }
        if ($sysClosed) {
            return View::make('user.login')->with('danger', '系统已关闭！');
        }

        return View::make('user.reg');
    }

    public function postReg() {
        $input = array_map('trim', Input::all());
        $valication = Validator::make($input, User::$rulesAdd);
        if ( $valication->passes() ) {
            $User = new User();
            $User->school_id = $input['school_id'];
            $User->username=$input['username'];
            $User->password=Hash::make($input['password']);
            $User->sfz=$input['sfz'];
            $User->tel=$input['tel'];
            $User->email=$input['email'];
            $User->address=$input['address'];
            $User->sex=$input['sex'];
            $User->save();

//            Session::flash('success', '保存成功！');
            return Redirect::to('user/login')->with('success', '注册成功！');
        }

        return Redirect::to('user/reg')->withErrors($valication)->withInput();
    }

	public function getLogin()
	{
		$this->layout = '';
		if (Sysconfig::get('siteClosed')==1) {
			Session::flash('danger', '系统已关闭！');
		}
		if (Sysconfig::get('siteClosed')==2) {
			$closeTime = strtotime(Sysconfig::get('siteCloseTime'));
			if (time()>=$closeTime) {
				Session::flash('danger', '系统已关闭！');
			}
		}
		
		$info = Sysconfig::get('info');
		if ($info) {
			Session::flash('message', nl2br($info));
		}
		
		return View::make('user.login');
	}
	
	public function postLogin() {
		if ( Auth::attempt(['id'=>Input::get('id'), 'password'=>Input::get('password')], false) ) {
			if (Auth::user()->isadmin==1) {
				return Redirect::to('admin');
			} else {
				return Redirect::to('/');
			}
		} else {
			return Redirect::to('user/login')->with('danger', '密码错误！');
		}
	}
	
	
	public function getLogout() {
		Auth::logout();
		return Redirect::to('/');
	}
	
	public function getEditpwd() {
		return View::make('user.editpwd');
	}
	
	public function postEditpwd() {
		$user = Auth::user();
		$valication = Validator::make(Input::all(), ['password'=>'required']);
		if ($valication->passes() ) {
			$user->password=Hash::make(Input::get('password'));
			$user->save();
			return Redirect::to('user/editpwd')->with('message', '密码设置成功！');
		} 
		
		return Redirect::to('user/editpwd')->withErrors($valication);

	}


    public function getEdit() {
        return View::make('user.edit')->with('user',Auth::user());
    }

    public function postEdit() {
        $input = array_map('trim', Input::all());
        $valication = Validator::make($input, User::$rulesEdit);
        if ( $valication->passes() ) {
            $User = Auth::user();
            $User->school_id = $input['school_id'];
            $User->username=$input['username'];
//            $User->password=Hash::make($input['password']);
            $User->sfz=$input['sfz'];
            $User->tel=$input['tel'];
            $User->email=$input['email'];
            $User->address=$input['address'];
            $User->sex=$input['sex'];
            $User->save();
//            Session::flash('success', '保存成功！');
            return Redirect::to('user/edit')->with('success', '修改成功！');
        }

        return Redirect::to('user/edit')->withErrors($valication)->withInput();

    }


}