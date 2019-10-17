# mysql
## mysql的安装
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

## 权限控制
    创建用户
      create user 'test'@'%' indentified by 'test';
    查看用户
      select user,host from mysql.user;
    给用户连接的权限
      alter user 'test'@'%' indentified by '1234'
    给用户设置操作数据库的权限
      grant all slave on *.* to 'test'@'%';
      grant replication slave on *.* to 'test'@'%';
    回收用户所有的权限
      revoke all on *.* from 'test'@'%';
    删除用户
      drop user 'test';

## 数据库操作

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

## 表操作

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

## 表记录操作

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

## 约束

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


## 多表设计

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
      
## 多表查询

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


## 事务

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

## mysql的优化        
    mysql如何实现优化
        1.数据库设计要合理(3F)
            较少冗余量
            三范式
                1F:原子约束(每列不可再分)
                    是否保证原子性(看具体业务需求)
                2F:保证唯一(主键唯一,uuid唯一)
                    比如订单表的订单号要唯一约束 
                    怎么保证订单号不被重复生成?
                    怎么保证订单号的幂等性?
                        一般将订单号提前生成好,存放到redis中,需要的时候直接从redis中取出    
                3F:不要有冗余数据
                不一定要完全遵循这个三范式的
                    统计一个总数的时候需要到明细表sum的时候,这个时候查询很慢的
                    在表头上方一个字段每次更新这个总数查询起来很快
        2.什么是慢查询【核心】
            mysql默认10s内没有响应SQL结果则为慢查询
            使用show status查看mysql服务器状态信息
            常用的命令
                show status like 'uptime';
                    mysql数据库启动了多少时间
                show status like 'com_select' show status like 'com_insert' ...
                    类似于update delete显示数据库的查询,更新,添加,删除的次数
                show [session|global] status like ...
                    [session|global]默认是session会话
                    指取出当前窗口的执行,如果你想看所有(从mysql启动到现在,则应该global)
                show status like 'connections'
                    显示到mysql数据库的连接数
                show status like 'slow_queries';
                    显示慢查询次数
            如何修改慢查询的默认时间
                show variables like 'long_query_time';
                    查询慢查询时间
                set long_query_time=1;
                    修改慢查询时间
                    但是重启mysql之后,long_query_time依然是my.ini中的值
            怎么定位慢查询
                在默认情况下,我们的mysql不会记录慢查询,需要在启动mysql时候,指定记录慢查询才可以
                mysqld --safe-mode --show-query-log [mysql5.5可以在my.ini指定]
                    以安全模式启动,数据库将操作写入日志,以备恢复
                mysqld -log-show-queries=d:/abc.log [低版本mysql5.0可以在my.ini指定]
                    先关闭mysql再启动,如果启动了慢查询日志,默认把这个文件放在
                    my.ini文件中记录的位置
                    datadir="c:/ProgramData/MySQL/MySQL Server5.5/Data/"

        3.添加索引(普通索引,主键索引,唯一索引,全文索引)【核心】
            不加索引叫全表扫描
            索引实现原理--B-Tree树 折半查找 二分查找
                会生成索引文件,将索引以B-Tree树的数据结果存储,找起来效率非常高
                B-Tree:能找2的N次方次
            索引有优点:提高查询速度
            索引有缺点:增加,删除,索引文件也需要更新的,所以更新操作有时候效率很低,占内存,占资源
            索引的分类
                主键索引(primary key)
                    alter table 表名 add primary key (id);
                    alter table 表名 drop primary key;
                唯一索引(unique)
                    可以有多个null,但是有具体内容时,则不能重复
                    不允许' '
                普通索引(index)
                    create index 索引名 on 表名 (列名1，列名2,...);
                联合索引(联合主键),
                组合索引
                    alter table 表名 add index my_ind (dname,inc);
                    explain select * from bb where dname = 'aaa'；//会使用组合索引查找
                    explain select * from bb where inc = 'aaa';//不会使用组合索引查找
                    explain select * from bb where dname = 'aaa' and inc = 'aaa'；//会使用组合索引查找
                全文索引
                    fulltext(title,body)
                    explain select * from articles where title like '%aaa%';
                    explain select * from articles where match(title,body) against('aaa')
                    企业一般不会采用全文索引
                    企业一般使用第三方搜索引擎 slor es
            mysql执行计划
                怎么知道语句正在使用什么索引呢?
                在语句之前加上explain
                explain select * from ccc where name='aaa' 
                    type为all是全表扫描
                    type为ref是索引查找
                    type为const是索引文件
            什么字段适合加索引
                where查询次数比较多，值有非常多的不同，需要加索引
            索引注意事项:
                1.使用组合索引:
                    第一个条件可以不用和第二个一起作为条件查找--会使用组合索引查找
                    第二个条件,不使用第一个条件--不会使用组合索引查找
                2条件加like
                    两个'%%'不会使用到索引,全表扫描
                    条件加like，开头不要% 'aaa%'会使用到索引，否则不会使用到索引
                    like不要开头使用%
                3.使用or
                    条件都必须加上索引,只要有一个条件不加索引,则不会使用索引查找
                4.判断语句,判断是否为null，一定要使用is null不要null
                    is null会使用到索引
                    = null是不会使用到索引的,是全表扫描
                5.group by 分组不会使用索引,是全表扫描,默认还给你排序
                    如果进制排序使用order by null;
                    explain select * from aa group by b order by null;
                6.分组需要效率高,禁止排序 order by null
                7.不要使用大于等于,大于等于会使用2次全表扫描,使用大于效率高点
                    select * from user where userId>=101; //低
                    select * from user where userId>100; //高
                8.不要给表留null
                    设计表的时候not null
                9.in 和not in,不要用
                    即使你加了索引,也不会使用索引的,全表扫描
                10.查询量大的时候怎么办?
                    缓存,分表，分页
            mysql的存储引擎
                myisam
                innodb 用的最多 还有事物机制
                memory
                innodb与myisam有什么区别?
                    批量添加--myisam效率高
                    innodb--事物机制
                    锁机制--myisam是表锁,innodb是行锁
                    数据结构--myisan支持全文检索,innodb不支持
                        三个类型都支持b-tree数据结果
                        索引都会缓存
                    支持外键
                        只有innodb支持,其他都不支持
                        企业也很少建主外键的,但是使用hibernate需要使用到
                myisam清理碎片化
                    .frm文件存放数据表
                    .MYD文件
                    .MYI文件存放的是索引
                    myisam删除的时候不会立马删除,要清理碎片化
                    optimize table aa;//清理碎片

        4.分库分表技术(取模算法,水平分割,垂直分割)
            什么时候分库
                电商项目将一个项目拆分，分成多个小项目,每个小的项目有自己单独的数据库
                这样互不影响---这个叫垂直分割
                会员数据库
                订单数据库
                支付数据库
            什么时候分表
                有一张表存了多年的数据,这样查询起来也是很慢的,比如日志(每年存放),
                可以根据年份来分表---水平分割(取模算法)
                腾讯QQ号可以根据位数进行分表 电信可以根据手机号的前3位分表
                
                例如用户表存放到三张表中,6条用户数据,怎么样分非常均匀
                    三张表 user0表 user1表 user2表
                    取模算法 非常均匀的分配 就需要专门有一张表存放userid 这个userid不能用自动增长了
                    1%3=1 1号用户放到 user1表
                    2%3=2 2号用户放到 user2表
                    3%3=0 3号用户放到 user0表
                    4%3=1 4号用户放到 user1表
                    5%3=2 5号用户放到 user2表
                    6%3=0 6号用户放到 user0表
                分表之后有什么缺点:1.分页查询就难了 2.查询非常受限制的
                先有一个主表，存放所有数据
                再有一个次表, 根据具体业务需求进行分表
                mycar分表功能
                阿里云rds已经帮我们做了这些内容,根本不需要担心 付费的不是免费的
        5.读写分离
        6.存储过程
        7.配置mysql的最大连接数(最大并发)
            my.ini
        8.mysql服务器升级
        9.随时清理碎片化
        10.sql语句的调优化

## mysql日志
    Error log 错误日志
    General query log普通查询日志
    Show query log 慢查询日志
    Binary log 二进制日志
      作用：
        1.增量备份
        2.主从
      show variables like '%log_bin%';查看bin_log 
      mysql-bin.000001这个是日志文件的数据文件
      mysql-bin.index这个是日志文件的索引文件
      查看索引
        cat /var/lib/mysql/mysql-bin.index
      查看日志
        mysqlbinlog /var/lib/mysql/mysql-bin.000001//去日志目录下看
        show binlog events\G;//要登陆mysql
        show binlog events in 'mysql-bin.000002';//要登陆mysql
        flush logs刷新日志文件,会产生一个新的日志文件
        每次服务器重启,服务器会调用flush logs，会新创建一个新的binlog日志
        show master status; 查看当前日志处于哪个的状态
        show master logs; 查看所有的bin-log日志
        reset master; 清空所有日志
        mysqlbinlog mysql-bin.000001 | mysql -uroot -p
        mysqlbinlog mysql-bin.000001 --start-position 219 --stop-position 421 | mysql -uroot -p

## 高可用
    大型互联网公司高并发是很多的
    服务器宕机后怎么实现容错？
        mysql高可用 redis高可用 nginx高可用
        主从复制,(主,备),读写分离来解决
    现在只有一台mysql服务器.如果宕机怎么办?
        主(master) 核心数据访问,读,写
        备(slave) 主挂了,主服务器备胎
        mysql集群，tomcat集群,redis集群...
        一主一备 多主多备 一主多备
    主机和备机的ip地址不一样的
        主机 权限(读,写)(create，update,insert,delete,select)
        备机 权限(读)(select)    
        读的时候走备机
        写的时候走主机
    读写分离会产生数据同步问题?
        主机当写操作的时候要立马同步到备机中
        主机一旦挂掉,那么会从多个备机中挑出一个作为主机
    主从复制
        mysql主从复制,是mysql自带的
        还有一些第三方的比如(mycat)
        使用场景:读写分离，数据备分，高可用，集群
    mysql主从复制的原理
        二进制sql执行文件
        insert，update,delete,create语句以日志的形式存储其起来
        主机和备机通过长连接连接起来，只要这个日志文件发生变化，
        备机都会把这个二进制sql执行文件拷贝到自己的服务器执行一下,数据就会一模一样
        同步的时候是会有延迟的但忽略不及,重试机制,可能存在同步数据不一致
        一般使用mycat来管理这个帮助我们管理主从复制存在的数据问题,权限问题
        主从复制服务器一般是走内网,速度是非常快的
    mysql主从复制的配置

        主机 172.17.0.2
        备机 172.17.0.3
        1.先查看是否开启bin_log
        2.配置主节点信息(server_id=)
            配置文件/etc/my.cnf
                [mysqld]
                server-id = 110   ##主从复制 服务Id唯一
                log-bin=/var/log/mysql/mysql-bin ##主从复制 开启日志文件
                port = 3306
                log-error=/var/log/mysql/error.log
                #只能用IP地址
                skip_name_resolve 
                #数据库默认字符集
                character-set-server = utf8mb4
                #数据库字符集对应一些排序等规则 
                collation-server = utf8mb4_general_ci
                #设置client连接mysql时的字符集,防止乱码
                init_connect='SET NAMES utf8mb4'
                #最大连接数
                max_connections = 300
            配置好,重启,查看是否修改了server_id
                show variables like 'server_id';
                show master status; 查看主服务器的状态
        3.设置从权限读取账号的权限
            配置文件/etc/my.cnf
                [mysqld]  
                server-id = 120   #主从复制 服务Id唯一
                log-bin=mysql-bin #主从复制 开启日志
                binlog_do_db=User #主从复制 同步主服务器的那个数据库
                port = 3306
                log-error=/var/log/mysql/error.log
                #只能用IP地址
                skip_name_resolve 
                #数据库默认字符集
                character-set-server = utf8mb4
                #数据库字符集对应一些排序等规则 
                collation-server = utf8mb4_general_ci
                #设置client连接mysql时的字符集,防止乱码
                init_connect='SET NAMES utf8mb4'
                #最大连接数
                max_connections = 300
            配置好,重启,查看是否修改了server_id
                show variables like 'server_id';
                show master status; 查看主服务器的状态
        4.同步    query_cache_type
        0:表示关闭查询缓存
        1:表示始终开启查询缓存
        2:表示按需开启查询缓存
            进入主服务器给从服务器设置账号权限(局域网内)
                grant replication slave on *.* to 'mysync'@'172.17.0.%' identified by 'q123456';
                flush privileges;
            进入从服务器开始同步
            stop slave;
            change master to master_host='172.17.0.2',master_user='mysync',master_password='q123456', master_log_file='mysql-bin.000002',master_log_pos=1309; 
            start slave; //启动IO复制
        5.检查服务器复制功能的状态
            在从服务器上
            show slave status\G;    //查看主从复制状态
            Slave_IO_Running:Yes  //此状态必须YES
            Slave_SQL_Running:Yes //此状态必须YES
        场景1:如果我们已经有一个数据库已经有数据了,向备份到salve
            先临锁表 flush tables with read lock;
            在mysql的外面备份sql文件 
              mysqldump -p3306 -uroot -p --add-drop-table aa > /tmp/master-aa.sql;
            到salve主机上,登陆mysql
              将sql文件导入到数据库
            保证数据库一致,然后设置主从复制
    mysql本身不自带读写分离,需要第三方中间件来实现
        配置主从复制,只能主的改变,会导致从的改变
        但是从的改变了数据,主的不会改变
        问题来了需要设置账号权限 从的服务器账号只能读数据，而不能写操作
        自己设置账号是可以的,但是有些麻烦,所以我们使用第三方中间件
        通过中间件转发到mysql服务器,让中间来识别读写,然后转发识别到主服务器还是从服务器
        其实类似于nginx负载均衡,反向代理,这个我们叫数据库负载均衡,数据库的反向代理
        好处:
            不暴露IP地址,多台服务器是内网进行通信的,只暴露中间件的公网的IP地址,安全系数高
            读写分离数据库只需要在中间件配置权限就好了,非常方便
        数据库层面的中间件mycat
        nginx(服务器层面的中间件),IV5,F5(硬件层面的中间件)
        mycat会虚拟一个数据库 连接地址(本机的ip地址) 端口8066 库mycat
        mysql -uroot -proot -P8066 -h127.0.0.1

## 主主复制
    主主复制参考主从复制配置
    注意到id自增会出现不一样的情况下，配置主键自增的增长策略
    master1配置文件中配置
      [mysqld]
      auto_increment_increment=2
      auto_increment_offset=1
    master2配置文件中配置
      [mysqld]
      auto_increment_increment=2
      auto_increment_offset=2
    这样保证主键不会插入不进去的情况,比如一个是奇数id插入，一个是偶数id插入

# HAProxy实现mysql负载均衡
    解压安装包
      tar -zxvf haproxy-1.7.8.tar.gz
    编译安装
      yum install gcc-c++
      uname -a 查看内核
      编译
        make TARGET=linux26
      安装
        make install PREFIX=/usr/local/haproxy
    HAProxy是基于TCP进行通讯的,正好mysql也是基于TCP进行通讯的
    HAProxy使用 给多台mysql服务器进行负载均衡的读操作
    HAProxy的算法，配置文件中 balance xxx
      roundrobin,表示简单的轮询,这个不多说,这个是负载均衡基本都具备的
      static-rr,表示根据权重
      leastconn,表示最少连接者优先处理
      source, 表示根据请求源IP
      uri, 表示根据请求的URI
      uri_param,表示根据请求的URI参数'balance url param' requires an URL parameter name
      hdr(name)，表示根据HTTP请求头来锁定每一次HTTP请求
      rdp-cookie(name),表示根据cookie(name)来锁定并哈希每一次TCP请求
    在haproxy.cfg文件配置
      global
        #daemon # 后台方式运行
        nbproc 1
        pidfile /usr/local/haproxy/conf/haproxy.pid
      defaults
          mode tcp			#默认模式mode { tcp|http|health }，tcp是4层,http是7层,health只会返回OK
          retries 2			#两次连接失败就认为是服务器不可用,也可以通过后面设置
          option redispatch	#当serverId对应的服务器挂掉后,强制定向到其他健康的服务器
          option abortonclose	#当服务器负载很高的时候,自动结束掉当前队列处理比较久的连接
          maxconn 4096		#默认的最大连接数			
          timeout connect 5000ms	#连接超时
          timeout client 30000ms  #客户端超时
          timeout server 30000ms  #服务器超时
          #timeout check 2000 #心跳检测超时
          log 127.0.0.1 local0 err #[err warning info debug]

      listen test1	#这里是配置负载均衡,test1是名字,可以任意
          bind 0.0.0.0:3306	#这是监听的IP地址和端口,端口号可以在0-65535之间,要避免端口冲突
          mode tcp	#连接的协议,这里是tcp协议	
          #maxconn 4086
          #log 127.0.0.1 local0 debug
          server s1 172.17.0.2:3306 check port 3306 #负载的机器
          server s2 172.17.0.3:3306 check port 3306 #负载的机器,负载的机器可以有多个,往下排列即可
          server s3 172.17.0.4:3306 check port 3306 #负载的机器
          server s4 172.17.0.5:3306 check port 3306 #负载的机器
          # balance source

      listen admin_stats
          bind 0.0.0.0:8888
          mode http
          stats uri /test_haproxy
          stats auth admin:admin

# Keepalived 高可用
    cd /usr/local/etc/keepalived
    vim keepalived.conf
      global_defs {
        #noticatition_email {
        #  user1@yzy.cn
        #}
        #notification_email_from user2@yzy.cn
        #smtp_server localhost
        #smtp_connect_timeout 30
        router_id LVS_MASTER #只要和另外一个keepalived不一样就可以了
      }
      vrrp_script chk_mysql { # 制定执行的脚本
        script "/root/soft/mysql.sh"
        interval 10
      }
      vrrp_instance VI_1 {
        state MASTER # 只能是MASTER|BACKUP 主从
        interface eth0 # 制定选择的网卡
        virtual_router_id 51 # 虚拟路由节点必须相同
        priority 100 # 优先级 越大成为主节点的概率越大 必须是大于对方的50以上才可以成功拿到优先级
        advert_int 1 # 多个节点发送心跳包的时间间隔
        authentication { # 每天节点的授权必须配置一样的
          auth_type PASS
          auth_pass 1111  
        }
        track_script {
          chk_mysql # 执行脚本
        }
        virtual_ipaddress { #虚拟ip地址
          192.168.153.200/24
        }
      }
    启动keeplaived
      cd /usr/local/sbin
      ./keepalived -D -f /usr/local/etc/keepalived/keepalived.conf
      ip a 查看当前工作节点
    邮件报警
      1.在配置文件配置,但是不好
      2.keepalived通过调用shell脚本
        搭建smtp服务器
            yum install postfix* 
            cd /etc/postfix/
            vim main.cf
              myhostname = mail.yzy.cn #配置主机名
              mydomain = yzy.cn #主机名
              myorigin = $myhostname
              myorigin = $mydomain
              inet_interfaces = all
              inet_protocols = all
              mydestination = $myhostname, $mydomain
              mynetworks = 192.168.153.0/28, 127.0.0.0/8
              replay_domains = $mydestination
            保存,启动 service postfix start
            查看是否启动 
              netstat -tunlp | grep 25
              netstat -tunlp | grep master
              ps -ef | grep master 
            yum install dovecot 接受邮件服务器
            cd /etc/dovecot/
            vim dovecot.conf
              protocols = imap pop3 lmtp
            service dovecot start
            netstat -tunlp | grep 110
            yum install mail 安装一个发邮件的客户端
            useradd user1
            passwd user1
            useradd user2
            passwd user
        关闭防火墙
          1.vim /etc/selinux/config
            SELINUX=disabled
            重启服务器reboot
          2.setenforce 0
        编写shell脚本
            vim mysql.sh
              #!/bin/bash

              nc -w2 localhost 3306
              if [ $? -ne 0 ]
              then
                echo "mysql's 3306 port is down" | mail user1@zl.cn -s "mysql is down"
                # service mysql stop
              fi
            配置计划任务来监听发送邮件
              crontab -e
              */2 * * * * /root/soft/mysql.sh
            keepalived来监听发邮件
              
      3.第三方的监控程序

# 分库分表
    物理切分
      共享表空间: 就是所有的数据库的数据都放在一个物理文件里面
      独享表空间: 安装一个表一个物理文件里面
      show variables like '%innodb_file_per%'; #查看表空间
      set global innodb_file_per_table=off; #设置为独享表空间
      set global innodb_file_per_table=1; #设置为共享表空间
      InnoDB(共享表空间,独享表空间) 默认是共享表空间
        frm 结构文件
        ibd 数据文件
        ibdata1 数据文件
      MyISam
        frm 结构文件
        myd 数据文件
        myi 索引文件
      数据库本身的分表分区策略
        range
          create table t_range (id int primary key auto_increment,name varchar(10)) partition by range(id)(
            partition p0 values less than(1000000),
            partition p1 values less than(2000000),
            partition p2 values less than(3000000),
            partition p3 values less than(4000000),
            partition p4 values less maxvalue
          );
          alter table t_range drop partition p0;
        List
          create table t_list(id int primary key auto_increment,province int) partition by list(id)(
            partition p0 values in(1,2)， #'山东省'， '江苏省'
            partition p1 values in(3) # '安徽省'
          )
        Hash
          create table t_hash(id int primary key auto_increment,province int) partition by hash(id) partitions 4;        
        Key
    数据库切分
      什么是数据切分
        通过特定的手段,将我们放到同一个数据库中的数据发散到多个数据库中,或者分散到多个节点中。
      切分的优点
        分散单台设备的负载
        提高数据安全性
      切分的缺点
        增加了系统的复杂度
        引入分布式事物
          解决
            使用mq
            Tcc事物
            最大努力通知
        跨节点的join
        跨节点的排序分页
        多数据源管理的问题
      切分的类型
        水平切分
        垂直切分
      全局序列号
        专门有一个生存序列号,用全局序列号来保证主键全局唯一性
        如何实现?
          通过代码手动实现
          通过数据库的主键生存策略来实现
          使用时间戳
          使用第三方组件或服务
      如何进行切分,手段
        1.自己实现，连接多个数据源,通过代码进行需求的操作
        2.客户端组件
          dangdang的Sharding JDBC
        3.数据库中间件
      多租户
        独立数据库
          隔离性最好,安全性最高,数据备份和恢复最为方便,价格最高
        共享数据库,独立数据架构
        共享数据库,共享数据架构
          隔离性最差，安全性最差，数据恢复困难,价格最便宜
    数据库切分策略
      枚举
        确定分片的表,分片的字段
        1000=0
        2000=1
        3000=3
      hash
        任意长度的输入进行运算返回一个固定的hashCode值
        Java Object里面的本地方法hashCode==object.hashCode()
        对id进行hash得到hash值，再将hash值(转换成二进制) 与上3(转换成二进制) 得到id的后两位
        ，id后两位的值就是表的后缀。
      范围约定
        1-100 0
        100-200 1
        200-300 2
      取模
        如果是三张表,分别为table_0,table_1,table_2
        num%3 这个3就是切片的大小
      按日期分片
        如果数据量小的话，我们可以按照年来
        如果数据量大的话,我们可以天,小时....来
        假如10天来分的话
      其他分片策略
    全局表
      全局表的插入、更新操作会实时在所有节点上执行，保持各个分片的数据一致性
      全局表的查询操作,只从一个节点获取
      全局表可以跟任何一个表进行join操作
      比如:设备表,城市表...

# mycat
    mycat安装
    wrapper.conf文件里面修改内存
    用户从哪里来 server.xml
    数据库从哪里来 schema.xml
    mycat本身的高可用,可以切换主节点
    mycat的分片策略
      rule.xml下面的每个function对应一个class,还对应了配置文件就是一个分片规则
    mycat全局表配置
      在所有节点都有这个全局表, 解决跨界点join
      <table name="aa" primaryKey="ID" type="global" dataNode="dn1,dn2,dn3">
    mycatER主表和明细表
      保证一对多的关系要放到同一个节点上
    mycat实现读写分离
      主服务器使用InnoDB,从服务器使用MyISAM
      show engines; 查看数据库引擎
      在mysql的配置文件中[mysqld]加入default-storage-engine=INNODB，default-storage-engine=MyISAM
    先执行一条sql语句，然后explain sql语句来查看到底插入到那几个节点  

# mycat集群
    HAProxy

# mysql的查询缓存
    show variables like '%query_cache%'
    query_cache_type
        0:表示关闭查询缓存
        1:表示始终开启查询缓存
        2:表示按需开启查询缓存
    select sql_cache * from xxx