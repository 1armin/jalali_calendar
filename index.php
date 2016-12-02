<html>
<head>   
<style type="text/css">
div#calendar{
  margin:0px auto;
  padding:0px;
  width: 602px;
  font-family:Helvetica, "Times New Roman", Times, serif;
  direction: rtl;
}
 
div#calendar div.box{
    position:relative;
    top:0px;
    left:0px;
    width:100%;
    height:40px;
    background-color:   #787878 ;      
}
 
div#calendar div.header{
    line-height:40px;  
    vertical-align:middle;
    position:absolute;
    left:11px;
    top:0px;
    width:582px;
    height:40px;   
    text-align:center;
}
 
div#calendar div.header a.prev,div#calendar div.header a.next{ 
    position:absolute;
    top:0px;   
    height: 17px;
    display:block;
    cursor:pointer;
    text-decoration:none;
    color:#FFF;
}
 
div#calendar div.header span.title{
    color:#FFF;
    font-size:18px;
}
 
 
div#calendar div.header a.prev{
    right:0px;
}
 
div#calendar div.header a.next{
    left:0px;
}
 
 
 
 
/*******************************Calendar Content Cells*********************************/
div#calendar div.box-content{
    border:1px solid #787878 ;
    border-top:none;
}
 
 
 
div#calendar ul.label{
    float:left;
    margin: 0px;
    padding: 0px;
    margin-top:5px;
    margin-left: 5px;
}
 
div#calendar ul.label li{
    margin:0px;
    padding:0px;
    margin-right:5px;  
    float:right;
    list-style-type:none;
    width:80px;
    height:40px;
    line-height:40px;
    vertical-align:middle;
    text-align:center;
    color:#000;
    font-size: 15px;
    background-color: transparent;
}
 
 
div#calendar ul.dates{
    float:left;
    margin: 0px;
    padding: 0px;
    margin-left: 5px;
    margin-bottom: 5px;
}
 
/** overall width = width+padding-right**/
div#calendar ul.dates li{
    margin:0px;
    padding:0px;
    margin-right:5px;
    margin-top: 5px;
    line-height:80px;
    vertical-align:middle;
    float:right;
    list-style-type:none;
    width:80px;
    height:80px;
    font-size:25px;
    background-color: #DDD;
    color:#000;
    text-align:center; 
}
div#calendar ul.dates li.disabled{
	opacity: .4;
}
div#calendar ul.dates li.end{
	color: red;
}
div#calendar ul.dates li.mask{
	opacity: .4;
}
:focus{
    outline:none;
}
 
div.clear{
    clear:both;
}
</style>
</head>
<body>
<?php
include 'calendar.php';

if(isset($_GET['year'])) {
	$year = $_GET['year'];
}
else {
	$year = null;
}


if(isset($_GET['month'])) {
	$month = $_GET['month'];
}
else {
	$month = null;
}

$calendar = new Calendar();
 
echo $calendar->show($year, $month);
?>
</body>
</html>
