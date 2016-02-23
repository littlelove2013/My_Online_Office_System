<?php
	header("Content-Type:text/html;charset=utf-8");
?>
<?php
//该文件用于写获取单个数据表名及其编号的快速函数
//
//include("inc/auth.php");
include("inc/DB/Mode.php");
$load=new Mode('group');
/*
$load->setOptionsField();
$load->setOptionsWhere("pro_manage_dept_name='生科院'");
print_r($load->select());
*/
//echo "Hello World";
//多表查询
function getTableM($table,$field,$where=''){
	global $load;
	$purpose_field=$field;
	$purpose_table=$table;
	$load->setOptionsField($purpose_field);
	$load->setOptionsTable($purpose_table);
	$load->setOptionsWhere($where);
	return $load->select();
}
//不带检查的插入函数
function insertTableM($table,$data){
	global $load;
	//判断$data是否正常
	if(!is_array($data)||is_array(current($data))){
		echo "getMysqlFun.php:".__LINE__.":请输入正常数据<p>";
		return false;
	}
	//print_r($data);
	$purpose_table=$table;
	$load->setOptionsTable($purpose_table);
	//重置域
	$load->setOptionsField();
		//插入字段
	$load->setOptionsWhere();
		//echo "插入中....<br>";
	$data[0]= $load->insert($data);
	$data[1]= $load->getLastInsId();
	
	return $data;
}
//自定义
function updateTableM($table,$data,$where){
	global $load;
	//判断$data是否正常
	if(!is_array($data)||is_array(current($data))){
		echo "getMysqlFun.php:".__LINE__.":请输入正常数据<p>";
		return false;
	}
	//print_r($data);
	$purpose_table=$table;
	$load->setOptionsTable($purpose_table);
	//重置域
	$load->setOptionsField();
	
	$load->setOptionsWhere($where);
	//$where = "purpose_name='".current($data)."'";
	//$load->setOptionsWhere($where);
	return $load->update($data);
}
//自定义where
function deleteTableM($table,$where){
	global $load;
	//echo "id:".$id."<p>";
	$purpose_table=$table;
	$load->setOptionsTable($purpose_table);
	//echo "table:".$purpose_table."<p>";
	$load->setOptionsWhere($where);
	//echo "<p>";
	//print_r($load->getOptions());
	return $load->delete();
}

//单表查询
function getTable($table,$field,$id=''){
	global $load;
	$purpose_field=$field;
	$purpose_table=$table;
	$where='';
	if($id!=''&&is_numeric($id)){
		$where=$table.'_id='.$id;
	}
	$load->setOptionsField($purpose_field);
	$load->setOptionsTable($purpose_table);
	$load->setOptionsWhere($where);
	return $load->select();
}

function insertTable($table,$data){
	global $load;
	//判断$data是否正常
	if(!is_array($data)||is_array(current($data))){
		echo "getMysqlFun.php:".__LINE__.":请输入正常数据<p>";
		return false;
	}
	//print_r($data);
	$purpose_table=$table;
	$load->setOptionsTable($purpose_table);
	//重置域
	$load->setOptionsField();
	//判断该字段是否已经存在
	$where = $table."_name='".current($data)."'";
	$load->setOptionsWhere($where);
	$tmpData=$load->select();
	if(!empty($tmpData)){
		echo "该字段已存在<p>";
		return false;
	}
	else{
		//插入字段
		$load->setOptionsWhere();
		//echo "插入中....<br>";
		return $load->insert($data);
	}
}

function deleteTable($table,$id){
	global $load;
	if(!is_numeric($id)){
		echo "getMysqlFun.php:".__LINE__.":请输入正常数据<p>";
		return false;
	}
	//echo "id:".$id."<p>";
	$purpose_table=$table;
	$load->setOptionsTable($purpose_table);
	//echo "table:".$purpose_table."<p>";
	$where = $table."_id=".$id;
	$load->setOptionsWhere($where);
	//echo "<p>";
	//print_r($load->getOptions());
	return $load->delete();
}

function updateTable($table,$data,$id){
	global $load;
	//判断$data是否正常
	if(!is_array($data)||is_array(current($data))||!is_numeric($id)){
		echo "getMysqlFun.php:".__LINE__.":请输入正常数据<p>";
		return false;
	}
	//print_r($data);
	$purpose_table=$table;
	$load->setOptionsTable($purpose_table);
	//重置域
	$load->setOptionsField();
	//判断该字段是否已经存在
	
	
	$where = $table."_id=".$id;
	$load->setOptionsWhere($where);
	//$where = "purpose_name='".current($data)."'";
	//$load->setOptionsWhere($where);
	return $load->update($data);
}

function getPurposeName(){
	global $load;
	$purpose_field="purpose_id as 'id',purpose_name as 'name'";
	$purpose_table='purpose';
	$load->setOptionsField($purpose_field);
	$load->setOptionsTable($purpose_table);
	$load->setOptionsWhere();
	return $load->select();
}
function deletePurposeName($id){
	global $load;
	if(!is_numeric($id)){
		echo "getMysqlFun.php:".__LINE__.":请输入正常数据<p>";
		return false;
	}
	//echo "id:".$id."<p>";
	$purpose_table='purpose';
	$load->setOptionsTable($purpose_table);
	//echo "table:".$purpose_table."<p>";
	$where = "purpose_id=".$id;
	$load->setOptionsWhere($where);
	//echo "<p>";
	//print_r($load->getOptions());
	return $load->delete();
}
function insertPurposeName($data){
	global $load;
	//判断$data是否正常
	if(!is_array($data)||is_array(current($data))){
		echo "getMysqlFun.php:".__LINE__.":请输入正常数据<p>";
		return false;
	}
	//print_r($data);
	$purpose_table='purpose';
	$load->setOptionsTable($purpose_table);
	//重置域
	$load->setOptionsField();
	//判断该字段是否已经存在
	$where = "purpose_name='".current($data)."'";
	$load->setOptionsWhere($where);
	$tmpData=$load->select();
	if(!empty($tmpData)){
		echo "该字段已存在<p>";
		return false;
	}
	else{
		//插入字段
		$load->setOptionsWhere();
		//echo "插入中....<br>";
		return $load->insert($data);
	}
}
function updatePurposeName($data,$id){
	global $load;
	//判断$data是否正常
	if(!is_array($data)||is_array(current($data))||!is_numeric($id)){
		echo "getMysqlFun.php:".__LINE__.":请输入正常数据<p>";
		return false;
	}
	//print_r($data);
	$purpose_table='purpose';
	$load->setOptionsTable($purpose_table);
	//重置域
	$load->setOptionsField();
	//判断该字段是否已经存在
	$where = "purpose_id=".$id;
	$load->setOptionsWhere($where);
	//$where = "purpose_name='".current($data)."'";
	//$load->setOptionsWhere($where);
	return $load->update($data);
}

function getProManageDeptName(){
	global $load;
	$manage_dept_field="pro_manage_dept_id as 'id',pro_manage_dept_name as 'name'";
	$manage_dept_table='pro_manage_dept';
	$load->setOptionsField($manage_dept_field);
	$load->setOptionsTable($manage_dept_table);
	$load->setOptionsWhere();
	//$data=$load->select();
	//print_r($data);
	return $load->select();
}
function insertProManageDeptName($data){
	global $load;
	//判断$data是否正常
	if(!is_array($data)||is_array(current($data))){
		echo "getMysqlFun.php:".__LINE__.":请输入正常数据<p>";
		return false;
	}
	$manage_dept_table='pro_manage_dept';
	$load->setOptionsTable($manage_dept_table);
	//重置域
	$load->setOptionsField();
	//判断该字段是否已经存在
	$where = "pro_manage_dept_name='".current($data)."'";
	$load->setOptionsWhere($where);
	$tmpData=$load->select();
	if(!empty($tmpData)){
		echo "该字段已存在<p>";
		return false;
	}
	else{
		//插入字段
		$load->setOptionsWhere();
		return $load->insert($data);
	}
}

function getFundrisePersonName(){
	global $load;
	$fundrise_person_field="fundrise_person_id as 'id',fundrise_person_name as 'name'";
	$fundrise_person_table='fundrise_person';
	$load->setOptionsField($fundrise_person_field);
	$load->setOptionsTable($fundrise_person_table);
	$load->setOptionsWhere();
	return $load->select();
}
function insertFundrisePersonName($data){
	global $load;
	//判断$data是否正常
	if(!is_array($data)||is_array(current($data))){
		echo "getMysqlFun.php:".__LINE__.":请输入正常数据<p>";
		return false;
	}
	//print_r($data);
	$fundrise_person_table='fundrise_person';
	$load->setOptionsTable($fundrise_person_table);
	//重置域
	$load->setOptionsField();
	//判断该字段是否已经存在
	$where = "fundrise_person_name='".current($data)."'";
	$load->setOptionsWhere($where);
	$tmpData=$load->select();
	if(!empty($tmpData)){
		echo "该字段已存在<p>";
		return false;
	}
	else{
		//插入字段
		$load->setOptionsWhere();
		//echo "插入中....<br>";
		return $load->insert($data);
	}
}
function getProjectTypeName(){
	global $load;
	$project_type_field="project_type_id as 'id',project_type_name as 'name' ";
	$project_type_table='project_type';
	$load->setOptionsField($project_type_field);
	$load->setOptionsTable($project_type_table);
	$load->setOptionsWhere();
	return $load->select();
}
//插入数据
function insertProjectTypeName($data){
	global $load;
	//判断$data是否正常
	if(!is_array($data)||is_array(current($data))){
		echo "getMysqlFun.php:".__LINE__.":请输入正常数据<p>";
		return false;
	}
	//print_r($data);
	$project_type_table='project_type';
	$load->setOptionsTable($project_type_table);
	//重置域
	$load->setOptionsField();
	//判断该字段是否已经存在
	$where = "project_type_name='".current($data)."'";
	$load->setOptionsWhere($where);
	$tmpData=$load->select();
	if(!empty($tmpData)){
		echo "该字段已存在<p>";
		return false;
	}
	else{
		//插入字段
		$load->setOptionsWhere();
		//echo "插入中....<br>";
		return $load->insert($data);
	}
}
function getDonateTypeName(){
	global $load;
	$donate_type_field="donate_type_id as 'id',donate_type_name as 'name' ";
	$donate_type_table='donate_type';
	$load->setOptionsField($donate_type_field);
	$load->setOptionsTable($donate_type_table);
	$load->setOptionsWhere();
	return $load->select();
}
function insertDonateTypeName($data){
	global $load;
	//判断$data是否正常
	if(!is_array($data)||is_array(current($data))){
		echo "getMysqlFun.php:".__LINE__.":请输入正常数据<p>";
		return false;
	}
	//print_r($data);
	$donate_type_table='donate_type';
	$load->setOptionsTable($donate_type_table);
	//重置域
	$load->setOptionsField();
	//判断该字段是否已经存在
	$where = "donate_type_name='".current($data)."'";
	$load->setOptionsWhere($where);
	$tmpData=$load->select();
	if(!empty($tmpData)){
		echo "该字段已存在<p>";
		return false;
	}
	else{
		//插入字段
		$load->setOptionsWhere();
		//echo "插入中....<br>";
		return $load->insert($data);
	}
}
//获取客户函数
function getPersonalName(){
	global $load;
	$field="personal_id as 'id',personal_name as 'name',0 as 'type'";
	$table='personal';
	$load->setOptionsField($field);
	$load->setOptionsTable($table);
	$load->setOptionsWhere();
	return $load->select();
}
function getGroupName(){
	global $load;
	$field="group_id as 'id',group_name as 'name',1 as 'type'";
	$table='m_group';
	$load->setOptionsField($field);
	$load->setOptionsTable($table);
	$load->setOptionsWhere();
	return $load->select();
}
function getCompanyName(){
	global $load;
	$field="company_id as 'id',company_name as 'name',2 as 'type'";
	$table='company';
	$load->setOptionsField($field);
	$load->setOptionsTable($table);
	$load->setOptionsWhere();
	return $load->select();
}
function getIntercourseName(){
	global $load;
	$field="intercourse_id as 'id',intercourse_theme as 'theme'";
	$table='intercourse';
	$load->setOptionsField($field);
	$load->setOptionsTable($table);
	$load->setOptionsWhere();
	return $load->select();
}
/*
echo "<p>";
print_r(getProManageDeptName());

echo "<p>";
$data=array('生科院');
$isInsert=insertProManageDeptName($data);
print_r($isInsert);
if($isInsert)
{
	echo "插入数据成功<p>";
}else{
	echo "插入数据失败或者数据格式不正确<p>";
}

echo "<p>";
print_r(getFundrisePersonName());
echo "<p>";
$data=array('徐志江',1,'022-123345');
$isInsert=insertFundrisePersonName($data);
print_r($isInsert);
if($isInsert)
{
	echo "插入数据成功<p>";
}else{
	echo "插入数据失败或者数据格式不正确<p>";
}
echo "<p>";
print_r(getProjectTypeName());
echo "<p>";
$data=array('助学金');
$isInsert=insertProjectTypeName($data);
print_r($isInsert);
if($isInsert)
{
	echo "插入数据成功<p>";
}else{
	echo "插入数据失败或者数据格式不正确<p>";
}
echo "<p>";
print_r(getDonateTypeName());
echo "<p>";
$data=array('物品');
$isInsert=insertDonateTypeName($data);
print_r($isInsert);
if($isInsert)
{
	echo "插入数据成功<p>";
}else{
	echo "插入数据失败或者数据格式不正确<p>";
}
echo "<p>";

echo "<p>";
print_r(getPersonalName());
echo "<p>";
print_r(getGroupName());
echo "<p>";
print_r(getCompanyName());
echo "<p>";
print_r(getIntercourseName());
*/
	/*二维数组按指定的键值排序*/
	function array_sort($array,$keys,$type='asc'){
		if(!isset($array) || !is_array($array) || empty($array)){
  			return '';
 		}
 		if(!isset($keys) || trim($keys)==''){
 	 		return '';
 		}
 		if(!isset($type) || $type=='' || !in_array(strtolower($type),array('asc','desc'))){
  			return '';
 		}
	
 		$keysvalue=array();
 		foreach($array as $key=>$val){
  			$val[$keys] = str_replace('-','',$val[$keys]);
  			$val[$keys] = str_replace(' ','',$val[$keys]);
  			$val[$keys] = str_replace(':','',$val[$keys]);
  			$keysvalue[$key] =$val[$keys];
 		}

 		asort($keysvalue); //key值排序
 		reset($keysvalue); //指针重新指向数组第一个

 		foreach($keysvalue as $key=>$vals) {
  			$keysort[] = $key;
 		}
 		$keysvalue = array();
 		$count=count($keysort);
		//echo __LINE__.":进入排列<p>";
 		if(strtolower($type) != 'asc'){
			//echo __LINE__.":进入降序排列<p>";
  			for($i=$count-1; $i>=0; $i--) {
   			$keysvalue[] = $array[$keysort[$i]];
  		}
 		}else{
  			for($i=0; $i<$count; $i++){
   				$keysvalue[] = $array[$keysort[$i]];
  			}
 		}
 		return $keysvalue;
	}
	//筛选出一个二维数组中某一个键对应的值
	//如果键值在$key处的值是4value时，则选上，不是则放弃
	function array_select($data,$key,$value){
		if($value=='all'){
			return $data;
		}
		$tmp=array();
		foreach($data as $keys=>$values){
			if($values[$key]==$value){
				//则该条目保留
				$tmp[$keys]=$values;
			}
			//否则就不保留
		}
		return $tmp;
	}
	//筛选出一个二维数组中某一个键对应的值范围
	//如果键值在$key处的值在up和down之间时，则选上，不是则放弃
	function array_selectUpDown($data,$key,$up,$down){
		//如果$up或者$down为0，则表示不做判断
		$tmp=array();
		foreach($data as $keys=>$values){
			if(($values[$key]<=$up||$up==0) && ($values[$key]>=$down||$down==0)){
				//则该条目保留
				$tmp[$keys]=$values;
			}
			//否则就不保留
		}
		return $tmp;
	}
	
	//把时间改成字符串，把客户改成字符串
	function setTimeToStr(&$data,$key){
		foreach($data as $keys => $values){
			//print_r($values);
			$values[$key]= date("Y-m-d H:i:s",$values[$key]);
			$data[$keys]=$values;
			//print_r($values);
		}
	}
	
	//echo "测试是否正确载入本函数<p>";
?>