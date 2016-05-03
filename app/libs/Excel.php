<?php

require_once app_path() . '/Libs/PHPExcel/PHPExcel.php';

class Excel {

	//excel对象
	public $excel;
	//excel表对象
	public $sheet;
	//模板文件
	protected $templateFile;
	//第一条数据的行号
	protected $firstDataRowNum;
	//数据
	protected $data;
	//excel活动表名
	protected $sheetName;
	//表的模板行
	protected $templateRow;

	/*
	 * 以数组形式传入以下变量：
	 * templateFile（Excel模板文件路径）
	 * sheetName（表名）
	 * firstDataRowNum（第一条数据行数）
	 * data（要写入的数据）
	 */
	public function __construct($config=null)
	{
		is_array($config) && $this->setConfig($config);
	}

	public function setConfig($config)
	{
		$params = ['templateFile', 'sheetName', 'firstDataRowNum', 'data'];
		foreach ($params as $param) {
			isset($config[$param]) && $this->$param = $config[$param];
		}

		if (isset($config['templateFile']) && !is_file($config['templateFile'])) {
			exit("App\\Modules\\Excel:" . $config['templateFile'] . ' is not exists!');
		}

	}

	public function setTemplateFile($file)
	{
		$this->templateFile = $file;
	}

	public function setSheetName($name)
	{
		$this->sheetName = $name;
	}

	public function setFirstDataRow($row)
	{
		$this->firstDataRowNum = $row;
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function make()
	{
		$this->excel or $this->excel = \PHPExcel_IOFactory::load($this->templateFile);
		$this->sheet= $this->excel->getSheetByName($this->sheetName);
		if (!$this->sheet) {
			exit($this->templateFile . ' Excel表 ' . $this->sheetName . ' 不存在。(App\Modules\Excel)');
		}

		//获取行高
			$rowHeight = $this->sheet->getRowDimension($this->firstDataRowNum)->getRowHeight();
			//第一次按行循环，将模板中的第一条数据行往下复制
			for ($j = 1; $j < count($this->data); $j++) {//这里不用<=因为已经有一条模板数据行了，复制的行数比实际数据数减一
				//设置行高
				$this->sheet->getRowDimension($this->firstDataRowNum + $j)->setRowHeight($rowHeight);
				//总列数
				$colCount = \PHPExcel_Cell::columnIndexFromString($this->sheet->getHighestColumn());
				//按列循环
				for ($k = 0; $k < $colCount; $k++) {
					//获取模板数据行各单元格对象
					$templateCell = $this->sheet->getCellByColumnAndRow($k, $this->firstDataRowNum);
					//判断当前单元格中是否含有回车符，有就设置自动换行，否则自动缩小
					$_val = trim($templateCell->getValue());
					if (preg_match('/\n/', $_val)) {
						$templateCell->getStyle()->getAlignment()->setWrapText(true);
					} else {
						//取消自动换行，以使字体自动变小以适应单元格的宽度（两者互斥，同时只能设置其中一项）
						$templateCell->getStyle()->getAlignment()->setWrapText(false);
						//设置模板数据行各单元格对象属性：字体变小以适应宽
						$templateCell->getStyle()->getAlignment()->setShrinkToFit(true);
					}
					//当前单元格的值写入到下一行、对应列的单元格中
					$this->sheet->setCellValueByColumnAndRow($k, $this->firstDataRowNum+$j, $templateCell->getValue());
					//读取模板行单元格格式
					$templateCellStyle = $this->sheet->getCellByColumnAndRow($k, $this->firstDataRowNum)->getStyle();
					//生成当前单元格名称
					$cellName = \PHPExcel_Cell::stringFromColumnIndex($k) . ($this->firstDataRowNum+$j);
					//在当前单元格写入模板数据行对应单元格格式
					$this->sheet->duplicateStyle($templateCellStyle,"$cellName:$cellName");

					//保存模板行的单元格值（去中括号后的值）以备后用
					$this->templateRow[$this->sheetName][$k] = preg_replace(['/^\[/','/\]$/'], '', $templateCell->getValue());
				}
			}
			//第二次按行循环，将数据库中的值写入各单元格
			$lastCellValue = ''; //上一行“组别”或“分组”单元格值，供插入分页符时使用
			$j=0;//行号
			foreach ($this->data as $User) {
				$colCount = \PHPExcel_Cell::columnIndexFromString($this->sheet->getHighestColumn()); //总列数
				for ($k = 0; $k < $colCount; $k++) {
					//读取当前单元格
					$objCurrentCell = $this->sheet->getCellByColumnAndRow($k, $this->firstDataRowNum + $j);
					//当前单元格的值
					$strCurrentCellValue = trim($objCurrentCell->getValue());
					//将当前用户（对象）的值转化为数组
					$arrUser = $User->toarray();
					//去除模板键前后中拨号，转化为字段名
					$templateKey = preg_replace(['/^\[/','/\]$/'], '', $strCurrentCellValue);
					//检测是否为模板键格式并且数据库中存在该字段
					if (preg_match('/^\[.+?\]$/', $strCurrentCellValue) && isset($arrUser[$templateKey])) {
						//当前单元格的值写入相应值
						$this->sheet->setCellValueByColumnAndRow($k, $this->firstDataRowNum+$j, $arrUser[$templateKey]);
						//判断当前单元格中是否含有回车符，有就设置自动换行
						$_val = $this->sheet->getCellByColumnAndRow($k, $this->firstDataRowNum+$j)->getValue();
						if (preg_match('/\n/', $_val)) {
							$templateCell->getStyle()->getAlignment()->setWrapText(true);
						}
					}
				} //for k
				$j++;
			} //foreach

			//页面设置
			$objPageSetup = $this->sheet->getPageSetup();
			$objPageSetup->setRowsToRepeatAtTopByStartAndEnd(1, $this->firstDataRowNum-1);//打印标题行
			$objPageSetup->setHorizontalCentered(true);//水平居中

//			$this->sheet->getHeaderFooter()->setOddHeader('&C&"黑体,常规"&16 '. config('my.比赛名称') . "&\"宋体,常规\"&14（{$item}）" );
//			$this->sheet->getHeaderFooter()->setOddFooter( '&L&P/&N页'
//														.'&R裁判员签名_______________'
//														.' 项目裁判长签名_______________'
//			);
//			$objPageSetup->setFitToPage(true);
//			$objPageSetup->setFitToWidth(1);
//			$objPageSetup->setFitToHeight(10);
	}

	public function save($excelFileName)
	{
		$objWriter = new \PHPExcel_Writer_Excel5($this->excel);
		return $objWriter->save($excelFileName);
	}

	public function saveToPDF($fileName)
	{
		//Write to PDF format
		$objWriter = \PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
		return $objWriter->save($fileName);
	}

	/**
	 * 打印到一页
	 */
	public function printInOnePage()
	{
		$objPageSetup = $this->sheet->getPageSetup();
		$objPageSetup->setFitToWidth(1);
		$objPageSetup->setFitToHeight(3000);
	}

	/**
	 * 设置纸张纵向
	 */
	public function setPagePortrait()
	{
		$this->sheet->getPageSetup()->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	}

	/**
	 * 设置纸张横向
	 */
	public function setPageLandscape()
	{
		$this->sheet->getPageSetup()->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	}

	/**
	 * 插入分页符
	 * @param $pageBreakField 取值：表中某个字段（如：项目、分组、级别）、“行数”（从配置配置文件中读取：按行数分页）
	 * @throws \PHPExcel_Exception
	 */
	public function insertPageBreak($pageBreakField)
	{
		//上一个单元格的值
		$lastCellValue='';
		$j=0;//行号
		$n=0;//计数 for 按行数分页
		$lastGroup='';//上一个组别 for 按行数分页

		foreach ($this->data as $User) {

			if ('行数'==$pageBreakField)// 按行数分页
			{
				$onePageRows = SysConfig::get('项目.'.$User->项目.'.按行数分页');//每页数据数量
				if (!strlen($lastGroup)) {
					$lastGroup = $User->组别;
				}

				if ($n == $onePageRows || $lastGroup!=$User->组别) {
					$this->sheet->setBreak("A" . ($j + $this->firstDataRowNum - 1), \PHPExcel_Worksheet::BREAK_ROW);
					$n=1;
				} else {
					$n++;
				}

				$lastGroup = $User->组别;

			} else { //根据某个字段分页 如：组别、分组
				//总列数
				$colCount = \PHPExcel_Cell::columnIndexFromString($this->sheet->getHighestColumn());
				for ($k = 0; $k < $colCount; $k++) {	//列号
					//读取当前单元格
					$objCurrentCell = $this->sheet->getCellByColumnAndRow($k, $this->firstDataRowNum + $j);
					//当前单元格的值
					$strCurrentCellValue = trim($objCurrentCell->getValue());
					//将当前用户（对象）的值转化为数组
					$arrUser = $User->toarray();
					//去除模板键前后中拨号，转化为字段名
					$templateKey = $this->templateRow[$this->sheetName][$k];

					//插入分页符
					if (!strlen($lastCellValue)) {
						$lastCellValue = $User->$pageBreakField;
					}
					if (strlen($lastCellValue) && $lastCellValue != $User->$pageBreakField) {
						$this->sheet->setBreak("A" . ($j + $this->firstDataRowNum - 1), \PHPExcel_Worksheet::BREAK_ROW);
					}
					$lastCellValue = $User->$pageBreakField;
				} //for
			}

			$j++;
		}
	}
}