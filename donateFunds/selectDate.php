<?php
	header("Content-Type:text/html;charset=utf8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>selectDate</title>
</head>

<body>
	<div id='selecttime' style="text-align:center">
    	<p align="left">请选择日期:</p>
        起始日期:<input type="date" id="startTime" pattern="起始日期" />
        <br/>
        <br/>
        结束日期:<input type="date" id="endTime" pattern="结束日期" />
        <p>
        	<input type="button" id="submit" value="筛&nbsp;选" onclick="selectDate()" />
        </p>
       		<font color="#FF0000" size="1.1em" >注：</font>
            <font color="#0000FF" size="1em">IE浏览器不支持日期框，如您使用IE浏览器，请按如下格式:
            					<br/>(2012-10-10 10:10:22)
                                </font>
                         <br/>
             <font color="#0000FF" size="1em">谷歌等支持日期框的浏览器，如您务必填上日期和<font color="#FF0000">时间</font>
                                </font>               
    </div>
</body>
<script language="javascript">
	//设置开始的日期时间
	document.getElementById('startTime').value=window.opener.getStartDate();
	document.getElementById('endTime').value=window.opener.getEndDate();

	function selectDate(){
		var startTime=document.getElementById('startTime').value;
		var endTime=document.getElementById('endTime').value;
		
		//document.getElementById('selecttime').innerHTML=startTime+"-->"+endTime;
		var html="dealWithFunds.php?startTime="+startTime+"&endTime="+endTime;
		//window.location.href="test1.php?startTime="+startTime+"&endTime="+endTime;
		//document.write('资金展示');
		//window.open(html,window.opener.name);
		//window.open(html,'资金展示');
		//window.close();
		
		window.opener.open(html,'_self');
		window.close();
	}
</script>
</html>
