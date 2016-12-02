<?php
/**
*@author  Armin Mohammadian
*@email   me@1armin.com
*@website http://1armin.com
**/
class Calendar {  
     
    /**
     * Constructor
     */
    public function __construct(){     
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }
     
    /********************* PROPERTY ********************/  
    private $dayLabels = array("شنبه","یکشنبه","دوشنبه","سه شنبه","چهارشنبه","پنجشنبه","جمعه");
     
    private $thisYear=0;
     
    private $thisMonth=0;
     
    private $thisDay=0;

    private $currentYear=0;
     
    private $currentMonth=0;
     
    private $currentDay=0;
     
    private $currentDate=null;
     
    private $daysInMonth=0;
     
    private $naviHref= null;
     
    /********************* PUBLIC **********************/  
        
    /**
    * print out the calendar
    */
    public function show($year = null, $month = null) {

        $fmt = new IntlDateFormatter("en_US@calendar=persian", IntlDateFormatter::FULL,
        IntlDateFormatter::FULL, 'Asia/Tehran', IntlDateFormatter::TRADITIONAL);

        $fmt->setPattern("Y");
        $thisyear = $fmt->format(time());
    
        $fmt->setPattern("M");
        $thismonth = $fmt->format(time());

        $fmt->setPattern("d");
        $thisday = $fmt->format(time());



        $year = ($year == null) ? $thisyear : $year;
        
        $month = ($month == null) ? $thismonth : $month;



        $this->thisYear=$thisyear;
         
        $this->thisMonth=$thismonth;

        $this->thisDay=$thisday;
         
        $this->currentYear=$year;
         
        $this->currentMonth=$month;
         
        $this->daysInMonth=$this->_daysInMonth($year,$month);  
         
        $content='<div id="calendar">'.
                        '<div class="box">'.
                        $this->_createNavi().
                        '</div>'.
                        '<div class="box-content">'.
                                '<ul class="label">'.$this->_createLabels().'</ul>';   
                                $content.='<div class="clear"></div>';     
                                $content.='<ul class="dates">';    
                                 
                                $weeksInMonth = $this->_weeksInMonth($year,$month);
                                // Create weeks in a month
                                for( $i=0; $i<$weeksInMonth; $i++ ){
                                     
                                    //Create days in a week
                                    for($j=1;$j<=7;$j++){
                                        $content.=$this->_showDay($i*7+$j);
                                    }
                                }
                                 
                                $content.='</ul>';
                                 
                                $content.='<div class="clear"></div>';     
             
                        $content.='</div>';
                 
        $content.='</div>';
        return $content;   
    }
     
    /********************* PRIVATE **********************/ 
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber){
         
        if($this->currentDay==0){
             
            $monthStartDay = $this->_monthStartDay($this->currentYear,$this->currentMonth);
            
            $monthStartDay++;
            
            if(intval($cellNumber) == intval($monthStartDay)){
                 
                $this->currentDay=1;
                 
            }
        }
         
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
             
            $this->currentDate = $this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay);
             
            $cellContent = $this->currentDay;
             
            $this->currentDay++;

            
             
        }else{
             
            $this->currentDate =null;
 
            $cellContent=null;
        }

        $disabled=(($this->currentYear==$this->thisYear)&&($this->currentMonth==$this->thisMonth)&&($this->currentDay<$this->thisDay))?true:false;     
         
        return '<li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?'start':($cellNumber%7==0?'end':' ')).($cellContent==null?' mask':'').($disabled?' disabled':'').'">'.$cellContent.'</li>';
    }
    /**
    * create navigation
    */
    private function _createNavi(){
         
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
         
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
         
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
         
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
         
        return
            '<div class="header">'.
                '<a class="prev" href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">« قبلی</a>'.
                    '<span class="title">'.$this->currentMonth.' - '.$this->currentYear.'</span>'.
                '<a class="next" href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">بعدی »</a>'.
            '</div>';
    }
         
    /**
    * create calendar week labels
    */
    private function _createLabels(){  
                 
        $content='';
         
        foreach($this->dayLabels as $index=>$label){
             
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
 
        }
         
        return $content;
    }
     


    /**
    * calculate month start day
    */
    private function _monthStartDay($year, $month){

        $fmt = new IntlDateFormatter("en_US@calendar=persian", IntlDateFormatter::FULL,
            IntlDateFormatter::FULL, 'Asia/Tehran', IntlDateFormatter::TRADITIONAL);

        // convert date from jalali to gregorian 
        $gregorian = $this->jalali_to_gregorian($year,$month,01,'-');

        // get month start day
        $date = new DateTime($gregorian);

        $fmt->setPattern("e");

        $monthStartDay = $fmt->format($date);

        $monthStartDay = ($monthStartDay == 7) ? 0 : $monthStartDay ;

        return $monthStartDay;

    }
     
     
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($year, $month){

        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($year,$month);

        $monthStartDay = $this->_monthStartDay($year,$month);
        
        $numOfweeks = ceil(($daysInMonths + $monthStartDay) / 7);

        return $numOfweeks;
    }
 
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($year, $month) {

        if (intval($month) == 12) {
            $res = (intval($year) + 2346) * 0.24219858156;
            if ($res <= 0.24219858156) {
                return 30;
            }
            else {
                return 29;
            }
        }
        elseif(intval($month) <= 6) {
            return 31;
        }
        elseif (intval($month) >= 7) {
             return 30;
        } 

    }


    private function jalali_to_gregorian($jy,$jm,$jd,$mod=''){
         $gy=($jy<=979)?621:1600;
         $jy-=($jy<=979)?0:979;
         $days=(365*$jy) +(((int)($jy/33))*8) +((int)((($jy%33)+3)/4)) 
        +78 +$jd +(($jm<7)?($jm-1)*31:(($jm-7)*30)+186);
         $gy+=400*((int)($days/146097));
         $days%=146097;
         if($days > 36524){
          $gy+=100*((int)(--$days/36524));
          $days%=36524;
          if($days >= 365)$days++;
         }
         $gy+=4*((int)(($days)/1461));
         $days%=1461;
         $gy+=(int)(($days-1)/365);
         if($days > 365)$days=($days-1)%365;
         $gd=$days+1;
         foreach(array(0,31,(($gy%4==0 and $gy%100!=0) or ($gy%400==0))?29:28 
        ,31,30,31,30,31,31,30,31,30,31) as $gm=>$v){
          if($gd<=$v)break;
          $gd-=$v;
         }
         return($mod=='')?array($gy,$gm,$gd):$gy.$mod.$gm.$mod.$gd; 
    }
     
}
