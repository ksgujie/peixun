<?php

use Illuminate\Support\Facades\Redirect;
class ScoreController extends BaseController {

	public function getAdd()
	{
        $scores = score::where('user_id', Auth::user()->id)->get();
        return View::make('score.add')->with('scores', $scores);
	}
	

	public function postAdd() {
	    //比较是否达到限制人数
	    $limit = (int)Sysconfig::get('totalLimit');
	    if ($limit) {
	        $count = Score::count();
	        if ($count>=$limit) {
	            return Redirect::back()->with('danger', "此次培训限制报名 {$limit} 人，现已报满！下次努力^_^");
	        }
	    }
	    
	    
	    
		$input = array_map('trim', Input::all());
		if ($check=Score::where('user_id', Auth::user()->id)->where('f1', $input['f1'])->count()) {
		    //print_r($check);die;
		    return Redirect::to('score/add')->with('danger', '该项目您已报过名，请勿重复报名！');
		}
		$valication = Validator::make($input, Score::$rulesAdd);
        if ( $valication->passes() ) {
	        $score = new score();
	        $score->user_id = Auth::user()->id;
	        if (isset($input['f1'])) $score->f1=$input['f1'];
	        if (isset($input['f2'])) $score->f2=$input['f2'];
	        if (isset($input['f3'])) $score->f3=$input['f3'];
	        if (isset($input['f4'])) $score->f4=$input['f4'];
	        if (isset($input['f5'])) $score->f5=$input['f5'];
	        $score->mark=$input['mark'];
	        $score->save();

	        return Redirect::to('score/add')->with('message', '报名成功！');
        }

		return Redirect::to('score/add')->withErrors($valication)->withInput();
	}
	


	
	public function getDel($id) {
		Score::where('id', $id)
			->where('user_id', Auth::user()->id)
			->delete();
		return Redirect::to('score/list')->with('message', '删除成功！');
	}
	
	public function getList() {
		$scores = score::where('user_id', Auth::user()->id)->get();
		return View::make('score.add')->with('scores', $scores);
	}
	
	
	
	public function getTest() {
		echo '<pre>';
		$item = Item::find(3);
		print_r($item);
		$rs=$item->score();
		dd($rs);
		foreach ($rs as $v) {
			print_r($v->name);
		}
	}

}