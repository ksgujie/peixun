<?php

class AdminStudentController extends AdminController {
	
	public function getLogout() {
		Auth::logout ();
		return Redirect::to ( '/' );
	}
	
	public function getList() {
		
		$students = Student::orderBy('item_id')
			->orderBy('user_id')
			->orderBy('group_id')
			->get();
// 		dd($students);

		return View::make('admin.student.list')->with('students', $students);
	}
	
	public function getBuild() {
	    require_once app_path() . '/Libs/Excel.php';
	    $rs = Score::all();
		foreach ($rs as $s) {
            $user = User::find($s->user_id);
            $school = School::find($user->school_id);
            
            $user->schoolName = $user->school->name;
            $user->schoolType = $user->school->type;
            $rows[$user->id] = $user;
		}
		
        $Excel = new Excel();
        $config = [
			'templateFile'=>app_path('tpl.xls'),
			'sheetName'=>'继续教育',
			'firstDataRowNum'=>2,
			'data'=>$rows,
		];		
		$Excel->setConfig($config);
		$Excel->make();
		
        $config = [
			'templateFile'=>app_path('tpl.xls'),
			'sheetName'=>'签到表',
			'firstDataRowNum'=>3,
			'data'=>$rows,
		];
		$Excel->setConfig($config);
		$Excel->make();
		
		$Excel->save(storage_path () . '/qiandao.xls');
		
		return Response::download(
				storage_path().DIRECTORY_SEPARATOR.'qiandao.xls',
				'qiandao.xls',
				["Expires:-1","Cache-Control:no-cache","Pragma:no-cache"]
		);		
	}
	
	public function getExport() {
	    set_include_path ( app_path () . '/libs/PEAR/' );
		include_once ('Spreadsheet/Excel/Writer.php');
		if (is_file(storage_path () . '/data.xls')) unlink(storage_path () . '/data.xls');
		$workbook = new Spreadsheet_Excel_Writer_Workbook ( storage_path () . '/data.xls' );
		
		//报名清单
		$worksheet = $workbook->addWorkSheet ( gbk ('名单') );
		$worksheet->writeRow( 0, 0, array_map('gbk', ['序号','姓名','性别','学校','学校属性','电话', '身份证号', '地址','邮箱','f1','f2','f3','f4','f5','备注','报名时间']) );
	
		$rs = Score::orderBy('id')->get();

		$n=1;
		foreach ($rs as $s) {
            $user = User::find($s->user_id);
            $school = School::find($user->school_id);
			$row = [$n,
                $user->username,
                $user->sex,
                $user->school->name,
                $user->school->type,
                $user->tel,
                $user->sfz,
                $user->address,
                $user->email,
                $s->f1,
                $s->f2,
                $s->f3,
                $s->f4,
                $s->f5,
                $s->mark,
                $s->created_at,
            ];
			$worksheet->writeRow( $n, 0,  array_map('gbk', $row) );
			$n++;			
		}

		$workbook->close ();
		
		return Response::download(
				storage_path().DIRECTORY_SEPARATOR.'data.xls',
				'Students.xls',
				["Expires:-1","Cache-Control:no-cache","Pragma:no-cache"]
		);
		
	}
	
	public function getStatistics() {
		//学生总人数
		$studentsCount = count(Student::all());
		//分项目
		$items = Item::all();
		//已报名、未报名学校
		$users = User::where('isadmin', 0)->orderBy('type')->orderby('id')->get();
		
		$signupSchools = $unsignupSchools = array();
		foreach ($users as $user) {
			if ( $user->students->count() ) {
				$signupSchools[] = $user;
			} else {
				$unsignupSchools[] = $user;
			}
		}
		
		return View::make('admin.student.statistics')
			->with('studentsCount', $studentsCount)
			->with('items', $items)
			->with('signupSchools', $signupSchools)
			->with('unsignupSchools', $unsignupSchools);
	}
	
	public function getTest() {
		dd(User::find(2)->students);
	}
	
	
}