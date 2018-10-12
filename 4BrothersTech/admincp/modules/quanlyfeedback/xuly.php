<?php 
	include('config/db.php');
	$id = $_GET['id'];
	$query = "select * from feedback";
	$result = mysqli_query($conn,$query);
	$feedback = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$feedback_id = $feedback['id'];
	$title = $_POST['title'];
	$content = $_POST['content'];

	if (isset($_GET['filter'])) {

 		// VÌ trong sql chỉ cho lấy từ ngày bé đến ngày lớn nên mất công phải làm vậy, còn bây giờ thì nhập ngày bé trc hay ngày lớn trước đều được
 		
 		$s1 = $_GET['from'];
 		$s2 = $_GET['to'];
 		
 		$d1=date_create("$s1");

 		$d2=date_create("$s2");

 		$diff=date_diff($d1,$d2);

 		$sosanh = $diff->format('%R%a');
 		
 		if (substr($sosanh, 0, 1) == "+") {
 			$date1 = $_GET['from'];
 			$date2 = $_GET['to'];
 		}else{
 			$date1 = $_GET['to'];
 			$date2 = $_GET['from'];
 		}
 		echo $date1;
 	
 		header('Location:../../index.php?quanly=quanlyfeedback&ac=ngay&date1=' . $date1 . '&date2=' . $date2);

 	}elseif (isset($_GET['full'])){
 		header('Location:../../index.php?quanly=quanlyfeedback&ac=full'); 	
 	}

 	if (isset($_POST['them'])) {
		//them
		$sql = "INSERT INTO replies (feedback_id, title, content) 
             VALUES ('$feedback_id','$title','$content')";
		mysqli_query($conn,$sql);
		header('Location:../../index.php?quanly=quanlyfeedback&ac=lietke');
	}elseif (isset($_POST['sua'])) {
		//sua
		$sql = "INSERT INTO replies (feedback_id, title, content) 
             VALUES ('$id','$title','$content')";
		mysqli_query($conn,$sql);
		header('Location:../../index.php?quanly=quanlyfeedback&ac=lietke');
	}
	// else{
	// 	//xoa
	// 	$sql = "DELETE from users where id = '$id'";
	// 	mysqli_query($conn,$sql);
	// 	header('Location:../../index.php?quanly=quanlythongtin&ac=lietke');
	// }

 ?>