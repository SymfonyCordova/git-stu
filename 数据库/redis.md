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
功能相对局限,使用极大的内存才可调配,且系统处理算法时将有数秒甚至更长的时间的 不可用,导致大量处理超时
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
    redis默认是没有密码的,可以在配置文件中配置密码
        requirepass foobared 修改为 requirepass 123456
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
获取key的value。如果与该key关联的value不是string类型,redis将返回错误信息,因为get命令只能于 获取String value;如果该key不存在,返回(nil)

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

## redis-LinkedList【双向链表 重点】
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
    
    rpoplpush resource destination：将链表中的尾部弹出并添加到头部【循环操作】
    这个命令很常用
    需求 两队排队 将一个链表的尾部添加到另一个链表的头部 
    检查眼睛排队 list1
    检查耳鼻喉排队 list2
    
    lpush list1 a b c d
    rpoplpush list1 list2
    
    需求2 循环列表
    早晨起床,中午吃饭,晚上敲代码
    将自己的列表中的尾部放到头部 这样一直循环
    rpoplpush list1 list1
```


## redis-set【set无序,不重复集合 重点】
```
类似于Java HashSet 无序,不重复
Redis操作中,涉及到两个大数据集合的并集,交集,差集运算

赋值:
    sadd key values[value1, value2 ...]
    向set集合中添加数据,如果该key的值已经有了则不会重复添加
 
取值:
    smembers key:
    获取set中所有的成员
    
    sismember key member：
    判断参数中指定的成员是否在该set中 1表示存在,0表示不存在或者该key本身就不存在
    
    sdiff key1 key2...:
    返回key1与key2中相差的成员,而且与key的顺序无关。即返回差集
    差集运算
    返回属于key1且不属于key2的元素构成的集合
    
    sinter key1 key2 key3 ...
    返回交集
    返回属于key1且属于key2且属于key3元素构成的集合
    
    sunion key1 key2 key3...
    返回并集
    返回把所有集合的数据放到一起 并且不能重复

删除:
    srem key members[member1,member2...]
    删除set指定的元素

扩展:
    scard key:
    获取集合成员的数量
    
    srandmember key：
    随机返回set中一个成员
    
    sdiffstore destination key1 key2...
    将key1，与key2相差的成员存储在destinantion上
    
    sinterstore destination key1 key2...
    返回的交集存储在destination上
    
    sunionstore destination key1 key2...
    返回的并集存储在destination上
```

## redis-set【set有序,不重复集合 了解】
```
有序,不重复
有序set集合,专门来做排行榜
几乎所提的命令都是来做排行榜的

赋值:
    zadd key score member score member2...
    将所有成员以及该成员的分数存放到sorted-set中。
    如果该元素已经存在则会用新的分数替换原有的粉丝。
    返回值是将新加入的集合的元素个数,不包含之前已经存在的元素
    需求
        [5000 xiaoming 1000 xiaohong 500 xiaozhang]
        zadd set3 5000 xiaoming 1000 xiaohong 500 xiaozhan
        填完之后已经排序了 默认是从小到大
查看:
    zscore key member
    返回指定成员的分数
        zscore set3 xiaoming
    
    zcard key
    获取集合中的成员数量
    
    zrange key start end[withscores]
    获取集合中脚本为start-end成员,[withscores]参数表明返回的成员包含其分数
        查询所有的
        zrange set3 0 -1
        查询所有的并带上分数
        zrange set3 0 -1 withscores
        
    反转过来倒序执行
    zrevrange set1 0 -1 withscores
    
删除:
    zrem key member[member...]
    移除集合中指定的成员,可以指定多个成员
        例如 zrem set3 xiaoming xiaohong
扩展
    zrevrange set1 0 -1 withscore 
    反序
    
    zremrangebyrank key start stop 
    返回按照排名范围删除元素
        例如 zremrangebyrank set1 0 1删除前两名
        
    zremrangebyscore key min max 
    返回按照分数范围删除元素
        例如 zremrangebyscore set1 500 1500 
        
    zrangebyscore key min max [withscores] [limit offset count] 
    返回分数在[min,max]的成员并按照分数从低到高排序
    [withscores]:显示分数
    [limit offset count]: 表名从脚标为offset的元素开始并返回count个成员
    
    zincrby key increment member
    设置指定成员的增加的分数
    返回值是更改后的分数
    
    zcount key mim max
    获取分数在[min,max]之间的成员
    
    zrank key member
    返回成员在集合中的排名。索引（从小到大）
    
    zrevrank key member
    返回成员在集合中的排名。索引（从大到小）
```

## redis的通用命令【重点】
```
Redis五种数据类型, String hash list set 有序set

keys pattern
获取所有与parent匹配的key,返回所有与该key匹配的keys
    *表示任意一个或多个字符
    ？表示任意一个字符

    keys * 查询所有的key
        例如 匹配带字母e的所有key的集合 keys *e*
    keys ? 
    
del key1 key2...:删除一个key
exits key: 判断该key是否存在 1存在 0不存在
rename key newkey:为当前的key重命名
type key: 获取指定key的类型。该命令将以字符串的格式返回。
    返回的字符串为 string list set hash 和 zset
    如果key不存在返回none
expire key ：设置生存时间 单位,秒 默认是永久生存
    如果某个key过期了,redis会将其删除
    例如 expire set1 30
ttl key: 获取该key的剩余超时时间,如果没有设置超时,返回-1 如果返回-2表示超时不存在
    说白了就是查看key还有多少寿命
```

## 扩展知识-消息订阅与发布【了解】
```
订阅新闻,新闻发布 比如QQ右下方会弹出一个消息新闻 其实就是发布了一个html代码

subscribe channel:订阅频道 例: subscribe mychat,订阅mychat这个频道
psubscribe channel: 批量订阅频道,例： psubscribe s*,订阅以"s"开头的频道

publish channel content:在指定的频道中发布消息 如 publish mychat "today is newday"
```
## 扩展知识-多数据库【了解】
```
MySql-数据库可以自己用语句自定义创建
    create database xxxx;
    
redis也是有数据库的。提前创建好了
redis默认有16个数据库。0, 1, 2....15

在redis上所做的所有操作,都是默认在0号数据库上操作

切换数据库:
    select 数据库名 比如select 1 
把某个键值对即进行数据库移植,移植后的原来的库就没有了新的库就有这个key:
    move newkey 1 将当前库的key移植到1号库中 

数据库的清空:
    flushdb
redis服务器数据清空
    flushall
```
## 扩展知识-redis批量操作事务【了解】
```
Mysql事务: 目的保证数据的完整性,安全
redis事务: 目的是为了进行redis语句的批量执行
    redis与其说是事务,不如说是批量操作仅此而已

multi: 开启事务用于标记事务的开始,其后执行的命令都将被存入命令队列，
        直到执行EXEC时,这些命令才会被原子的执行,类似于关系型数据库中的begin transaction
exec:事务提交,类似与关系型数据库的:commit
discard:事务回滚,类似于关系型数据库中的:rollback
```

## 扩展知识-redis了解命令【了解】
```
ping: 看看有没有和服务器连接
echo: 
quit: 退出客户端
dbsize: 返回当前数据库中key的数目
info:  查看redis数据
```
## 扩展知识-redis持久化【了解】
```
内存:高效、断电数据会消失
硬盘:读写速度慢于内存,断电数据依旧存在

持久化:把数据保持在硬盘上

关系型数据库Mysql持久化
    任何增删改语句,都是在硬盘上做的操作
    断电以后,硬盘上的数据还是存在
    mysql使用事务和硬盘，保证数据的安全性

非关系型数据库redis
    默认情况下,所有的增删改,数据都是在内存中操作。
    断电以后,内存中的数据是不存在的
    
    断电后,redis的部分数据会丢失,丢失的数据是保存在内存中的数据

Redis是存在持久化操作的

Redis有两种持久化策略:
    RDB: 是redis的默认持久化机制
        RDB相当于照快照。保存的是一种状态。
            20G数据-->几kb快照
        优点:
            1.快照保存数据速度极快,还原数据速度极快
            2.适用于灾难备份
                把dump.rdb拷走就行
         缺点:
            1.小内存机器不适合使用的
            RDB机制符合要求就会照快照 (随时随地启动),会占用系统一部分系统资源(突然的) 很可能内存不足直接胆机
            胆机后服务器关闭，非正常关闭
               
         适用于:内存比较充裕的计算机
         
         RDB何时进行照快照
             1.服务器正常关闭时 照快照
                ./bin/redis-cli shutdown
             2.key满足一定条件,照快照
                save 900 1 # 每900秒(15分钟)至少1个key发送变化,则dump内存快照
                save 300 10 # 每300秒(5分钟)至少10个key发送变化,则dump内存快照
                save 60 10000 # 每60秒(1分钟)至少10000个key发送变化,则dump内存快照     
    
    AOF:使用日志功能保存数据操作
        默认AOP机制关闭的
        
        每秒同步: 每秒进行一次AOP保存数据  安全性低 比较节省系统资源
        每次修改同步: 只要有key变化语句,就进行AOF保存数据。比较安全，但是极为浪费效率
        不同步(默认): 不进行任何持久化操作 不安全
        
        AOF操作:
            只会保存导致key变化的语句
        AOF配置:
            always  每次有修改发生时都会写入AOF文件
            everysec 每秒钟同步一次,该策略为AOF的缺省策略
            no 从不同步。高效但是数据不会被持久化
            
        在redis配置文件中的
            开启AOF机制
                appendonly no 改成yes
            策略选择
                选择一个总是同步的
                appendfsync always
            查看日志文件
                cat appendonly.aof
                发现保存的都是修改的语句
        优点:
            会持续性占用极少量的资源 AOF日志程序会占用几Kb的内存去保存语句
        缺点: 
            日志文件appendonly.aof会特别大 不适用灾难恢复
            恢复效率远远低于RDB
            
        适用于内存比较小的计算机  
        
```

# Redis主从复制高可用
```
    redis支持一主多从,不支持多主多从
    主服务器有读写权限
    从服务器只有读权限
    哨兵机制: 监听所有服务器,如果发现主服务器宕机,重新从剩下多个从服务器选择一个为主服务器(采用投票选举)
    如果所有的服务器都宕机,如何保证重启,使用keepalived监听自动重启,但是一直不能重启,发送短信邮件给运维人员
    注意: keepalived是一个脚本,能重启很多软件，keepalived+哨兵机制实现高可用
    
    redis主从复制配置
        主服务器是不需要做任何配置的,需要在从服务器配置
        replicaof 172.17.0.4[主机名] 6379[端口号]
        masterauth 123456[主机密码]
    redis哨兵机制选举主服务器,再加入一台哨兵服务器
        在sentinel.conf文件中拷贝到redis安装目录下并配置
            sentinel monitor mymaster 172.17.0.2 6379 1
            sentinel auth-pass mymaster 123456
            sentinel down-after-milliseconds mymaster 30
            sentinel parallel-syncs mymaster 2
```

## redis实现分布式锁
```
    setnx
```