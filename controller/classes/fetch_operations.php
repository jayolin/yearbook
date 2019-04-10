<?php

	class Fetch{
		
		function fetch_from_table($table,$arr_check,$arr_val,$arr_fields){
			
			$arr_parent = array();
			$mysql_query = "SELECT * FROM `ECE_CLASS_OF_2017`.`$table`";
			foreach($arr_check as $check_key => $check){
				
				$check_val = $arr_val[$check_key];
				if($check_key == 0){
					$mysql_query .= " WHERE `$check` = '$check_val'";
				}
				else{
					$mysql_query .= " AND `$check` = '$check_val'";
				}
				
			}
			
			
			$mysql_query = mysql_query($mysql_query);
			while($fetch_result = mysql_fetch_assoc($mysql_query)){
				
				$arr_new_user = array();
				foreach($arr_fields as $field){
					$arr_new_user[$field] = $fetch_result[$field];
					
				}
				array_push($arr_parent,$arr_new_user);
				
			}
			
			
			return $arr_parent;
			
		}





		function fetch_by_order_from_table($table,$arr_check,$arr_val,$arr_fields,$order){
			
			$arr_parent = array();
			$mysql_query = "SELECT * FROM `ECE_CLASS_OF_2017`.`$table`";
			foreach($arr_check as $check_key => $check){
				
				$check_val = $arr_val[$check_key];
				if($check_key == 0){
					$mysql_query .= " WHERE `$check` = '$check_val'";
				}
				else{
					$mysql_query .= " AND `$check` = '$check_val'";
				}
				
			}

			$mysql_query .= " ORDER BY $order";
			
			
			$mysql_query = mysql_query($mysql_query);
			while($fetch_result = mysql_fetch_assoc($mysql_query)){
				
				$arr_new_user = array();
				foreach($arr_fields as $field){
					$arr_new_user[$field] = $fetch_result[$field];
					
				}
				array_push($arr_parent,$arr_new_user);
				
			}
			
			
			return $arr_parent;
			
		}




		function fetch_or_like_from_table($table,$arr_check,$arr_val,$arr_fields){
			
			$arr_parent = array();
			$mysql_query = "SELECT * FROM `ECE_CLASS_OF_2017`.`$table`";
			foreach($arr_check as $check_key => $check){
				
				$check_val = $arr_val[$check_key];
				if($check_key == 0){
					$mysql_query .= " WHERE `$check` LIKE '%$check_val%'";
				}
				else{
					$mysql_query .= " OR `$check` LIKE '%$check_val%'";
				}
				
			}
			
			//echo $mysql_query;die();
			$mysql_query = mysql_query($mysql_query);
			
			while($fetch_result = mysql_fetch_assoc($mysql_query)){
				
				$arr_new_user = array();
				foreach($arr_fields as $field){
					$arr_new_user[$field] = $fetch_result[$field];
					
				}
				array_push($arr_parent,$arr_new_user);
				
			}
			
			
			return $arr_parent;
			
		}


		function fetch_or_from_table($table,$arr_check,$arr_val,$arr_fields){
			
			$arr_parent = array();
			$mysql_query = "SELECT * FROM `ECE_CLASS_OF_2017`.`$table`";
			foreach($arr_check as $check_key => $check){
				
				$check_val = $arr_val[$check_key];
				if($check_key == 0){
					$mysql_query .= " WHERE `$check` = '$check_val'";
				}
				else{
					$mysql_query .= " OR `$check`= '$check_val'";
				}
				
			}
			
			
			$mysql_query = mysql_query($mysql_query);
			while($fetch_result = mysql_fetch_assoc($mysql_query)){
				
				$arr_new_user = array();
				foreach($arr_fields as $field){
					$arr_new_user[$field] = $fetch_result[$field];
					
				}
				array_push($arr_parent,$arr_new_user);
				
			}
			
			
			return $arr_parent;
			
		}









		function fetch_rows_from_table($table,$arr_check,$arr_val){
			
			$no_of_rows = 0;
			$mysql_query = "SELECT * FROM `ECE_CLASS_OF_2017`.`$table`";
			foreach($arr_check as $check_key => $check){
				
				$check_val = $arr_val[$check_key];
				if($check_key == 0){
					$mysql_query .= " WHERE `$check` = '$check_val'";
				}
				else{
					$mysql_query .= " AND `$check` = '$check_val'";
				}
				
			}
			
			
			$mysql_query = mysql_query($mysql_query);
			while($fetch_result = mysql_fetch_assoc($mysql_query)){
				
				$no_of_rows++;
				
			}
			
			
			return $no_of_rows;
			
		}





		function fetch_in_from_table($table,$arr_vals,$column,$arr_fields){
			
			$arr_parent = array();
			if(empty($arr_vals)) return $arr_parent;
			$mysql_query = "SELECT * FROM `ECE_CLASS_OF_2017`.`$table` WHERE `$column` IN (".implode(',',$arr_vals).")";
			//echo $mysql_query;die();
			
			
			$mysql_query = mysql_query($mysql_query);
			while($fetch_result = mysql_fetch_assoc($mysql_query)){
				
				$arr_new_user = array();
				foreach($arr_fields as $field){
					$arr_new_user[$field] = $fetch_result[$field];
					
				}
				array_push($arr_parent,$arr_new_user);
				
			}
			
			
			return $arr_parent;
			
		}
		
		
	}

?>