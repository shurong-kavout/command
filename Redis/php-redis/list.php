<a href="add.php">ע��</a>
<?php
require("redis.php");
if(empty($_COOKIE['auth'])){
?>
	<a href="login.php">��½</a>
<?php
}else{
	$uid = $redis->get("auth:" . $_COOKIE['auth']);
	$username = $redis->hget("user:" . $uid, "username");
?>
	��ӭ����<?php echo $username?>��<a href="logout.php">�˳�</a>
<?php
//�û�����
$count = $redis->lsize("uid");
//ÿҳ��¼��
$page_size = 2;
//��ҳ��
$page_count = ceil($count / $page_size);
//��ǰҳ��
$page_num = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$prev_num = (($page_num - 1) <= 1) ? 1 : ($page_num-1);
$next_num = (($page_num + 1) >= $page_count) ? $page_count : ($page_num + 1);
//��ҳȡ����
$start = ($page_num-1) * $page_size;
$end = ($page_num-1) * $page_size + $page_size - 1;
$uids = $redis->lrange("uid", $start, $end);
//var_dump($uids);

foreach($uids as $user){
	$users[] = $redis->hgetall("user:" . $user);
}
//var_dump($users);
?>
<table border=1>
	<tr>
		<th>uid</th>
		<th>username</th>
		<th>age</th>
		<th>����</th>
	<tr>
<?php foreach($users as $user){?>
	<tr>
		<td><?php echo  $user['uid']?></td>
		<td><?php echo  $user['username']?></td>
		<td><?php echo  $user['age']?></td>
		<td><a href="del.php?id=<?php echo $user['uid']?>">ɾ��</a> <a href="mod.php?id=<?php echo $user['uid']?>">�༭</a> 
		<?php if($_COOKIE['auth'] && $user['uid'] != $uid){?>
			<a href="addfans.php?uid=<?php echo $uid?>&fid=<?php echo $user['uid']?>">�ӹ�ע</a></td>
		<?php }?>
	</tr>
<?php }?>
<tr>
	<td colspan="4">
		<a href="?page=<?php echo $prev_num?>">��һҳ</a>
		<a href="?page=<?php echo $next_num?>">��һҳ</a>
		<a href="?page=1">��ҳ</a>
		<a href="?page=<?php echo $page_count?>">βҳ</a>
		��ǰ<?php echo $page_num?>ҳ
		�ܹ�<?php echo $page_count?>ҳ
		�ܹ�<?php echo $count?>���û�
	</td>
</tr>
</table>

<table border=1>
	<caption>�ҵĹ�ע</caption>
	<?php 
		$users = $redis->smembers("user:" . $uid . ":following");
		foreach($users as $user){
			$row = $redis->hgetall("user:" . $user);
	?>
	<tr>
		<td><?php echo $row['uid']?></td>
		<td><?php echo $row['username']?></td>
		<td><?php echo $row['age']?></td>
	</tr>
	<?php
		}
	?>
</table>

<table border=1>
	<caption>�ҵķ�˿</caption>
	<?php 
		$users = $redis->smembers("user:" . $uid . ":followers");
		foreach($users as $user){
			$row = $redis->hgetall("user:" . $user);
	?>
	<tr>
		<td><?php echo $row['uid']?></td>
		<td><?php echo $row['username']?></td>
		<td><?php echo $row['age']?></td>
	</tr>
	<?php
		}
	?>
</table>
<?php 
}
?>