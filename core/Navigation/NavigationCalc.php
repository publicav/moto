<?php
namespace Navigation;

class NavigationCalc {
	const DATE_B = 'date_b=';
	const SEPAR_DATE = '-';
	protected $month = [['Январь',  'Янв', '01'],
						['Февраль', 'Фев', '02'],
						['Март',	'Мрт', '03'],
						['Апрель', 	'Апр', '04'],
						['Май',		'Май', '05'],
						['Июнь',	'Июн', '06'],
						['Июль',	'Июн', '07'],
						['Август',	'Авг', '08'],
						['Cентябрь','Сен', '09'],
						['Октябрь',	'Окт', '10'],
						['Ноябрь',	'Нбр', '11'],
						['Декабрь',	'Дек', '12']
						];	
	protected $classHTMLDefault = ['navigator', 'pagelink', 'pagecurrent'];
	protected $fileAction, $dt, $dtMonth, $param = '';
	private $nav;
	protected $url, $colum, $link;
	protected $dtPrevYear, $dtNextYear, $fullDate;
	protected $key, $value;

	
	function __construct( $fileAction, $dt, $param ) {
		$this->setFileAction( $fileAction );
 		$this->setParam( $param );		
		$this->dt = new \DateTime( $dt );
        $this->dtPrevYear =  new \DateTime( $dt );
        $this->dtNextYear =   new \DateTime( $dt );
		
        $this->dtPrevYear->sub(new \DateInterval('P1Y'));
        $this->dtNextYear->add(new \DateInterval('P1Y'));
	}
	public function __set( $key, $value ){
		if ( $key == 'classHTML') $this->classHTMLDefault = $value;
	}
	public function getNavigator() {
   // if ($total>$c_page) $tek_page = "<span class='pagecurrent'>$pg</span>";
		$this->setFullDate( $this->getDTPrevYear(), '01', '01' );
		$this->setLink( $this->getUrl(), $this->getDTPrevYear(), $this->getDTPrevYear() );

		$this->nav = '<div class="' . $this->getClassHTMLMain() . '">
						<p>
							<span class="'. $this->getClassHTMLPageLink() . '">' . $this->getLink() . "</span>";
		foreach( $this->month as $this->colum ) {
			$this->setFullDate( $this->getDTYear(), $this->getMonthNumber(), $this->getDTDay() );
			$this->dtMonth = new \DateTime ( $this->getFullDate() );
			$this->setLink( $this->getUrl(), $this->getTitleMonthFull(), $this->getMonthShort() );
			if ($this->dt != $this->dtMonth) {
				$this->nav .= '<span class="'. $this->getClassHTMLPageLink() . '">' . $this->getLink() . '</span>';
			} else {
				$this->nav .= '<span class="' . $this->getClassHTMLPageCurrent() . '">' . $this->getMonthShort() . '</span>';
			}

		}	
		$this->setFullDate( $this->getDTNextYear(), '01', '01' );
		$this->setLink( $this->getUrl(), $this->getDTNextYear(), $this->getDTNextYear() );
		$this->nav .= '
							<span class="'. $this->getClassHTMLPageLink() . '">' . $this->getLink() . '</span>
						</p>
					 </div>';
		return $this->nav;
	}
	protected function getDTPrevYear(){
		return $this->dtPrevYear->format('Y');
	}
	protected function getDTNextYear(){
		return $this->dtNextYear->format('Y');
	}
	protected function getDTYear(){
		return $this->dt->format('Y');
	}
	protected function getDTDay(){
		return $this->dt->format('d');
	}
	protected function getFileAction(){
		return $this->fileAction;
	}
	protected function setFileAction( $fileAction ){
		$this->fileAction = $fileAction;
	}
	
	protected function setParam( $param ){
		foreach ( $param as $this->key => $this->value ) {
			$this->param .= '&' . $this->key . '=' . $this->value;
		}
	}
	protected function getParam(){
		return $this->param;
	}
	protected function getUrl(){
		return './' . $this->getFileAction() . '?' . self::DATE_B . $this->getFullDate() . $this-> getParam();
	}
	private function getTitleMonthFull(){
		return $this->colum[0];
	}
	private function getMonthShort(){
		return $this->colum[1];
	}
	private function getMonthNumber(){
		return $this->colum[2];
	}
	protected function setFullDate( $year, $motht, $day ){
		$this->fullDate =  $year . self::SEPAR_DATE . $motht . self::SEPAR_DATE . $day;
	}
	protected function getFullDate(){
		return $this->fullDate;
	}
	protected function setLink($url, $title, $text){
		$this->link = '<a href="' . $url . '" title="' . $title  . '">' .$text . '</a>';
	}
	protected function getLink(){
		return $this->link;
	}
	protected function getClassHTMLMain(){
		return $this->classHTMLDefault[0];
	}
	protected function getClassHTMLPageLink(){
		return $this->classHTMLDefault[1];
	}
	protected function getClassHTMLPageCurrent(){
		return $this->classHTMLDefault[2];
	}
	

}

