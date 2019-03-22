## redis简述
```
关系型数据库(sql)
mysql oracle
特点:数据和数据之间,表和字段之间,表和表之间存在关系的
优点: 
数据之间有关系,进行数据的增删改查时非常方便的
关系型数据库,有事务操作。保证数据的完整性
缺点:
因为数据和数据之间的关系,是由底层大量算法保证
select * from product
select * from category
大量算法会拉低运行速度
大量算法会消耗系统资源
海量数据的增删改时会显得无能为力
很可能胆机
海量数据环境下对数据表进行维护/扩展,也会变得无能为力
update product set cname = ‘手机数码’;
把商品表的cname字段,由varchar(64) , char(100)

适合处理一般量级的数据,安全
钱

非关系数据库(NOSQL):
为了处理海量数据,需要将关系型数据库的关系 去掉

非关系型数据库设计之初 是为了替代 关系型数据库的
redis

优点:
海量数据的增删改查,非常轻松应对
海量数据的维护非常轻松
缺点:
数据和数据之间没有关系,所以不能一目了然
非关系型数据库,没有关系,没有强大的事务保证数据的 完整和安全

适合处理海量数据,效率 不一定安全
奥运健儿奖牌总数 

关系型数据库+非关系型数据库====>项目
重要数据保存到关系型数据库     
海量不重要的操作数据,保存到非关系型数据库
要做到分批保存到不同的数据库
```
## NOSQL数据库的分类
```
键值(Key-Value)对存储数据库
Redis
内容缓存,主要处理大量数据的高访问负载
一系列的键值对
优秀的快速查询,稳定性强
存储的数据缺少结构化
列存储数据库
HBase
分布式文件系统
以列簇式存储,将同一列数据存在一起
查找速度快,可扩展性强,更容易进行分布式扩展
功能相对局限,使用极大的内存才可调配,且系统处理算法时将有数秒甚至更长的时间的		不可用,导致大量处理超时
文档型数据库(淘汰)
MongoDB
图形(Graph)数据库
Neo4j
社交网络
```

## Redis使用环境:
```
1.作为关系型数据库的缓存

2.可以做任务队列

3.大量数据运算

4.排行榜
Redis非常擅长做大量数据的排行榜
比如排序 mysql 里面的 count(*) 可以替代给redis来做 
```

## Redis的安装
```
1.redis是c语言开发,安装redis需要先将官网下载的源码进行编译,编译依赖gcc环境。
如果没有gcc环境需要先安装gcc
yum install gcc-c++

2.下载wget http://download.redis.io/releases/redis-5.0.4.tar.gz

3.解压tar -zxvf redis-5.0.4.tar.gz

4.进入解压后的文件夹 make编译

5.安装 make PREFIX=/usr/local/redis install

6.查看进入/usr/local/redis/bin 
redis-cli  
redis-server

7.复制文件
回到解压后的文件夹redis-5.0.4下面有一个redis.conf
cp  redis.conf  /usr/local/redis
    如果没有配置文件redis也可以启动,不过将启动默认配置,这样不方便我们修改端口
```

## Redis启动分前端启动和后端启动
```
前端启动
进入安装文件
启动服务
./bin/redis-server
启动客户端
./bin/redis-cli 默认的连接了本机的6379端口
./bin/redis-cli -h ip地址 -p端口
   ./bin/redis-cli -h 127.0.0.1 -p 6379
缺点
  无法部署集群

后端启动
后端启动需要修改redis.conf配置文件,daemonize yes 以后端模式启动
vim /usr/local/redis/redis.conf
  daemonize yes
启动时指定配置文件
  cd /usr/local/redis/
  ./bin/redis-server ./redis.conf
启动完了查看一下redis进程
ps -ef | grep -i redis
好处:
  可以在配置文件改一下端口号,可以启动多个redis 这样就能部署一个redis集群
```

## redis的关闭
```
1查询到PID,kill - 9 pid 【断电,非正常关闭,一般不用,否则造成数据丢失】
2正常关闭【正常关闭,数据保存】
./bin/redis-cli shutdown
```

## redis 数据类型
```
redis使用的是键值对 保存数据(map)
  key:全部都是字符串
  key名不要过长否则影响使用效率
  key名起一个有意义的
  value: 有5种数据类型
    string  “小红,小明”
    hash 很类似于json格式 可以存javaBean
       {uname:”张三”,age:”18”}
    list 类似于链表 添加和删除效率高 类似于java的LinkedList
       [1,2,3,4,5]
    set 集合 类似于Java的HashSest
       [‘a’, ‘b’]
    有序的set集合 类似于排行榜
       [5000  ‘a’,  1000  ‘b’, 10  c]
```

## redis命令-String命令【重点】
```
字符串类型是Redis中最为基础的数据存储类型,字符串在Redis中是二进制安全的,这便意味着该类型存入和获取数据相同。
在Redis中字符串类型的Value最多可以容纳的数据长度是512M

二进制安全和数据安全是没有关系的
mysql-关系型数据库,二进制不安全【解码和编码不一致会乱码丢失数据】
redis 二进制数据安全

赋值:
set  key  value：
设置key持有指定的字符串value,如果该key存在则进行覆盖操作。总是返回”ok”
如果赋值相同的key,新的value覆盖老的value

取值：
get key
获取key的value。如果与该key关联的value不是string类型,redis将返回错误信息,因为get命令只能于 获取String value;如果该key存在,返回(nil)

删除：
del key
删除指定的key
返回值是数字类型,表示删了几条数据

扩展:
getset key value：
先获取该key的值,然后在设置该key的值
返回之前的value

incr key: 
将指定的key的value原子性的递增1,
如果key不存在,其初始值为0,在incr之后其值为1
如果value的值不能转成整型,如hello,该操作将执行失败并返回错误信息
正确返回加加后的结果

decr key:
将指定的key的value原子性的递减1
如果key值不存在,其初始值为0,在incr之后其值为-1
如果value的值不能转成整型,如hello,该操作将执行失败并返回错误信息
正确返回减减后的结果

append key value:
拼凑字符串
如果key值存在,则在原有的value后追加该值
如果key只不存在,则重新创建一个key/value

incrby key number：
incrby num1 10 在原有的基础上增加10 

decrby num1 number:
decrby num1 10 在原有的基础上减去10

String的使用环境:
主要用于保存json格式的字符串
```

## redis命令-hash【了解】
```
redis中的hash类型可以看成具有String Key和String value的map容器。所以该类型非常适合存储值对象的信息。如Username、Password和Age等。
如果Hash中包含很少的字段,那么该类型的数据也将仅占用很少的磁盘空间。每一个Hash可以存储4294967295个键值对

flushdb：将数据库中的所有键值对都删除掉

赋值:
hset key field value
为指定的key设置field/value对(键值对)
hmset key field value[field2 value2...]
设置key中的多个field/value

取值:
hget key field
返回指定key的field的值
hmget key fields
获取key中的多个field的值
hgetall key
获取key中的所有field-value

删除:
hdel key field[field...]
可以删除一个或者多个字段,返回值是被删除的字段个数

del key
删除整个hash 

扩展命令
hincrby key field number
设置key中field的值增加number,如age 增加20

hexists key field
判断指定的key中的field是否存在

hlen key
获取key所包含的field的数量

hkeys key
获取所有字段

hvals key
获取所有的value
```

## Jedis【重点】
```
Redis 有什么命令,Jedis就有什么方法

开发6379端口
设置linux的防火墙
  /sbin/iptables -I INPUT -p tcp --dport 6379 -j ACCEPT
  /etc/rc.d/init.d/iptables save


取消redis值允许本机访问
在redis.conf配置文件中
注释掉bind
#bind 127.0.0.1

默认不是守护进程方式运行，这里可以修改
daemonize no

禁用保护模式
protected-mode no


Jedis连接池

Jedis连接池工具
```

## redis-LinkedList【重点】
```
Java List 数组ArrayList
链表LinkedList
双向链表
增删快

为什么redis选择了链表
redis操作中,最多的操作是进行元素的增删
使用环境:
1做大数据集合的增删
2任务队列
用户任务队列

检查口腔:小明,小红
检查眼科: 小张,小李
检查耳鼻喉:小刘

链表是有两端的 头和尾
在redis的头叫左端 尾叫右端

赋值(也叫在两端操作):
    lpush key values[value1 value2 ...]
    在指定的key所关联的list的头部插入所有的values
    如果该key不存在,该命令在插入之前创建一个与key关联的空链表,之后再向该链表的头部插入数据
    插入成功，返回元素个数
    所以lpush是反过来的
    
    rpush key value [value ...]
    在key对应 list 的尾部添加元素

取值:
    lrange key start end
    获取链表中从start到end的元素的值
    start、end从0开始计数
    也可以为负数,如为-1则表示链表的尾部元素 -2则倒数第二个,依次类推

    查询其中一个值
    lrange list1 1 1
    查询所有
    lrange 0 3
    lrange list1 0 -1
    
删值(也叫两端操作,还叫做弹出):
    lpop key
    返回并弹出指定key关联链表的第一个元素,即头部元素。
    如果该key不存在,返回nil
    如果该key存在,则返回链表头部元素
    
    rpop key
    从尾部弹出元素

扩展
    llen key: 返回指定的key关联的链表的元素的数量
    
    lrem key count value: 删除count个值为value的元素
    如果count大于0,从头向尾遍历并删除count个值为value的元素
    如果count小于0,从尾向头遍历并删除count个值为value的元素
    如果count等于0,则删除链表中所有等于value的元素
    效率低下
    
    del key 删除list
    
    lset key index value: 设置链表中的index的脚标的元素值
    0代表链表的头部元素 
    -1代表链表的尾部元素
    操作的链表的脚标不存在,则抛出异常
    效率低下
    
    linsert key before|after pivot value: 在pivot元素前或元素后插入value的元素
    效率低下
    
```
