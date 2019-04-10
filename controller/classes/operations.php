<?php

	$database = 'ECE_CLASS_OF_2017';
	class Operations{



		function unn_api($reg_no,$password){

            $post_array = array('username'=>$reg_no,'password'=>$password);

            $curl = curl_init(); 
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://unn-api.herokuapp.com/v1/students',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => 1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode(
                    $post_array
                ),
                CURLOPT_SSL_VERIFYPEER=> 0,
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/json"
                ),
            ));    
                
            $result = curl_exec($curl);
            $result = json_decode($result);

            return $result;

        }

		function insert_user($table,$arr_columns,$arr_values){

			$query = "INSERT INTO `ECE_CLASS_OF_2017`.`$table` (`".implode('`,`', $arr_columns)."`) VALUES ('".implode('\',\'', $arr_values)."')";
			
			//echo $query;die();
			mysql_query($query);
			return mysql_insert_id();

		}


        function delete_by_id($table,$post_id,$user_id){

			$query = "DELETE FROM `ECE_CLASS_OF_2017`.`$table` WHERE `user_id` = '$user_id' AND `post_id` = '$post_id'";
			
			mysql_query($query);

		}

        function delete_from_table($table,$column,$id){

			$query = "DELETE FROM `ECE_CLASS_OF_2017`.`$table` WHERE `$column` = '$id'";
			
			mysql_query($query);

		}

        function update_user($table,$arr_columns,$arr_values,$id){

			$query = "UPDATE `ECE_CLASS_OF_2017`.`$table` SET `$arr_columns[0]` = '$arr_values[0]'";
            foreach($arr_columns as $column_key => $column){

                if($column_key != 0){
                    if(($column == 'Display_Pic' && $arr_values[$column_key] == '') || ($column == 'Display_Pic_Thumb' && $arr_values[$column_key] == '')){
                        continue;
                    }
                    $query .= " , `$column` = '$arr_values[$column_key]'";
                }

            }

            $query .= " WHERE `id` = '$id'";
            
			mysql_query($query);
            //echo $query;die();

		}


        function set_seen($posts_id,$user_id){

            
            mysql_query("UPDATE `Likes` SET `seen` = '1' WHERE `post_id` IN (".implode(',',$posts_id).")");
            mysql_query("UPDATE `Comments` SET `seen` = '1' WHERE `post_id` IN (".implode(',',$posts_id).")");

            mysql_query("UPDATE `Mentions` SET `seen` = '1' WHERE `mentionee_id` = '$user_id'");

        }


        function check_complete_profile($array){

            $bool = true;
            foreach($array as $item){
                
                if(empty($item)){

                    $bool = false;

                }
            }

            return $bool;
            
        }



        function get_post_time($timestamp){

			$time_now = time();


			$post_time = $time_now - $timestamp;

			
			
			if((int) ($post_time/(24*60*60)) != 0){
				return (int) ($post_time/(24*60*60)).'d';
			}
			else if((int) ($post_time/(60*60)) != 0){
				return (int) ($post_time/(60*60)).'h';
			}
			else if((int) ($post_time/(60)) != 0){
				return (int) ($post_time/(60)).'m';
			}
            else{
                if($post_time == 0) return 'Just Now';
                else return $post_time.'s';
            }

			


		}



        function check_text_for_mentions($user_id,$text,$post_id,$fetch_operations,$mention_table,$post_id_2,$column_to_edit,$pre){

            //echo $text;die();
            $return_text = $text;
            $text_to_review = ' '.$text;
            $offset = 0;
            $tag = ' @';

            while($str_pos = strpos($text_to_review,$tag,$offset)){

                //echo $offset;die();
                $offset = $str_pos + 2;
                $end_pos = strpos($text_to_review,' ',$offset);
                //echo $str_pos;die();
                
                $mentioned_user = trim(substr($text_to_review,$str_pos,($end_pos-($str_pos))));
                if($fetch_operations->fetch_rows_from_table('All_Users',array('Nickname'),array($mentioned_user)) != 0){

                    //echo $mentioned_user.'<br/>';
                    $mentioned_user_id = $fetch_operations->fetch_from_table('All_Users',array('Nickname'),array($mentioned_user),array('id'));
                    
                    $return_text = str_replace($mentioned_user,'<a href="'.$pre.'yb_profile.php?s='.$mentioned_user_id[0]['id'].'">'.$mentioned_user.'</a>',$return_text);
                    //echo $mentioned_user_id[0]['id'];die();
                    $this->insert_user('Mentions',array('post_id','mentioner_id','mentionee_id','Date','seen'),
                    array($post_id,$user_id,$mentioned_user_id[0]['id'],time(),0));


                }
                 //echo $mentioned_user.'<br/>';
            }

            $this->update_user($mention_table,array($column_to_edit),array($return_text),$post_id_2);
            //foreach mentioned, get user_id and insert into Mentions.

        }



        function create_img($background,$color,$text,$weight){

            $text = substr($text,0,267);
            $font_size = ceil((20*267)/(strlen($text)));//limit is 200 words
            $ww = ceil(1024/$font_size);

            if($font_size > 28){
                $font_size = 35;
                $ww = 40;
            }
            
            $text_rows = ceil(strlen($text)/$ww);
            $text_30 = substr($text,0,$ww);


            $text = wordwrap($text,$ww,"\n");
            $text_lb = count(explode('\n',$text));

            

            list($br,$bg,$bb) = sscanf($background, "#%02x%02x%02x");//bg
            list($cr,$cg,$cb) = sscanf($color, "#%02x%02x%02x");//bg


            $img = imagecreate(1024,640);
            $bg = imagecolorallocate($img,$br,$bg,$bb);
            $clr = imagecolorallocate($img,$cr,$cg,$cb);

            imagefill($img,0,0,$bg);
            $text_box = imagettfbbox($font_size,0,"model/Lato/fonts/Lato-".$weight.".ttf",$text_30);

            $text_width = $text_box[2] - $text_box[0];
            $text_height = ($text_box[7] - $text_box[1]) * -($text_rows-$text_lb);

            $x = (1024/2) - ($text_width/2);
            $y = (640/2) - ($text_height/2);


            imagettftext($img,$font_size,0,$x,$y,$clr,"model/Lato/fonts/Lato-".$weight.".ttf",$text);
            return $img;

        }

        function destroy_img($img){

            imagedestroy($img);

        }



        function create_thumbnail($tmp){


			$img_size = getimagesize($tmp);
			$ratio = $img_size[0]/$img_size[1];
			
			
			if($ratio > 1){
				
				$width = 200;
				$height = 200/$ratio;
				
			}
			else{
				$width = 200*$ratio;
				$height = 200;
			}
			
				
            $src = imagecreatefromstring(file_get_contents($tmp));
            $dst = imagecreatetruecolor($width,$height);
            imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$img_size[0],$img_size[1]);

            ob_start();
            imagepng($dst);
            $blob  = ob_get_contents();
			ob_end_clean();

            imagedestroy($dst);
            
            return $blob;


		}



        function check_image_height($tmp,$mime){

            if(strpos($mime,'image') === false) return false;

			$img_size = getimagesize($tmp);
            //echo $img_size[1];die();
            $width = $img_size[0];
            $height = $img_size[1];
            $ratio = $height/$width;
            if($ratio > 0.7){
                if($width > $height){
                    $y = 0;
                    $x = ($width - $height)/2;
                    $smallerSide = height;
                }
                else{
                    $x = 0;
                    $y = ($height - $width)/2;
                    $smallerSide = $width;
                }
                //echo $height.'/'.$width;die();
                $fh = 0.7*$smallerSide;
                $src = imagecreatefromstring(file_get_contents($tmp));
                $dst = imagecreatetruecolor($smallerSide,$fh);
                imagecopyresampled($dst,$src,0,0,$x,$y,$smallerSide,$fh,$smallerSide,$smallerSide);

                ob_start();
                switch($mime){

                    case 'image/png';
                        imagepng($dst);
                    break;

                    case 'image/jpeg';
                        imagejpeg($dst);
                    break;

                    case 'gif';
                        imagegif($dst);
                    break;

                    default:
                        return false;
                    break;

                }
                $blob  = ob_get_contents();
                ob_end_clean();

                imagedestroy($dst);
                
                return $blob;
            }

            else{
                return false;
            }

		}

        function check_image_blob_height($blob,$mime){

            if(strpos($mime,'image') === false) return false;

            $src = imagecreatefromstring($blob);
            $width = imagesx($src);
            $height = imagesy($src);
            $ratio = $height/$width;

            if($ratio > 0.7 && strpos($mime,'image') !== false){
                if($width > $height){
                    $y = 0;
                    $x = ($width - $height)/2;
                    $smallerSide = $height;
                }
                else{
                    $x = 0;
                    $y = ($height - $width)/2;
                    $smallerSide = $width;
                }
                
                
                $fh = 0.7*$smallerSide;
                echo $smallerSide;
                $dst = imagecreatetruecolor($smallerSide,$fh);
                imagecopyresampled($dst,$src,0,0,$x,$y,$smallerSide,$fh,$smallerSide,$smallerSide);

                ob_start();
                switch($mime){

                    case 'image/png';
                        imagepng($dst);
                    break;

                    case 'image/jpeg';
                        imagejpeg($dst);
                    break;

                    case 'gif';
                        imagegif($dst);
                    break;
                    
                    default:
                        return false;
                    break;

                }

                $blobe  = ob_get_contents();
                ob_end_clean();

                imagedestroy($dst);
                
                return $blobe;
            }

            else{
                return false;
            }

		}











	}

?>