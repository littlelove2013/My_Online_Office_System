<?php
	header("Content-Type:text/html;charset=utf-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加新闻</title>
</head>
<?php 
//附加函数库
include("../../../Tools/getMysqlDataFun.php");


//此处获取存在id的数据库内容
if(!empty($_GET[id])){
	$news=current(getTable('news','',$_GET[id]));
	if(empty($news)){
		echo "
			<script language='javascript'>
				alert('不存在此条记录！');
				window.location.href('index.php');
			</script>
		";
	}
	//print_r($news);
}
?>
<body>

<form accept-charset="UTF-8" action="" id="new_project_news" method="post">
<div align="center">
<div align="center" style="margin-top:100px;border:thin dotted #000000; width:300px; height:300px; padding:50px">
  <div >
    <label for="project_news_title">标题</label><br>
    <input id="project_news_title" name="project_news[news_name]" type="text" value="<?php echo $news[news_name] ?>">
    <input id='news_id' name='news_id' type="hidden" value="<?php echo $_GET[id] ?>">
  </div>
  <div >
    <label for="project_news_link">新闻链接</label><br>
    <input type="text" id="project_news_link" name="project_news[news_link]" value="<?php echo $news[news_link] ?>" />
  </div>
  <div >
    <label for="project_news_comment">备注</label><br>
    <textarea id="project_news_comment" name="project_news[news_remark]" ><?php echo $news[news_remark] ?></textarea>
  </div>
  <div>
    <input type="submit"  <?php 
																if(empty($_GET[id])){
																	echo "
																	name='insert' value='添加'
																	"; 
																}else{
																	echo "
																	name='update' value='修改'
																	"; 
																}
								?>/>
  </div>
 </div>
 </div>
 
</form>
</body>
<?php
	if($_POST[insert]=='添加'){
		//做添加操作
		//$data=$_POST[project_news];
		$data[news_name]=$_POST[project_news][news_name];
		$data[news_link]=$_POST[project_news][news_link];
		if(!empty($data)){
			$data[news_date]=time();
			$data[news_remark]=$_POST[project_news][news_remark];
			print_r($data);
			$result=insertTable('news',$data);
			if($result){
				//插入成功
					echo "
					<script language='javascript'>
						alert('添加成功');
						window.location.href('index.php');
					</script>
					";
			}else{
				//插入失败
				echo "
					<script language='javascript'>
						alert('添加失败');
						window.location.href('index.php');
					</script>
					";
			}
		}else{
			echo "
					<script language='javascript'>
						alert('添加失败\n请输入正确的文档');
						window.location.href('insertUpdate.php');
					</script>
					";
		}
	}
	if($_POST[update]=='修改'){
		//做修改操作
		$data=$_POST[project_news];
		if(is_numeric($_GET[id])&&!empty($data)){
			//$data=array('news_name'=>$_POST[approved_name]);
			$data[news_date]=time();
			//print_r($data);
			$result=updateTable('news',$data,$_GET[id]);
			if($result){
				//修改成功
					echo "
					<script language='javascript'>
						alert('修改成功');
						window.location.href('index.php');
					</script>
					";
			}else{
				//插入失败
				echo "
					<script language='javascript'>
						alert('修改失败');
						window.location.href('index.php');
					</script>
					";
			}
		}else{
			echo "
					<script language='javascript'>
						alert('别乱搞！');
						window.location.href('insertUpdate.php');
					</script>
					";
		}
	}
?>
</html>