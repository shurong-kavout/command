<?php
require("redis.php");
if(empty($_POST['username']) || empty($_POST['password'])){
?>
<form action="" method="post">
	�û�:<input type="text" name="username" /><br />
	����:<input type="password" name="password" /><br />
	<input type="submit" value="��½" /> 
</form>
<?php
}else{
	$username = $_POST['username'];
	$pass = $_POST['password'];
	$uid = $redis->get("username:" . $username);
	if($uid){
		$password = $redis->hget("user:" . $uid, "password");
		if(md5($pass) == $password){
			$auth = md5(uniqid($username, true));
			$redis->set("auth:" . $auth, $uid);
			setcookie("auth", $auth, time() + 86400);
			header("location:list.php");
		}else{
?>
	<p>�������<a href="login.php">�����µ�¼��</a></p>
<?php
		}
	}else{
?>
	<p>�û������ڣ�<a href="login.php">���������룡</a></p>
<?php
	}
}
?>
