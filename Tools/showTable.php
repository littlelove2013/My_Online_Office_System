<link href="CSS/testTableCss.css" rel="stylesheet" type="text/css">
<?php
	class showTable{
		private $data=array();
		private $head=array();
		private $debug=false;
		
		public function __construct($data){
			$this->debug=false;
			$this->setData($data);
			$this->setHead();
		}
		
		public function setData($data){
			//如果为一维数组，则确定
			if(is_array($data)&&!is_array(current($data))){
				$this->data=$data;
			}else{
				echo "showTable类里:".__LINE__.":数据格式出错<p>";
			}
		}
		public function setHead($head=''){
			if($head==''){
				$this->head=array("属性名","属性值");
			}else{
				if(is_array($head)&&!is_array(current($head))&&count($head)==2){
					$this->head=$head;
				}else{
					echo "showTable类里:".__LINE__.":数据格式出错<p>";
					$this->head=array("属性名","属性值");
				}
			}
		}
		public function showHead(){
			if(!empty($this->head)){
				echo "<tr>
					 	<th>".$this->head[0]."</th>
						<th>".$this->head[1]."</th>
					 </tr>
					 ";
			}else{
				echo "showTable类里:".__LINE__.":数据格式出错<p>";
			}
		}
		public function showData($key,$value){
			//echo "showData():".$key.":".$value."<br/>";
			echo "<tr>
				 	<th>".$key."</th>
					<td>".$value."</td>
					</tr>";
		}
		public function Display($tableName=''){
			echo "<table id='showPage'>";
			//输出表名
			if(!empty($tableName)){
				echo "<caption>
							".$tableName."
        				</caption>";
			}
			//输出头
			$this->showHead();
			//输出所有行
			foreach($this->data as $key=>$value){
				//echo $key.":".$value."<br/>";
				$this->showData($key,$value);
			}
			echo "</table>";
			
		}
	}
	/*
	$data=array("名字"=>"龚成","籍贯"=>"重庆");
	$test=new showTable($data);
	$test->Display("我的信息");
	*/
?>
