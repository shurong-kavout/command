<?php
ini_set('default_socket_timeout', -1);
error_reporting(E_ERROR);
//ʵ����
$redis = new Redis();

//���ӷ�����
$redis->connect("127.0.0.1");

//��Ȩ
//$redis->auth("password");

//ѡ���
$redis->select("1");

//�鿴��
//$data = $redis->keys("*");
//var_dump($data);