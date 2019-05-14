# 外网映射工具
    将本地服务器映射的外网
    natapp.cn 方便调试支付宝 微信

# servlet
    设计模式:单例模式 
        servlet是单例的多线程 
    servlet生命周期 
        init -- 初始化 只会执行一次 第一个请求会执行一次,之后的请求不会在执行
        service -- do,post 多线程执行多次这个方法 类是单例的但是方法里面的局部变量可以根据多线程不一样的
        destory -- tomcat服务器被停止时,会执行次方法
    servlet源码分析
        servlet的执行流程
            1.读取web.xml文件解析servlet
            2.使用java的反射机制初始化servlet
            3.HttpServlet父类service方法判断请求方法
            4.具体实现子类方法  doGet doPost...
        service和doGet的方法的区别?
            service判断请求方式
            service方法调用doGet方法
    servlet是否线程安全
        不安全，因为servlet是单例的

# cookie与session的底层执行过程
    Cookie的执行流程
        1.创建Cookie放到response响应头中,返回给客户端
        2.客户端获取服务器创建cookie信息,保存本地
        3.每次请求浏览器会将本地cookie信息存放request请求头中
        4.服务器端直接从请求request.getCookie头中获取我们的cookie信息
    Cookie能不能跨浏览器查询?
        不能
    Session
        //默认是不传是true，没有sessionid 我会创建session
        //一般是获取的时候设置为false,防止重新创建
        req.getSession(false)
    Session执行流程
        1.调用req.getSession(true)
        2.创建session值后,将sessionid放到response响应头里面返回给客户端
        3.本地sessionid放入在请求头request中
        4.服务器端使用请求头获取sessionid找到对应的session值的信息
    为什么换一个浏览器查询不到
        主要是cookie里面没有JSESSIONID
    Cookie和Session的区别
        Cookie内容都存在浏览器的本地
        JSESSIONID主要是通过Cookie发给客户端的
        session的id是存放到了客户段
        session的id对应的value是存放在服务器端 默认是在内存中的
    
    session的值默认存放在内存中,如果web服务器重启和意外发生导致session的value没有了
    ，而浏览器拿着sessionid就会查不到,如何解决呢?
        将session存放到redis中
    
    集群之后session共享问题
    session怎么解决发布失效问题

# Http协议
    http协议:对浏览器客户端和服务端之间数据传输的格式规范
    B/S模式的同步是请求了会立马有响应
    B/S模式的异步是请求了不立马有响应 放到消息中间件中 等消费完了再通知给调用者
    ajax的同步是代码还是从上往下走。   
    ajax的异步类似多线程一条新的执行路径。默认是异步的

    Http组成部分
        HttpServletRequest
            请求行
                Request URL: https://blog.csdn.net/itmyhome1990/article/details/48765703
                Request Method: GET
                Status Code: 200 
                Remote Address: 127.0.0.1:1080
                Referrer Policy: origin
            请求头    
            请求体
        HttpServletResponse
            响应头
            响应体 --重定向与转发原理
    抓包分析
        抓包工具
    请求重定向
        response.setStatus(302);response.addHeader("Location","URL");
        快捷方式：response.sendRedirect("URL");
    请求转发
        request.getRequestDispatcher().forward();
    请求包含
        request.getRequestDispatcher().include();
        请求包含的机制可以理解成函数调用，相当于把第二个servlet 中的代码拷到这里来执行。
    防盗链
        通过referer信息防盗链
        String ref = request.getHeader("Referer");
        String serverName = req.getServerName()
        //ref == null 浏览器直接访问资源 ref为null
        //if (ref == null || ref == "" || !ref.startsWith("http://localhost")) {
        if (ref == null || ref == "" || !ref.contains(serverName)) {
            response.sendRedirect(request.getContextPath() + "/homePage.html");
        } else {
            this.getServletContext().getRequestDispatcher("/WEB-INF/fengjie.html").forward(request, response);
        }
    
    时间戳js图片请求后面会加上一个时间戳,防止浏览器缓存
        304是读取浏览器缓存内容
        200是重新请求的
    
    http和https的区别
        https ssl+证书传输--非对称加密,证书加密 缺点:效率低,安全非常高
        http 不安全 抓包工具

        抓包工具作用:通过宽带连接,都可以通过抓包分析请求
        1.笔记本上创建一个wif
        2.手机链接wif
        3.fiddler抓包工具可以分析请求
        4.不要轻易链接分析

        post请求 浏览器看不到提交参数 抓包可以分析到这个参数
        移动app接口注册密码都需要加密传输
        电商架构 要求: https，微信开发,ios自带浏览器http没有任何证书,无法访问
    软件模拟请求postman
    java模拟请求httpclient

# 长连接和短连接
    http1.0 属于短连接
    http1.1 保留短连接,新增长连接 默认长连接 响应头:Connection:keep-alive
    短连接
        建立连接(三次握手)->数据传输->关闭连接(四次挥手)
    长连接
        建立连接(三次握手)->数据传输->保持连接->数据传输->关闭
        效率高
    http1.1长连接什么时候关闭
        1.配置失效时间 它是有心跳检测时间 客户端没有一直发送数据 直接关闭
        2.客户端主动关闭
        3.tomcat服务器 配置长连接超时配置时间 20分钟
    长连接与端连接场景
        长连接:默认网站长连接，rpc远程调用 dubbo netty 移动APP消息推送 长连接心跳检测
        短连接:调用别人的接口,如果不是特别频繁,基本上都是短连接 响应头设置Connection:keep-alive timeout短连接

# 跨域实战解决方案
    什么是跨域:跨域其实是浏览器安全机制,请求的域名与ajax请求地址不一致 浏览器会直接无法访问浏览器
    解决办法:
        1.jsonp支持get请求不支持post请求
        2.使用接口网关---nginx,springcloud zull---互联网公司使用这个
        3.httpclient内部转发,前段转发proxy
            请求了两次,效率低,就不能存在跨域问题
            安全，抓包分析不到
        4.添加header请求允许访问
            String userName = request.getParameter("userName");
            JSONObject jsonObject = new JSONObject();
            jsonObject.put("userName", userName);
            response.getWriter().println(jsonObject.toJSONString());
            //允许浏览器跨域
            response.setHeader("Access-Control-Allow-Origin", "*");

# 表单重复提交和防止模拟Http请求
    网络延迟,刷新,点击后退,回退----解决办法使用token令牌
        uuid创建token
        将token放入到session中,在分布式场景中最好是存放到redis里面
        表单隐藏域中存放
        提交时进行验证 
    如何防止模拟Http请求
        使用令牌--好处唯一性 只能有一次请求
        web安全知识点:使用令牌解决模拟请求
        我现在把这个token的生存方式知道,还是能被模拟的,怎么解决？
            这个时候使用验证码去当着别人的请求
            因为模拟请求识别验证码是非常难得
            token+验证码

# XSS攻击
    SQL注入
    XSS攻击 脚本注入
    CSRF(模拟请求) 开多线程给一个系统注册,一下子你的网站就数据满了 token+验证码解决

    XSS提交(Web前段提交) (注入跳转的js脚本 钓鱼网站)
        向表单提交js代码 执行脚本 脚本注入
        转义方式
    解决办法
        写一个过滤器 拦截所有请求后
        重写获取值的方法,将特定字符转成html
        StringEscapeUtils.escapeHtml4(value)
    DOS---压力测试 把你的网站流量耗尽,你的网站就很卡
        CC攻击是DDOS（分布式拒绝服务）的一种

## mysql的优化
    小说明
        读写分离--MyChar
        分组having
        存储过程，触发器，函数
        
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