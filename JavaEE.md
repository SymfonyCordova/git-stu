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
        sql注入:sql拼接
        解决用预编译,??传参
    XSS攻击 脚本注入
    CSRF(模拟请求) 开多线程给一个系统注册,一下子你的网站就数据满了(机器模拟) token+验证码解决

    XSS提交(Web前段提交) (注入跳转的js脚本 钓鱼网站)
        过滤请求
        向表单提交js代码 执行脚本 脚本注入
        转义方式 转成html语义
    解决办法
        写一个过滤器 拦截所有请求后
        重写获取值的方法,将特定字符转成html
        StringEscapeUtils.escapeHtml4(value)
    DOS---压力测试 把你的网站流量耗尽,你的网站就很卡
        CC攻击是DDOS（分布式拒绝服务）的一种

# mybatis
    mybatis与hibernate区别？
    mybatis是以sql语句得到对象
    hibernate是通过对象得到sql语句
    sql注入:sql拼接
    解决用预编译,??传参
    mybatis的#与$区别？
        #{}可以防止sql注入
        ${}不能防止sql注入
    Generator逆向生成sql语句,映射文件,代码生成器

# spring 
    Spring是什么
        是一个容器,管理每个bean(对象)与bean(对象)之前的关系
        使用spring进行管理
    Spring的IOC
        没有spring的时候是三层架构
            dao service web
            new UserDao()
            new UserService()
        会发现老是自己new,spring容器把所有的对象管理起来
        就不需要自己老是去new
        spring的好处:节藕,单例(节省内存,弊端线程可能不安全)
        任何对象初始化过程,全部都要交给spring管理
        以前自己new对象叫正转,交给spring控制那就是反转
        IOC的实现原理就是反射---创建对象+解析xml
        DI依赖注入--解决对象之间的关系
    spring包
        <dependency>
            <groupId>org.springframework</groupId>
            <artifactId>spring-core</artifactId>
            <version>3.0.6.RELEASE</version>
        </dependency>
        <dependency>
            <groupId>org.springframework</groupId>
            <artifactId>spring-context</artifactId>
            <version>3.0.6.RELEASE</version>
        </dependency>
        <dependency>
            <groupId>org.springframework</groupId>
            <artifactId>spring-aop</artifactId>
            <version>3.0.6.RELEASE</version>
        </dependency>
        <dependency>
            <groupId>org.springframework</groupId>
            <artifactId>spring-orm</artifactId>
            <version>3.0.6.RELEASE</version>
        </dependency>
        <dependency>
            <groupId>org.aspectj</groupId>
            <artifactId>aspectjrt</artifactId>
            <version>1.6.1</version>
        </dependency>
        <dependency>
            <groupId>aspectj</groupId>
            <artifactId>aspectjweaver</artifactId>
            <version>1.5.3</version>
        </dependency>
        <dependency>
            <groupId>cglib</groupId>
            <artifactId>cglib</artifactId>
            <version>2.1_2</version>
        </dependency>
    spring配置文件
        <?xml version="1.0" encoding="UTF-8"?>
        <beans xmlns="http://www.springframework.org/schema/beans"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xmlns:p="http://www.springframework.org/schema/p"
            xmlns:context="http://www.springframework.org/schema/context"
            xmlns:aop="http://www.springframework.org/schema/aop"
            xsi:schemaLocation="
                http://www.springframework.org/schema/beans
                http://www.springframework.org/schema/beans/spring-beans.xsd
                http://www.springframework.org/schema/context
                http://www.springframework.org/schema/context/spring-context.xsd
                http://www.springframework.org/schema/aop
                http://www.springframework.org/schema/aop/spring-aop.xsd">
            <bean id="user" class="com.zler.domain.User"></bean>
        </beans>
    spring的bean id不能重复,不然报错
    spring的作用域
        对象单例 jvm只能运行一次
        对象多例 每次运行都会创建一次
        request 请求作用域
        session 对象和session绑定管理
    spring对象默认是单例的
        <bean id="user" class="com.zler.domain.User" scope="singleton"></bean>
        无参构造函数---反射来观察对象是否是单例
        单例注意的事项
            线程安全
            spring使用的是饿汉式单例保证线程安全
    spring设置bean为多例
        scope="prototype"
        <bean id="user" class="com.zler.domain.User" scope="prototype"></bean>
    spring注入的方式
        默认创建对象走无参构造方法
        有参构造函数
    spring使用注解的方式
        首先在spring.xml中定义扫包的地方
            <?xml version="1.0" encoding="UTF-8"?>
            <beans xmlns="http://www.springframework.org/schema/beans"
                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xmlns:p="http://www.springframework.org/schema/p"
                xmlns:context="http://www.springframework.org/schema/context"
                xmlns:aop="http://www.springframework.org/schema/aop"
                xsi:schemaLocation="
                    http://www.springframework.org/schema/beans
                    http://www.springframework.org/schema/beans/spring-beans.xsd
                    http://www.springframework.org/schema/context
                    http://www.springframework.org/schema/context/spring-context.xsd
                    http://www.springframework.org/schema/aop
                    http://www.springframework.org/schema/aop/spring-aop.xsd">>
                    <!--扫包范围-->
                    <context:component-scan base-package="com.zler"></context:component-scan>
            </beans>
        @Component 指定把一个对象加入IOC容器
        @Repository(name="aa")-- 作用同@Component -- dao  
        @Service(name="bb")-- 作用同@Component -- service
        @Autowired和@Resource(name="cc")的区别
            @Autowired和@Resource(name="cc")都是属性注入
            @Autowired默认是按照类型来注入的 是spring包下的
            @Resource是按照bean的id来的 是javax包下的
    springAop
        代理设计模式
        作用:提高对目标对象进行访问方式(中介)
        静态代理与动态代理区别?
            静态代理需要生成代理类
            动态代理不需要生成代理类
                JDK动态代理--发射机制
                cglib动态代理--字节码
        应用场景:权限控制,事物管理,日志打印,性能统计
        
        切面:其实就是重复代码
        Joinpoint连接点(看接口): 打开业务层接口里面的所有的方法 被增强和没被增强的方法是连接点
        Pointcut切入点: 被增强的方法是切入点 也就是说连接点包含切入点
        Advice通知: 要增加的代码(通知类) 
            前置通知 
            后置通知 
            异常通知 
            最终通知  
                try{  前置通知  切入点 后置通知 }catch{异常通知}finally{最终通知}
            环绕通知: 是全部代码 环绕通知中都有明确的切入点方法调用
        实现方式:xml方式和注解方式
            spring.xml中 <aop:aspectj-autoproxy /> 开启事物注解
            或者 如果连spring.xml都不想要的话 要写配置类中SpringConfiguration
                @Configuration 
                @ComponentScan("com.zler") 扫包
                @EnableAspectJAutoProxy 开启事物注解
            @Aspect
            @Pointcut("execution(* com.zler.service.impl.*.*(..))")
            @Before("pt1()") 前置通知
            @AfterReturning("pt1()") 后置通知 
            @AfterThrowing("pt1()") 异常通知
            @After("pt1()") 最终通知 
            @Around("pt1()") 环绕通知
    spring事物和spring事物传播行为
        手动事物(编成事物)
            原理:获取该数据原的api，数据源api中，会自动封装手动begin,commit,rollback
        声明事物(xml和注解) 
            不要在声明式事物中try要throw抛出去
            业务层不要try，在controller使用try
            AOP编成+环绕通知+异常通知
            ------+begin/commit+rollback
            xml:
                <?xml version="1.0" encoding="UTF-8"?>
                <beans xmlns="http://www.springframework.org/schema/beans"
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    xmlns:aop="http://www.springframework.org/schema/aop"
                    xmlns:context="http://www.springframework.org/schema/context" xmlns:tx="http://www.springframework.org/schema/tx"
                    xsi:schemaLocation="http://www.springframework.org/schema/beans
                                            http://www.springframework.org/schema/beans/spring-beans.xsd
                                            http://www.springframework.org/schema/aop
                                            http://www.springframework.org/schema/aop/spring-aop.xsd
                                            http://www.springframework.org/schema/context
                                            http://www.springframework.org/schema/context/spring-context.xsd
                                            http://www.springframework.org/schema/tx
                                            http://www.springframework.org/schema/tx/spring-tx.xsd">
                        <!--扫包-->
                        <context:component-scan base-package="com.zler"></context:component-scan>
                        <!--开启aop-->
                        <aop:aspectj-autoproxy></aop:aspectj-autoproxy>
                        <!--1.数据源对象:C3P0连接池-->
                        <bean id="dataSource" class="com.mchange.v2.c3p0.ComboPooledDataSource">
                            <property name="driverClass" value="com.mysql.jdbc.Driver"></property>
                            <property name="jdbcUrl" value="jdbc:mysql://172.17.0.2:3306/aa"></property>
                            <property name="user" value="root"></property>
                            <property name="password" value="root"></property>
                        </bean>
                        <!--2.JdbcTemplate工具类实例-->
                        <bean id="jdbcTemplate" class="org.springframework.jdbc.core.JdbcTemplate">
                            <property name="dataSource" ref="dataSource"></property>
                        </bean>
                        <!--3.配置事物-->
                        <bean id="dataSourceTransactionManager"
                            class="org.springframework.jdbc.datasource.DataSourceTransactionManager">
                            <property name="dataSource" ref="dataSource"></property>
                        </bean>
                        <!--配置声明式事物-->
                        <tx:advice id="txAdvice" transaction-manager="dataSourceTransactionManager">
                            <tx:attributes>
                                <tx:method name="*" propagation="REQUIRED" read-only="false"/>
                                <tx:method name="find*" propagation="SUPPORTS" read-only="true"/>
                            </tx:attributes>
                        </tx:advice>
                        <!--配置aop 要配的是:切入点表达式 通知和切入表达式的关联-->
                        <aop:config>
                            <!-- 配置切入点表达式 -->
                            <aop:pointcut expression="execution(* com.zler.service.impl.*.*(..))" id="pt1" />
                            <!-- 配置事务通知和切入点表达式的关联 -->
                            <aop:advisor advice-ref="txAdvice" pointcut-ref="pt1" />
                        </aop:config>
                </beans>
            注解:
                <?xml version="1.0" encoding="UTF-8"?>
                <beans xmlns="http://www.springframework.org/schema/beans"
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    xmlns:aop="http://www.springframework.org/schema/aop"
                    xmlns:context="http://www.springframework.org/schema/context" xmlns:tx="http://www.springframework.org/schema/tx"
                    xsi:schemaLocation="http://www.springframework.org/schema/beans
                                            http://www.springframework.org/schema/beans/spring-beans.xsd
                                            http://www.springframework.org/schema/aop
                                            http://www.springframework.org/schema/aop/spring-aop.xsd
                                            http://www.springframework.org/schema/context
                                            http://www.springframework.org/schema/context/spring-context.xsd
                                            http://www.springframework.org/schema/tx
                                            http://www.springframework.org/schema/tx/spring-tx.xsd">
                        <!--扫包-->
                        <context:component-scan base-package="com.zler"></context:component-scan>
                        <!--开启aop-->
                        <aop:aspectj-autoproxy></aop:aspectj-autoproxy>
                        <!--1.数据源对象:C3P0连接池-->
                        <bean id="dataSource" class="com.mchange.v2.c3p0.ComboPooledDataSource">
                            <property name="driverClass" value="com.mysql.jdbc.Driver"></property>
                            <property name="jdbcUrl" value="jdbc:mysql://172.17.0.2:3306/aa"></property>
                            <property name="user" value="root"></property>
                            <property name="password" value="root"></property>
                        </bean>
                        <!--2.JdbcTemplate工具类实例-->
                        <bean id="jdbcTemplate" class="org.springframework.jdbc.core.JdbcTemplate">
                            <property name="dataSource" ref="dataSource"></property>
                        </bean>
                        <!--3.配置事物-->
                        <bean id="dataSourceTransactionManager"
                            class="org.springframework.jdbc.datasource.DataSourceTransactionManager">
                            <property name="dataSource" ref="dataSource"></property>
                        </bean>
                        <!--开启注解事物-->
                        <tx:annotation-driven transaction-manager="dataSourceTransactionManager"/>
                </beans>
                在方法上直接使用 @Transactional 非常方便
        事物传播行为
            比如在service调用LogService(这个是插入到log表中)再调用UserService,其实日志是不需要回滚的
            如何保证有些回滚,有些不要回顾
            七种传播行为
            @Transactional(propagation = Propagation.REQUIRED)默认 使用当前事物
            @Transactional(propagation = Propagation.SUPPORTS)支持当前事物 如果没有当前事物则非事物执行
            @Transactional(propagation = Propagation.REQUIRES_NEW) 自己新建一个事物,当前事物挂起
            @Transactional(propagation = Propagation.MANDATORY)支持当前事物 如果没有当前事物则抛出异常
            @Transactional(propagation = Propagation.NOT_SUPPORTED)以非事物方式运行,如果有当前事物,当前事物挂起
            @Transactional(propagation = Propagation.NEVER)以非事物方式运行,如果有当前事物,则抛出异常
        spring最终使用JAVA配置
            @Configuration作用在类上---相当于xml配置文件
            @ComponentScan(basePackages="cn.zler")作用在类上
            @Bean作用方法上,相当于xml配置的<bean>
            AnnotationConfigApplicationContext context = new AnnotationConfigApplicationContext(被标记为配置文件的类.class)
            @PropertySource(value={"classpath:jdbc.properties"})指定读取配置文件，通过@Value注解获取值
    
# springBoot
    敏捷开放(已经帮我们整合框架了)
    无需tomcat(java应用程序运行,实际jar包),内置tomcat
    减少xml配置(没用xml)，配置文件properties
    注解
    SpringBoot与微服务有什么关联?
        SpringCloud基于SpringBoot(http接口+restful)，SpringBoot web组件封装了SpringMVC
    系统要求Java7以上，Spring 4.1.5以上
    面向服务架构(SOA)转变成微服务架构
    SpringData(操作持久层框架)和SpringMVC(控制层框架)
    SpringBoot安不安全？安全
    使用SpringBoot写第一个接口(服务)
    常用注解
        @ComponentScan("com.zler.controller")作用在类上 扫包
        @EnableAutoConfiguration作用在类上 开启spring注入容器
        @RestController作用在类上 表示该接口全部返回json格式
        @RequestMapping作用在方法上 定义路由
        只能有一个main
        public static void main(String[] args) {
            //主函数运行springboot项目
            SpringApplication.run(HelloController.class, args);
        }
        全局拦截异常 AOP的异常通知
            @ControllerAdvice作用在类上表示切面
            @ResponseBody作用在方法上表示返回json格式
            @ExceptionHandler(RuntimeException.class)作用在方法上表示拦截异常
        模板引擎 伪html格式,提高搜索引擎
            freemaker velocity

