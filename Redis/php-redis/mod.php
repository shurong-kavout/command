<?php
require("redis.php");
$uid = $_GET['id'];
$data = $redis->hgetall("user:" . $uid);
?>
<form action="doedit.php" method="post">
	<input type="hidden" value="<?php echo $data['uid']?>" name="uid" />
	�û���<input type="text" name="username" value="<?php echo $data['username']?>" /><br />
	���䣺<input type="text" name="age" value="<?php echo $data['age']?>" /><br />
	<input type="submit" value="�޸�" />
	<input type="reset" value="������д" />
</form>