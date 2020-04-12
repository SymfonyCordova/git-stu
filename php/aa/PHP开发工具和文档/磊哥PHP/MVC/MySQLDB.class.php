<?php
	class MySQLDB{
		//����һЩ����,�Դ洢�������ݿ��6�������Ϣ
		private $host;
		private $port;
		private $user;
		private $password;
		private $charset;
		private $dbname;
		private $link=null;//���ڴ洢���ӳɹ������Դ
		//ʵ�ֵ��еڶ���
		private static $instance=null;//�洢Ψһ��������
		//ʵ�ֵ��е�����
		static function GetInstance($config){
			//if(!isset(self::$instance))
			if(!(self::$instance instanceof self)){
				self::$instance=new self($config);
			}
			return self::$instance;
		}
		////ʵ�ֵ��е��Ĳ� ˽�п�¡����
		private function __clone(){}
		//ʵ�ֵ��е�һ��
		private function __construct($config){
			$this->host = !empty($config['host']) ? $config['host'] : "localhost";
			$this->port = !empty($config['port']) ? $config['port'] : "3306";
			$this->user = !empty($config['user']) ? $config['user'] : "root";
			$this->password = !empty($config['password']) ? $config['password'] : "";
			$this->charset = !empty($config['charset']) ? $config['charset'] : "utf8";
			$this->dbname = !empty($config['dbname']) ? $config['dbname'] : "aa";
			//�������ݿ�
			$this->link=@mysql_connect("{$config['host']}:{$config['port']}","{$config['user']}","{$config['password']}")
				or die("����ʧ��");
			//�趨����
			$this->setCharset($this->charset);
			//ѡ�����ݿ���
			$this->selectDB($this->dbname);
		}
		//�������ӱ���
		public function setCharset($charset){
			mysql_query("set names {$charset}",$this->link);
		}
		//ѡ�����ݿ���
		public function selectDB($dbname){
			mysql_query("use {$dbname}",$this->link);
		}
		//�ر�����
		public function closeDB(){
			mysql_close($this->link);
		}
		//��ɾ�÷��ز���ֵ
		public function exec($sql){
			$result=$this->query($sql);	
			return true;
		}
		//�õ�һ������
		public function GetOneRow($sql){
			$result=$this->query($sql);	
			$rec=mysql_fetch_assoc($result);
			mysql_free_result($result);//�ͷ���Դ�����ٽ������,������Ҫ�ȵ�ҳ��������Զ�����
			return $rec;
		}
		//�õ���������
		public function GetRows($sql){
			$result=$this->query($sql);	
			$arr=array();
			while($rec=mysql_fetch_assoc($result)){
				$arr[]=$rec;//��ʱ�Ƕ�ά����
			}
			return $arr;
		}
		//����һ������ֵ
		public function getOneData($sql){
			$result=$this->query($sql);	
			$rec=mysql_fetch_row($result);
			$data=$rec[0];
			return $data;
		}
		//��ִ��sql��� ���д�����򷵻ؽ����
		private function query($sql){
			$result=mysql_query($sql,$this->link);
			if($result===false){
				echo "<font color='red'>sql���ִ��ʧ��,��ο�������Ϣ</font>";
				echo "<br/>������ţ�".mysql_errno();
				echo "<br/>������Ϣ��".mysql_error();
				echo "<br/>������䣺".$sql;
				die();
			}
			return $result;
		}
	}
	
?>