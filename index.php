<?PHP
	header("Content-Type:text/html;charset=utf-8");
	include_once("http://172.24.184.3/inc/auth.php");
	$str = "欢迎光临<p>";
	$arr=get_defined_vars();
	
	function get_defined_vars_dis($arr){
		foreach($arr as $keys=>$values){
			if(is_array($values)){
				echo $keys.":<br>";
				foreach($values as $key=>$value){
					if(is_array($values)){
						echo $key.":<br>";
						foreach($value as $ke=>$valu){
							echo "&nbsp;&nbsp;&nbsp;&nbsp;".$ke.":".$valu."<br>";
						}
					}else{
						echo "&nbsp;&nbsp;".$key.":".$value."<br>";
					}
				}
			}else{
				echo $keys.":".$values."<br>";
			}
		}
		echo "<p>";
	}
	get_defined_vars_dis($arr);
	
?>