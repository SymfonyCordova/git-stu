<?php
	class MySQLDB{
		//定义一些属性,以存储链接数据库的6项基本信息
		private $host;
		private $port;
		private $user;
		private $password;
		private $charset;
		private $dbname;
		private $link=null;//用于存储连接成功后的资源
		//实现单列第二步
		private static $instance=null;//存储唯一单利对象
		//实现单列第三步
		static function GetInstance($config){
			//if(!isset(self::$instance))
			if(!(self::$instance instanceof self)){
				self::$instance=new self($config);
			}
			return self::$instance;
		}
		////实现单列第四步 私有克隆方法
		private function __clone(){}
		//实现单列第一步
		private function __construct($config){
			$this->host = !empty($config['host']) ? $config['host'] : "localhost";
			$this->port = !empty($config['port']) ? $config['port'] : "3306";
			$this->user = !empty($config['user']) ? $config['user'] : "root";
			$this->password = !empty($config['password']) ? $config['password'] : "";
			$this->charset = !empty($config['charset']) ? $config['charset'] : "utf8";
			$this->dbname = !empty($config['dbname']) ? $config['dbname'] : "aa";
			//连接数据库
			$this->link=@mysql_connect("{$config['host']}:{$config['port']}","{$config['user']}","{$config['password']}")
				or die("连接失败");
			//设定编码
			$this->setCharset($this->charset);
			//选择数据库名
			$this->selectDB($this->dbname);
		}
		//设置连接编码
		public function setCharset($charset){
			mysql_query("set names {$charset}",$this->link);
		}
		//选择数据库名
		public function selectDB($dbname){
			mysql_query("use {$dbname}",$this->link);
		}
		//关闭连接
		public function closeDB(){
			mysql_close($this->link);
		}
		//增删该返回布尔值
		public function exec($sql){
			$result=$this->query($sql);	
			return true;
		}
		//得到一行数组
		public function GetOneRow($sql){
			$result=$this->query($sql);	
			$rec=mysql_fetch_assoc($result);
			mysql_free_result($result);//释放资源（销毁结果集）,否则需要等到页面结束才自动销毁
			return $rec;
		}
		//得到多行数组
		public function GetRows($sql){
			$result=$this->query($sql);	
			$arr=array();
			while($rec=mysql_fetch_assoc($result)){
				$arr[]=$rec;//此时是二维数组
			}
			return $arr;
		}
		//返回一个数据值
		public function getOneData($sql){
			$result=$this->query($sql);	
			$rec=mysql_fetch_row($result);
			$data=$rec[0];
			return $data;
		}
		//对执行sql语句 进行错误处理或返回结果集
		private function query($sql){
			$result=mysql_query($sql,$this->link);
			if($result===false){
				echo "<font color='red'>sql语句执行失败,请参考如下信息</font>";
				echo "<br/>错误代号：".mysql_errno();
				echo "<br/>错误信息：".mysql_error();
				echo "<br/>错误语句：".$sql;
				die();
			}
			return $result;
		}
	}
	
?>