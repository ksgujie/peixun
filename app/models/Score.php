<?php

class Score extends BaseModel {
	
	public $timestamps=true;

 	protected $fillable = ['*'];


 	public static $rulesAdd = array(
 			'f1'	=>	'required',
// 			'f2'	=>	'required',
// 			'f3'	=>	'required',
// 			'f4'	=>	'required',
// 			'f5'	=>	'required',
 	);

 	public static function types() {
 		return [
 			''=>'请选择',
			'辅导学生比赛'=>'辅导学生比赛',
			'辅导学生发表'=>'辅导学生发表',
			'教师比赛'=>'教师比赛',
			'课件获奖'=>'课件获奖',
			'论文发表'=>'论文发表',
			'论文获奖'=>'论文获奖',
			'教案获奖'=>'教案获奖',
			'公开课'=>'公开课',
			'讲座'=>'讲座',
			'其它'=>'其它',
 		];
 	}
 	
	public static $gameLevels = [
		'全国团体一等奖',
		'全国团体二等奖',
		'全国团体三等奖',
		'全国特等奖',
		'全国一等奖',
		'全国二等奖',
		'全国三等奖',
//		'全国鼓励奖',
		'江苏省团体一等奖',
		'江苏省团体二等奖',
		'江苏省团体三等奖',
		'江苏省特等奖',
		'江苏省一等奖',
		'江苏省二等奖',
		'江苏省三等奖',
//		'江苏省鼓励奖',
		'苏州市团体一奖',
		'苏州市团体二奖',
		'苏州市团体三奖',
		'苏州市特等奖',
		'苏州市一等奖',
		'苏州市二等奖',
		'苏州市三等奖',
//		'苏州市鼓励奖',
		'昆山市团体一等奖',
		'昆山市团体二等奖',
		'昆山市团体三等奖',
		'昆山市特等奖',
		'昆山市一等奖',
		'昆山市二等奖',
		'昆山市三等奖',
//		'昆山市鼓励奖',
//		'校级一等奖',
//		'校级二等奖',
//		'校级三等奖',
//		'校级鼓励奖',
	];

	public static $commonPublishLevels = [
		'国家级',
		'省级',
		'苏州市级',
		'昆山市级',
		'片级',
	];

	public function item() {
		return $this->belongsTo('Item');
// 		return Item::find($this->item_id);
	}
	
	public function user() {
		return $this->belongsTo('User');
	}
	

}