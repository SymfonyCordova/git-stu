# mysql
## mysql的安装
```
rpm -qa | grep -i mysql 查看是否安装了mysql
如果有就卸载
rpm -e --nodeps mysql--libs-5.7.24-1.el7.x86_64 卸载自带的MySQL

windows下 Setup.exe就一个安装包(先安装了服务器 再安装了客户端)
linux要分开安装
mysql-community-client-5.7.24-1.el7.x86_64.liunx.rpm
mysql-community-server-5.7.24-1.el7.x86_64.liunx.rpm
rpm -ivh MySQL-server--5.7.24-1.el7.x86_64.liunx.rpm
rpm -ivh MySQL-client--5.7.24-1.el7.x86_64.liunx.rpm

启动mysql服务
service mysql start

初始化mysql的root密码
/usr/bin/mysqladmin -u root password ‘root’

设置开机启动mysql
  加入到系统服务:
chkconfig --add mysql
自动启动
chkconfig mysql on

开启远程连接
  登陆mysql
  //赋予root用户所有权限,远程登陆密码是root
  grant all privileges on *.* to ‘root’ @’%’ identified by ‘root’
  flush privileges

设置linux的防火墙
  /sbin/iptables -I INPUT -p tcp --dport 3306 -j ACCEPT
  /etc/rc.d/init.d/iptables save

```
## 数据库操作
```
	1.创建数据库
		create database [if not exists] db_name [character set xxx] [collate xxx]
		*创建一个名称为mydb1的数据库。
			create database mydb1;
		*创建一个使用utf8字符集的mydb2数据库。
			create database mydb2 character set utf8;
		*创建一个使用utf8字符集，并带校对规则的mydb3数据库。
			create database mydb3 character set utf8 collate utf8_bin ;
	2.查看数据库
		show databases;查看所有数据库
		show create database db_name; 查看数据库的创建方式
	3.修改数据库
		alter database db_name [character set xxx] [collate xxxx]
	4.删除数据库
		drop database [if exists] db_name;
	5.使用数据库
		切换数据库 use db_name;
		查看当前使用的数据库 select database();
	
	/s 列出当前服务器的信息
	show charset; 列出编码和对应的排版方式
```
## 表操作
```
1.创建表
  create table tab_name(
    field1 type,
    field2 type,
    ...
    fieldn type
  )[character set xxx][collate xxx];

  ****java和mysql的数据类型比较
    String  ----------------------  char(n) varchar(n) 255  65535
    byte short int long float double -------------- tinyint  smallint int bigint float double
    boolean ------------------ bit 0/1
    Date ------------------ Date、Time、DateTime、timestamp
    FileInputStream FileReader  ------------------------------ Blob Text

    *创建一个员工表employee
    create table employee(
      id int primary key auto_increment ,
      name varchar(20),
      gender bit default 1,
      birthday date,
      entry_date date,
      job varchar(20),
      salary double,
      resume text
    );

    约束:
      primary key
      unique
      not null
      auto_increment 主键字段必须是数字类型。
      外键约束
2.查看表信息
  desc tab_name 查看表结构
  show tables 查看当前数据库中的所有的表
  show create table tab_name	查看当前数据库表建表语句 
3.修改表结构
    (1)增加一列
      alter table tab_name add [column] 列名 类型;
    (2)修改一列类型
      alter table tab_name modify 列名 类型;
    (3)修改列名
      alter table tab_name change [column] 列名 新列名 类型;
    (4)删除一列
      alter table tab_name drop [column] 列名;
    (5)修改表名
      rename table 表名 to 新表名;
    (6)修该表所用的字符集			
      alter table student character set utf8;

  4.删除表
    drop table tab_name;
```
## 表记录操作
```
1.增加一条记录insert
insert into tab_name (field1,filed2,.......) values (value1,value2,.......);
*插入的数据应与字段的数据类型相同。
*数据的大小应在列的规定范围内，例如：不能将一个长度为80的字符串加入到长度为40的列中。
*在values中列出的数据位置必须与被加入的列的排列位置相对应。
*字符和日期型数据应包含在单引号中'zhang' '2013-04-20'
*插入空值：不指定某列的值或insert into table value(null)，则该列取空值。
*如果要插入所有字段可以省写列列表，直接按表中字段顺序写值列表insert into tab_name values(value1,value2,......);

*练习：使用insert语句向表中插入三个员工的信息。
insert into emp (name,birthday,entry_date,job,salary) values ('张飞','1990-09-09','2000-01-01','打手',999);
insert into emp (name,birthday,entry_date,job,salary) values ('关羽','1989-08-08','2000-01-01','财神',9999);
insert into emp (name,birthday,entry_date,job,salary) values ('赵云','1991-07-07','2000-01-02','保安',888);
insert into emp values (7,'黄忠',1,'1970-05-05','2001-01-01','战神',1000,null);

show variable like 'character%'; 列出服务器他处理客户端服务器短的编码
set names gbk；告诉服务器我当前的客户端编码形式 处理的时候解决乱码

2.修改表记录 
update tab_name set field1=value1,field2=value2,......[where 语句]
*UPDATE语法可以用新值更新原有表行中的各列。
*SET子句指示要修改哪些列和要给予哪些值。
*WHERE子句指定应更新哪些行。如没有WHERE子句，则更新所有的行。
*实验：
  将所有员工薪水修改为5000元。
  update emp set salary=5000;
  将姓名为’zs’的员工薪水修改为3000元。
  update emp set salary=3000 where name='zs';
  将姓名为’ls’的员工薪水修改为4000元,job改为ccc。
  update emp set salary=4000,job='ccc' where name='zs';
  将wu的薪水在原有基础上增加1000元。	
  update emp set salar=salary+4000 where name='wu';

3.删除表操作
delete from tab_name [where ....]
*如果不跟where语句则删除整张表中的数据
*delete只能用来删除一行记录，不能值删除一行记录中的某一列值（这是update操作）。
*delete语句只能删除表中的内容，不能删除表本身，想要删除表，用drop
*同insert和update一样，从一个表中删除记录将引起其它表的参照完整性问题，在修改数据库数据时，头脑中应该始终不要忘记这个潜在的问题。
*TRUNCATE TABLE也可以删除表中的所有数据，词语句首先摧毁表，再新建表。此种方式删除的数据不能在事务中恢复。
*实验：
  删除表中名称为’zs’的记录。
  delete from emp where name='黄忠';
  删除表中所有记录。
  delete from emp;
  使用truncate删除表中记录。
  truncate table emp;


4.select操作
（1）select [distinct] *|field1，field2，......   from tab_name 
        其中from指定从哪张表筛选，*表示查找所有列，也可以指定一个列列表明确指定要查找的列，distinct用来剔除重复行。
  *实验：
    查询表中所有学生的信息。
    select * from exam;
    查询表中所有学生的姓名和对应的英语成绩。
    select name,english from exam;
    过滤表中重复数据。
    select distinct english from exam;
（2）select 也可以使用表达式，并且可以使用 as 别名
    在所有学生分数上加10分特长分显示。
    select name,english+10,chinese+10,math+10 from exam;
    统计每个学生的总分。
    select name,english+chinese+math from exam;
    使用别名表示学生总分。
    select name,english+chinese+math as 总成绩 from exam;
    select name,english+chinese+math 总成绩 from exam;
    select name english from exam;
（3）使用where子句，进行过滤查询。
    *练习：
    查询姓名为XXX的学生成绩
    select * from exam where name='张飞';
    查询英语成绩大于90分的同学
    select name,english from exam where english>90;
    查询总分大于200分的所有同学
    select name,math+english+chinese as 总成绩 from exam where math+english+chinese>200 ;
    *where字句中可以使用：
        *比较运算符：	
              > < >= <= <>  
              between 10 and 20 值在10到20之间  
              in(10,20,3)值是10或20或30
              like '张pattern' pattern可以是%或者_，如果是%则表示任意多字符，此例中张三丰 张飞 张abcd ，如果是_则表示一个字符张_，张飞符合。张
              Is null

        *逻辑运算符
          在多个条件直接可以使用逻辑运算符 and or not
    *实验
      查询英语分数在 80－100之间的同学。
       select name ,english from exam where english between 80 and 100;
      查询数学分数为75,76,77的同学。
      select name ,math from exam where math in (75,76,77);
      查询所有姓张的学生成绩。
      select * from exam where name like '张%';
      查询数学分>70，语文分>80的同学。
      select name from exam where math>70 and chinese >80;
      查找缺考数学的学生的姓名
      select name from exam where math is null;
（4）Order by 指定排序的列，排序的列即可是表中的列名，也可以是select 语句后指定的别名。
    Asc 升序、Desc 降序，其中asc为默认值
    ORDER BY 子句应位于SELECT语句的结尾。
  *练习：
    对数学成绩排序后输出。
    select * from exam order by math;
    对总分排序按从高到低的顺序输出
    select name ,(ifnull(math,0)+ifnull(chinese,0)+ifnull(english,0)) 总成绩 from exam order by 总成绩 desc;
    对姓张的学生成绩排序输出
    select name ,(ifnull(math,0)+ifnull(chinese,0)+ifnull(english,0)) 总成绩 from exam where name like '张%' order by 总成绩 desc;
（5）聚合函数：技巧,先不要管聚合函数要干嘛，先把要求的内容查出来再包上聚合函数即可。
  count(列名)
    统计一个班级共有多少学生？先查出所有的学生，再用count包上
     select count(*) from exam;
    统计数学成绩大于70的学生有多少个？
     select count(math) from exam where math>70;
    统计总分大于250的人数有多少？
      select count(name) from exam where (ifnull(math,0)+ifnull(chinese,0)+ifnull(english,0))>250;
  sum(列名)
    统计一个班级数学总成绩？先查出所有的数学成绩，再用sum包上
      select sum(math) from exam;
    统计一个班级语文、英语、数学各科的总成绩
      select sum(math),sum(english),sum(chinese) from exam;
    统计一个班级语文、英语、数学的成绩总和
      select sum(ifnull(math,0)+ifnull(chinese,0)+ifnull(english,0)) as 总成绩 from exam; 
    统计一个班级语文成绩平均分
        select sum(chinese)/count(*) from exam ;
    注意：sum仅对数值起作用，否则会报错。
AVG(列名)：
      求一个班级数学平均分？先查出所有的数学分，然后用avg包上。
        select avg(ifnull(math,0)) from exam;
      求一个班级总分平均分
        select avg((ifnull(math,0)+ifnull(chinese,0)+ifnull(english,0))) from exam ;
Max、Min
      求班级最高分和最低分（数值范围在统计中特别有用）
      select Max((ifnull(math,0)+ifnull(chinese,0)+ifnull(english,0))) from exam;
      select Min((ifnull(math,0)+ifnull(chinese,0)+ifnull(english,0))) from exam;

（6）group by字句，其后可以接多个列名，也可以跟having子句对group by 的结果进行筛选。
      练习：对订单表中商品归类后，显示每一类商品的总价
        select product，sum(price) from orders group by product;
      练习：查询购买了几类商品，并且每类总价大于100的商品
          select product，sum(price) from orders group by product having sum(price)>100;
  !~having 和 where 的差别： where语句用在分组之前的筛选，having用在分组之后的筛选，having中可以用合计函数，where中就不行。使用where的地方可以用having替代。
        练习:查询商品列表中除了橘子以外的商品，每一类商品的总价格大于500元的商品的名字
          select product,sum(price) from orders where product<>'桔子'group by product having sum(price)>500;


（7）重点：Select from where group by having order by 
      Mysql在执行sql语句时的执行顺序：from where select group by having order by
  *分析：		
    select math+english+chinese as 总成绩 from exam where 总成绩 >250; ---- 不成功
    select math+english+chinese as 总成绩 from exam having 总成绩 >250; --- 成功
    select math+english+chinese as 总成绩 from exam group by 总成绩 having 总成绩 >250; ----成功
    select  math+english+chinese as 总成绩 from exam order by 总成绩;----成功
    select * from exam as 成绩 where 成绩.math>85; ---- 成功
```
## 约束
```
1.创建表时指定约束：
  create table tb(
    id int primary key auto_increment,
    name varchar(20) unique not null,
    ref_id int,
     foreign key(ref_id) references tb2(id)
  );

  create table tb2(
    id int primary key auto_increment
  );


2.外键约束：
  （1）增加外键：
    可以明确指定外键的名称，如果不指定外键的名称,mysql会自动为你创建一个外键名称。
    RESTRICT : 只要本表格里面有指向主表的数据， 在主表里面就无法删除相关记录。
    CASCADE : 如果在foreign key 所指向的那个表里面删除一条记录，那么在此表里面的跟那个key一样的所有记录都会一同删掉。
    alter table book add [constraint FK_BOOK] foreign key(pubid) references pub_com(id) [on delete restrict] [on update restrict];

  （2）删除外键
    alter table 表名 drop foreign key 外键（区分大小写，外键名可以desc 表名查看）;


3.主键约束：
（1）增加主键（自动增长，只有主键可以自动增长）
  Alter table tb add primary key(id) [auto_increment];
（2）删除主键
  alter table 表名 drop primary key
（3）增加自动增长
  Alter table employee modify id int auto_increment;
（4）删除自动增长
  Alter table tb modify id int;		
```
## 多表设计
```
1.数据库中表关系
    一对一
    一对多 (多对一)
    多对多
    
2.如何确立和实现数据库中的表关系
    一对多的表关系在数据库如何实现?
        使用外键约束。
        我们习惯把一的方称为主表,把多的一方称为从表
        什么是外键:
            从表中有一列,该列的取值除了null之外,只能来源于主表的主键。
            默认情况下,外键字段的值是可以重复的。
    
    多对多的表关系在数据库中如何实现?
        使用中间表。
        中间表中只有两个表的主键,引用两个多对多表的主键。
        不能有其他字段信息,至于中间表的主键,应该采用联合主键。
        
        如果任何一个多方的表和中间表去比较,都是一对多的关系
    
    一对一的表关系在数据库中如何实现?
        有两种:
        第一种: 建立外键的方式:
            使用外键约束,唯一约束,非空约束。
            它是把外键字段加了非空和唯一约束。从而实现了一对一。
        第二种: 使用主键的方式:
            让其中一张表既是主键,又是外键。 
            一对一也有主从关系,相当于一张表拆成两张表,其中从表设置主键,外键。
    
    如何确定两张表之间的关系:
        找外键
        此种方式能解决确立表关系90%的情况, 剩余的10%请听项目阶段的打断设计。

多对多联合主键的例子
    create table student_teacher_ref(
        sid int,
        tid int,
        primary key(sid,tid),
        constraint FK_STUDENT_ID foreign key(sid) references student(sid),
        constraint FK_TEACHER_ID foreign key(tid) references teacher(tid)
    );
    
    create table student(
        sid int primary key auto_increment,
        sname varchar(20),
        sgender varchar(10)
    );
    
    create table teacher(
        tid int primary key auto_increment,
        tname varchar(20),
        tsalary double(7,2)
    );
  
```

## 多表查询
```
  create table tb (id int primary key,name varchar(20) );
  create table ta (
      id int primary key,
      name varchar(20),
      tb_id int
                  );
  insert into tb values(1,'财务部');
  insert into tb values(2,'人事部');
  insert into tb values(3,'科技部');

  insert into ta values (1,'刘备',1);
  insert into ta values (2,'关羽',2);
  insert into ta values (3,'张飞',3);


  mysql> select * from ta;
    +----+------+-------+
    | id | name | tb_id |
    +----+------+-------+
    |  1 | aaa  |     1 |
    |  2 | bbb  |     2 |
    |  3 | bbb  |     4 |
    +----+------+-------+
  mysql> select * from tb;
    +----+------+
    | id | name |
    +----+------+
    |  1 | xxx  |
    |  2 | yyy  |
    |  3 | yyy  |
    +----+------+

  1.笛卡尔积查询：两张表中一条一条对应的记录，m条记录和n条记录查询，最后得到m*n条记录，其中很多错误数据
    select * from ta ,tb;

    mysql> select * from ta ,tb;
      +----+------+-------+----+------+
      | id | name | tb_id | id | name |
      +----+------+-------+----+------+
      |  1 | aaa  |     1 |  1 | xxx  |
      |  2 | bbb  |     2 |  1 | xxx  |
      |  3 | bbb  |     4 |  1 | xxx  |
      |  1 | aaa  |     1 |  2 | yyy  |
      |  2 | bbb  |     2 |  2 | yyy  |
      |  3 | bbb  |     4 |  2 | yyy  |
      |  1 | aaa  |     1 |  3 | yyy  |
      |  2 | bbb  |     2 |  3 | yyy  |
      |  3 | bbb  |     4 |  3 | yyy  |
      +----+------+-------+----+------+
  2.内连接：查询两张表中都有的关联数据,相当于利用条件从笛卡尔积结果中筛选出了正确的结果。
    select * from ta ,tb where ta.tb_id = tb.id;
    select * from ta inner join tb on ta.tb_id = tb.id;

    mysql> select * from ta inner join tb on ta.tb_id = tb.id;
      +----+------+-------+----+------+
      | id | name | tb_id | id | name |
      +----+------+-------+----+------+
      |  1 | aaa  |     1 |  1 | xxx  |
      |  2 | bbb  |     2 |  2 | yyy  |
      +----+------+-------+----+------+
  3.外连接
    （1）左外连接：在内连接的基础上增加左边有右边没有的结果
    select * from ta left join tb on ta.tb_id = tb.id;

    mysql> select * from ta left join tb on ta.tb_id = tb.id;
      +----+------+-------+------+------+
      | id | name | tb_id | id   | name |
      +----+------+-------+------+------+
      |  1 | aaa  |     1 |    1 | xxx  |
      |  2 | bbb  |     2 |    2 | yyy  |
      |  3 | bbb  |     4 | NULL | NULL |
      +----+------+-------+------+------+
    （2）右外连接：在内连接的基础上增加右边有左边没有的结果
      select * from ta right join tb on ta.tb_id = tb.id;

      mysql> select * from ta right join tb on ta.tb_id = tb.id;
      +------+------+-------+----+------+
      | id   | name | tb_id | id | name |
      +------+------+-------+----+------+
      |    1 | aaa  |     1 |  1 | xxx  |
      |    2 | bbb  |     2 |  2 | yyy  |
      | NULL | NULL |  NULL |  3 | yyy  |
      +------+------+-------+----+------+

    （3）全外连接：在内连接的基础上增加左边有右边没有的和右边有左边没有的结果
      select * from ta full join tb on ta.tb_id = tb.id; --mysql不支持全外连接
      select * from ta left join tb on ta.tb_id = tb.id 
      union
      select * from ta right join tb on ta.tb_id = tb.id;

      mysql> select * from ta left join tb on ta.tb_id = tb.id
          -> union
          -> select * from ta right join tb on ta.tb_id = tb.id; --mysql可以使用此种方式间接实现全外连接
      +------+------+-------+------+------+
      | id   | name | tb_id | id   | name |
      +------+------+-------+------+------+
      |    1 | aaa  |     1 |    1 | xxx  |
      |    2 | bbb  |     2 |    2 | yyy  |
      |    3 | bbb  |     4 | NULL | NULL |
      | NULL | NULL |  NULL |    3 | yyy  |
      +------+------+-------+------+------+
```

## 事务
```
1.事务的概念：事务是指逻辑上的一组操作，这组操作要么同时完成要么同时不完成。参考转账操作。
2.如果你自己不去控制事务，数据库默认一条sql语句就处在自己单独的事务当中。
3.也可以使用命令去开启一个事务：
		start transaction;--开启事务，这条语句之后的sql语句将处在一个事务当中，这些sql语句并不会立即执行
		Commit--提交事务，一旦提交事务，事务中的所有sql语句才会执行。
		Rollback -- 回滚事务，将之前所有的sql取消。
4.事务的四大特性ACID
	~原子性：事务的一组操作是原子的不可再分割的，这组操作要么同时完成要么同时不完成。
	~一致性: 事务在执行前后数据的完整性保持不变。数据库在某个状态下符合所有的完整性约束的状态叫做数据库具有完整性。
      在解散一个部门时应该同时处理员工表中的员工保证这个事务结束后，仍然保证所有的员工能找到对应的部门，满足外键约束。
	~隔离性：当多个事务同时操作一个数据库时，可能存在并发问题，此时应保证各个事务要进行隔离，事务之间不能互相干扰。
	~持久性：持久性是指一个事务一旦被提交，它对数据库中数据的改变就是永久性的，不能再回滚。
```

事务的隔离性导致的问题
（所有的问题都是在某些情况下才会导致问题）
	~脏读：一个事务读取到了另一个事务未提交的数据。
	~不可重复读：在一个事务内读取表中的某一行数据，多次读取结果不同.
	~幻读(虚读)：一个事务读取到了另一个事务插入的数据（已提交）

6.数据库的隔离级别
	~Read uncommitted：如果将数据库设定为此隔离级别，数据库将会有脏读、不可重复度、幻读的问题。
	~Read committed：如果将数据库设定为此隔离级别，数据库可以防止脏读，但有不可重复度、幻读的问题。
	~Repeatable read: 如果将数据库设定为此隔离级别，数据库可以防止脏读、不可重复度，但是不能防止幻读。
	~Serializable：将数据库串行化,可以避免脏读、不可重复读、幻读。
	
	安全性来说：Serializable>Repeatable read>Read committed>Read uncommitted
	效率来说：Serializable<Repeatable read<Read committed<Read uncommitted
	通常来说，一般的应用都会选择Repeatable read或Read committed作为数据库隔离级别来使用。
	mysql默认的数据库隔离级别为：REPEATABLE-READ
	
	如何查询当前数据库的隔离级别？select @@tx_isolation;
	如何设置当前数据库的隔离级别？set [global/session] transaction isolation level ...;
	~此种方式设置的隔离级别只对当前连接起作用。
		set transaction isolation level read uncommitted;
		set session transaction isolation level read uncommitted;
	~此种方式设置的隔离级别是设置数据库默认的隔离级别	
		set global transaction isolation level read uncommitted;
		
7.做实验，演示脏读、不可重复度、幻读
	~演示脏读
	~演示不可重复度
	~演示幻读：幻读有可能发生有可能不发生，但是一旦发生就可能造成危害。
	~演示Serializable:基于锁机制运行

事务隔离演示
演示不同隔离级别下的并发问题
set   transaction isolation level 设置事务隔离级别
select @@tx_isolation	查询当前事务隔离级别

1.当把事务的隔离级别设置为read uncommitted时，会引发脏读、不可重复读和虚读


A窗口
set transaction isolation level  read uncommitted;
start transaction;
select * from account;
-----发现a帐户是1000元，转到b窗口

B窗口
start transaction;
update account set money=money+100 where name='aaa';
-----不要提交，转到a窗口查询

select * from account
-----发现a多了100元，这时候a读到了b未提交的数据（脏读）

2.当把事务的隔离级别设置为read committed时，会引发不可重复读和虚读，但避免了脏读

A窗口
set transaction isolation level  read committed;
start transaction;
select * from account;
-----发现a帐户是1000元，转到b窗口
B窗口
start transaction;
update account set money=money+100 where name='aaa';
commit;
-----转到a窗口

select * from account;
-----发现a帐户多了100,这时候，a读到了别的事务提交的数据，两次读取a帐户读到的是不同的结果（不可重复读）

3.当把事务的隔离级别设置为repeatable read(mysql默认级别)时，会引发虚读，但避免了脏读、不可重复读

A窗口
set transaction isolation level repeatable read;
start transaction;
select * from account;
----发现表有4个记录，转到b窗口

B窗口
start transaction;
insert into account(name,money) values('ggg',1000);
commit;
-----转到 a窗口

select * from account;
----可能发现表有5条记如，这时候发生了a读取到另外一个事务插入的数据（虚读）

4.当把事务的隔离级别设置为Serializable时，会避免所有问题
A窗口
set transaction isolation level Serializable;
start transaction;
select * from account;
-----转到b窗口

B窗口
start transaction;
insert into account(name,money) values('ggg',1000);
-----发现不能插入，只能等待a结束事务才能插入

8.锁机制：
	共享锁：共享锁和共享锁可以共存。
	排他锁：排他锁和所有锁都不能共存。
	在非串行化下，所有的查询都不加锁，所有的修改操作都会加排他锁。
	在串行化下，所有的查询都加共享锁，所有的修改都加排他锁。
	死锁
	
9.更新丢失
	如果多个线程操作，基于同一个查询结构对表中的记录进行修改，那么后修改的记录将会覆盖前面修改的记录，前面的修改就丢失掉了，这就叫做更新丢失。
	Serializable可以防止更新丢失问题的发生。其他的三个隔离级别都有可能发生更新丢失问题。
	Serializable虽然可以防止更新丢失，但是效率太低，通常数据库不会用这个隔离级别，所以我们需要其他的机制来防止更新丢失:
	
	乐观锁和悲观锁不是数据库中真正存在的锁，只是人们在解决更新丢失时的不同的解决方案，体现的是人们看待事务的态度。
	悲观锁：
		隔离级别不设置为Serializable，防止效率过低。
		在查询时手动加上排他锁。
		如果数据库中的数据查询比较多而更新比较少的话，悲观锁将会导致效率低下。
		select * from xxx for update
	乐观锁：
		在表中增加一个version字段，在更新数据库记录是将version加一，从而在修改数据时通过检查版本号是否改变判断出当前更新基于的查询是否已经是过时的版本。
		如果数据库中数据的修改比较多，更新失败的次数会比较多，程序需要多次重复执行更新操作。
    update order set stat=1 and version = version+1 where id=1 and version = 0;
    查询非常多,修改非常少,使用乐观锁
    修改非常多,查询非常少,使用悲观锁
	
```
