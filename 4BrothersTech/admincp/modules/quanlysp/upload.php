<?php 
extract($_POST);
    $error=array();
    $extension=array("jpeg","jpg","png","gif");
    foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name)
            {
                $file_name=$_FILES["files"]["name"][$key];
                $file_tmp=$_FILES["files"]["tmp_name"][$key];
                $ext=pathinfo($file_name,PATHINFO_EXTENSION);
                if(in_array($ext,$extension))
                {
                    if(!file_exists($_SERVER['DOCUMENT_ROOT']."/4brotherstech/Image/".$product_id."/".$file_name))
                    {
                        move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],$_SERVER['DOCUMENT_ROOT']."/4brotherstech/Image/".$product_id."/".$file_name);
                    }
                    else
                    {
                        $filename=basename($file_name,$ext);
                        $newFileName=$filename.time().".".$ext;
                        move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],$_SERVER['DOCUMENT_ROOT']."/4brotherstech/Image/".$product_id."/".$newFileName);
                    }
                }
                else
                {
                    array_push($error,"$file_name, ");
                }
            }
?>
