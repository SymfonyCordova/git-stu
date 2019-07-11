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
            @Value作用在属性上,给类的属性赋值 值可以是字面量,也可以从配置文件获取 @value("${person.last-name}")

# spring注解驱动开发
    容器
        需要导入spring-context包
        @Configuration //告诉spring这是一个配置类
        @Bean("person") //给容器注册一个Bean;类型为放回值的类型,id默认是用方法名作为id
        @Component泛指组件，当组件不好归类的时候，我们可以使用这个注解进行标注。
        @Repository用于标注数据访问组件，即DAO组件。
        @Service用于标注业务层组件
        @Controller用于标注控制层组件
        @ComponentScan(value = "com.zler", excludeFilters = {
            Filter(type = FilterType.ANNOTATION,classes={Controller.class,Service.class})
        })
        @ComponentScan(value = "com.zler", excludeFilters = {
            Filter(type = FilterType.ANNOTATION,classes={Controller.class})}, 
            useDefaultFilters = false)
        //扫描包 value指定扫描包 excludeFilters排除哪些包 includeFilters指定扫描的时候只需要包含的哪些包
        //FilterType.ANNOTATION 按照注解的方式来扫描包
        //FilterType.ASSIGNABLE_TYPE 按照给定的类型来扫描包
        //FilterType.ASPECTJ 按照ASPECTJ来扫描包
        //FilterType.REGEX 按照正则表达式来扫描包
        //FilterType.CUSTOM 按照自定义规则来扫描包 需要实现TypeFilter接口
        @ComponentScans(
            value = {
                @ComponentScan(value = "com.zler", excludeFilters = {
                        @ComponentScan.Filter(type = FilterType.ANNOTATION,classes={Controller.class})
                }, useDefaultFilters = false)
            }
        )//扫描多个包
        @Scope用于设置bean的作用域
            prototype:多实例的  需要的时候每次获取的时候都会创建一个
            singleton:实例的(默认值) 随着容器的创建而创建
            request:同一个请求创建一个实体 (web环境下)
            session:同一个session创建一个实体 (web环境下)
        @Lazy(true) 表示延迟加载
            针对的是单例的bean
            单例bean默认在容器启动的时候创建对象 饿汉式
            懒加载:容器启动不创建对象。第一次使用(获取)Bean创建对象 懒汉式
        @Conditional({WindowsCondition.class}) 按照一定条件进行判断,满足条件给容器中注册bean
            条件类要实现Condition接口
            注册在类上统一设置条件注册bean
            注册在方法上,单一的设置条件注册bean
        @Import({Color.class, Red.class, CustomSelector.class, CustomImportBeanDefinitionRegistrar.class}) //导入组件,id默认是全类名 com.zler.domian.Color 场景就是需要导入第三方类的时候可以用 

    
        给容器中注册组件总结
            1.包括扫描+组件注解(@Controller/@Service/@Repository/@Component)
            2.@Bean[导入第三包里面的组件]
            3.@Import[快速给容器导入一个组件]
                1.@Import(要导入到容器的组件),容器就会自动注册这个组件,id默认是全类名
                2.ImportSelector:返回导入的组件的全类名数组(批量导入) 需要写一个类实现ImportSelector
                3.ImportBeanDefinitionRegistrar: 手动注册bean到容器 需要写一个类实现ImportBeanDefinitionRegistrar
            4.使用Spring提供的FactoryBean(工厂Bean): 需要写一个类实现FactoryBean 这个和第三方框架整合时,经常用到
                getBean("colorFactoryBean")获取的是工厂返回的对象bean
                getBean("&colorFactoryBean")获取的就是是工厂本身对象bean

    Bean的生命周期      
        容器管理bean的生命周期
            生命周期:bean创建--初始化---销毁的过程
            我们可以自定义初始化和销毁方法,容器在bean进行到当前生命周期的时候来调用我们自定义的初始化和销毁方法
        整个生命周期调用方法的流程
            构造方法(对象创建)
                单例:在容器启动的时候创建对象
                多例:在每次获取的时候创建对象
            BeanPostProcessor.postProcessBeforeInitialization
            初始化方法:
                对象创建完成,并赋值好,调用初始化方法
            BeanPostProcessor.postProcessAfterInitialization
            销毁方法
                单例:在容器关闭的时候
                多例:容器不会管理这个bean，容器不会调用销毁方法
        整个生命周期调用方法的流程的操作
            1.指定初始化和销毁方法
                通过@Bean指定init-method="" destory-method=""
            2.通过Bean实现InitializingBean接口(定义初始化逻辑) DisposableBean接口实现销毁逻辑
            3.可以使用JSR250
                @PostConstruct注解用于在bean创建完成并且属性赋值完成,来执行初始化方法（用在方法上）
                @PreDestory注解用于容器销毁bean之前通知我们进行清理工作（用在方法上）
            4.新建一个处理器实现 BeanPostProcessor,bean的后置处理器
                在bean初始化前后进行一些处理工作
                postProcessBeforeInitialization:在初始化之前工作
                postProcessAfterInitialization:在初始化之后工作
        BeanPostProcessor在Spring底层的使用
            bean赋值,注入其他组件,@Autowired,生命周期注解功能,@Async,...等都是XxxBeanPostProcessor的使用
            之后在学习的过程中只要对bean的一些注解,接口实现特殊功能，看看到底有没有对应的XxxBeanPostProcessor

    属性赋值
        @Value
            基本的数值
                @Value("战三")
                private String name;
            可以写SpEl表达式, #{}
                @Value("#{20-2}")
                private Integer age;
            可以 ${} 取出配置文件【properties】中的值(在运行环境变量里面的值) 可用@PropertySource配合
                @Value("${person.nickName}")
                private String nickName;
        @PropertySource读取外部配置文件的k/v保存到运行的环境变量中;加载完外部的配置文件以后使用${}取出配置文件的值
            spring容器有一个保存环境的组件,可取出来配置文件的配置信息
        自动装配
            自动装配：Spring利用依赖注入(DI)，完成对IOC容器中各组件的依赖关系赋值
            1.@Autowired【是Spring定义的】
                @Autowired 
                    1.默认按照类型去容器找对应的组件:applicationContext.getBean(UserDao.class)
                    2.如果找到多个相同类型的组件,再将属性的名称作为组件的id去容器中找
                    3.使用@Qualifier指定需要装配的在组件id，而不使用属性名
                    4.自动装配默认一定要将属性赋值好,没有就报错；
                        可以使用@Autowired(required=false)；不是必须要装配的
                    5.@Primary:让Spring进行自动装配的时候,默认使用首选的bean；
                        也可以继续使用@Qualifier指定需要装配的bean的名字
                @Qualifier 
                    @Autowired(required=false)默认是true
                    @Qualifier("personDao")
                    private UserDao dao
                @Primary
                    @Primary
                    @Bean("BookDao2")
            2.Spring还支持使用@Resource(JSR250)和@Inject(JSR330)【是java规范的注解】
                @Resource:默认是按照组件名称进行装配的；
                    没有支持@Primary功能和@Autowired(required=false)功能
                @Inject:
                    需要导入javax.inject包和@Autowired的功能一样,但是required=false
            3.@Autowired：构造器,参数,方法,属性;都是从容器中获取参数组件的值
                可以标记在方法位置上；
                    比如bean的setter方法上
                    @Bean+方法参数；参数从容器中获取；默认不写@Autowired效果都是一样的,都能自动装配
                可以标记在有参构造方法上,如果组件只有一个有参构造器,
                    这个有参构造器的@Autowired可以省略,参数位置的组件还是可以自动从容器中获取
                可以标记在方法的参数上
            4.自定义组件想要使用Spring容器底层的一些组件(ApplicationContext, BeanFactory,xxx...等)
                自定义组件实现XxxAware,在创建对象的时候,会自动调用接口规定的方法注入相关组件;
                把Spring底层一些组件注入到自定义的Bean中
                XxxAware:功能使用XxxProcessor后置处理器来实现的；
                    ApplicationContextAware==>ApplicationContextAwareProcessor
                还有 BeanNameAware，EmbeddedValueResolveWare,等等
            5.@Profile: 指定组件在哪个环境下才能被注册到容器中,不指定,任何环境下都能注册这个组件
                1.加了环境标识的bean，只有这个环境激活的时候才能注册到容器中。默认有一个default环境
                2.写在配置类上只有是指定的环境的时候,整个配置类里面的所有配置才能开始生效、
                3.没有标注环境标识的bean在,任何环境下都是加载的
                激活方式    
                    1.使用命令行动态参数激活 -Dspring-profiles.active=test
                    2.代码方式
                    //1.创建一个applicationContext
                    AnnotationConfigApplicationContext app = new AnnotationConfigApplicationContext();
                    //2.设置需要激活的环境
                    app.getEnvironment().setActiveProfiles("test", "dev");
                    //3.注册主配置类
                    app.register(CustomConfigProp.class);
                    //4.启动刷新容器
                    app.refresh();
                Spring为我们提供的可以根据当前环境,动态的激活和切换一系列组件的功能
                开发环境,测试环境,生存环境
                数据源:(/A)(/B)(/C)
                @Profile("test")
    AOP
        1.需要导入spring-aspects包
        2.将业务逻辑组件和切面类都加入容器,告诉Spring哪个是切面类@Aspect
        3.在切面类上的每一个通知方法上标注通知注解,告诉Spring何时何地的运行(切入点表达式)
        4.开启基于注解的aop模式 @EnableAspectJAutoProxy(配置类中加)，一般@Enable...都是开启什么配置的
            前置通知(@Before)
            后置通知(@AfterReturning)
            异常通知(@AfterThrowing)
            最终通知(@After)
            绕通知(@Around)
        例子:
            @Aspect //告诉spring这是一个切面类
            public class LogAspects {

                //抽取公共的切点表达式
                //1.本类引用
                //2.其他的切面引用
                @Pointcut("execution(  public int com.zler.aop.MathCalculator.*(..))")
                public void pointCut(){}

                @Before("pointCut()")
                public void logStart(JoinPoint joinPoint){
                    Object[] args = joinPoint.getArgs();
                    String name = joinPoint.getSignature().getName();
                    System.out.println(""+name+"运行...参数列表是:{"+ Arrays.asList(args)+"}");
                }

                @After("com.zler.aop.LogAspects.pointCut()")
                public void logEnd(JoinPoint joinPoint){
                    System.out.println(""+joinPoint.getSignature().getName()+"结束");
                }

                //JoinPoint joinPoint一定出现在参数表的第一位
                @AfterReturning(value = "pointCut()", returning = "result")
                public void logReturn(JoinPoint joinPoint, Object result){
                    System.out.println(""+joinPoint.getSignature().getName()+"正常返回...运行结果:{"+result+"}");
                }

                @AfterThrowing(value = "pointCut()", throwing = "exception")
                public void logException(JoinPoint joinPoint, Exception exception){
                    System.out.println(""+joinPoint.getSignature().getName()+"异常...异常信息:{"+exception+"}");
                }

            }
        Aop原理
            看给容器中注册了什么组件,这个组件什么时候工作,这个组件的功能是什么
            总结：
                1）、@EnableAspectJAutoProxy 开启AOP功能
                2）、@EnableAspectJAutoProxy 会给容器中注册一个组件 AnnotationAwareAspectJAutoProxyCreator
                3）、AnnotationAwareAspectJAutoProxyCreator是一个后置处理器；
                4）、容器的创建流程：
                    1）、registerBeanPostProcessors（）注册后置处理器；创建AnnotationAwareAspectJAutoProxyCreator对象
                    2）、finishBeanFactoryInitialization（）初始化剩下的单实例bean
                        1）、创建业务逻辑组件和切面组件
                        2）、AnnotationAwareAspectJAutoProxyCreator拦截组件的创建过程
                        3）、组件创建完之后，判断组件是否需要增强
                            是：切面的通知方法，包装成增强器（Advisor）;给业务逻辑组件创建一个代理对象（cglib）；
                5）、执行目标方法：
                    1）、代理对象执行目标方法
                    2）、CglibAopProxy.intercept()；
                        1）、得到目标方法的拦截器链（增强器包装成拦截器MethodInterceptor）
                        2）、利用拦截器的链式机制，依次进入每一个拦截器进行执行；
                        3）、效果：
                            正常执行：前置通知-》目标方法-》后置通知-》返回通知
                            出现异常：前置通知-》目标方法-》后置通知-》异常通知
    Spring声明式事物
        环境搭建
        1.导入相关依赖
            数据源,数据驱动,Spring-jdbc模块
        2.配置数据源,JdbcTemplate(Spring提供简化数据库操作的工具)操作数据
        3.给方法上标注@Transactional 表示当前方法是一个事物方法
        4.@EnableTransactionManagement 开启基于注解的事物管理功能
        5.配置事物管理器来管理事物
            @Bean
            public PlatformTransactionManager transactionManager()
        原理
            1.@EnableTransactionManagement
                利用TransactionManagementConfigurationSelector给容器导入组件
                导入两个组件
                    AutoProxyRegistrar，ProxyTransactionManagementConfiguration
    扩展原理
        BeanPostProcessor:bean的后置处理器,bean创建对象初始化前后进行拦截工作
        1.BeanFactoryPostProcessor:beanFactory的后置处理器
            在BeanFactory标准初始化之后调用,所有的bean定义已经保存加载到beanFactory，但是bean的实例还没创建
        2.BeanDefinitionRegistryPostProcessor extends BeanFactoryPostProcessor
            postProcessBeanDefinitionRegistry()；
            在所有bean定义信息将要被加载,bean实例还未创建的时候,进行执行
            
            优先于BeanFactoryPostProcessor执行,
            利用BeanDefinitionRegistryPostProcessor给容器中再额外添加一些组件
        3.ApplicationListener:监听容器发布的事件.事件驱动模型开发
            public interface ApplicationListener<E extends ApplicationEvent> extends EventListener
                监听ApplicationEvent及其下面的子事件:
            自己发布事件步骤:
                1.写一个监听器(ApplicationListener实现类)监听某个事件(ApplicationEvent及其子类)
                    还有可以使用@EventListener来实现监听,这样比实现接口方便点
                2.把监听器加入到容器
                3.只要容器有相关事件的发布,我们就能监听到这个事件
                    ContextRefreshedEvent：容器刷新完成(所有bean都完全创建)会发布事件
                    ContextClosedEvent：关闭容器会发布这个事件
                4.发布一个自己的一个事件:
                    applicationContext.publishEvent(new ApplicationEvent(new String("我发布的事件")) {
                    });
            原理
                spring可以自定义监听器也可以自定义设置派发器
                比如之后的同步派发器和异步派法器

    web
        1.servlet3.0之后可以使用注解来配置servlet filter listener三大组件
            需要tomcat7.0以上版本
            @WebServlet("/hello")
            @WebFilter
            @WebListener
            @WebInitParam 初始化一些参数
        2.Shared libraries（共享库） / runtimes pluggability（运行时插件能力）
            1、Servlet容器启动会扫描，当前应用里面每一个jar包的
                ServletContainerInitializer的实现
            2、提供ServletContainerInitializer的实现类；
                必须绑定在，META-INF/services/javax.servlet.ServletContainerInitializer
                文件的内容就是ServletContainerInitializer实现类的全类名；

            总结：容器在启动应用的时候，会扫描当前应用每一个jar包里面
            META-INF/services/javax.servlet.ServletContainerInitializer
            指定的实现类，启动并运行这个实现类的方法；传入感兴趣的类型；

            ServletContainerInitializer；
            @HandlesTypes；

# springmvc常用的组件
    @RequestMapping("/queryItems")对queryItems方法和url进行映射，一个方法对应一个url
    @RequestParam

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
    在实际项目中,怎么搭建多数据源 区分数据
        1.分包结构方式
            分布式事物解决方案jta+automatic传统项目
        2.使用注解方式
            自定义注解
    常用注解
        @ComponentScan("com.zler.controller")作用在类上 扫包
        @EnableAutoConfiguration作用在类上 开启spring注入容器
        @RestController作用在类上 表示该接口全部返回json格式
        @RequestMapping作用在类上同一个根路径，作用在方法上定义子路径
        @ConfigurationProperties(prefix = "person")作用在类上,从配置文件注入到bean里面，给对象的属性赋值 
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
        @MapperScan 整合Mybatis扫描mapper包
        @SpringBootApplication=@Configuration+@ComponentScan+@EnableAutoConfiguration
    配置多数据源
    分布式事物 jta+automatic 传统项目 配置好了就不需要@Transactional
    使用AOP统一管理web请求日志
    任务调度

# 高并发解决方案
    数据库
        1.慢查询定位sql语句
        2.sql语句优化
        3.减少全表扫描
        4.使用索引(注意索引事项)
        5.分库分表(水平+垂直分割)
        6.水平 取模算法
        7.主从复制(mysql集群)二进制日志文件
        8.读写分离(mycat)
    缓存机制
        1.redis开启持久化,缓存数据库内容
        2.redis集群(主从复制)
        3.redis读写分离
        4.使用redis哨兵机制监听
    服务器
        反向代理,配置负载均衡,集群，CDN加速(买CDN加速服务器，按地区服务器，较少带宽)
        nginx防止ddos攻击,csrf攻击
    客户端
        减少请求,用户体验好,使用ajax,动态分离,
    项目重构
        Jvm调优，垃圾回收机制，老年代，新生代(回收新生代),配置jvm参数配置
        采用微服务架构和分布式架构
    
# 消息中间件
    activemq
    生产者(web服务)-》队列(消息中间件)-》消费者
    客户端与服务器段进行异步通讯
    通讯方式:
        点对点 只有一个服务端对应一个客户端
        发布订阅 一个服务器可以有多个客户端
    本身是一个队列,mq本身能解决高并发能力
    使用消息中间件设置为持久化,保证消息不会少掉,非常重要
    activemq JMS可靠消息
        自动签收
            消费者自动立马消费这种模式不好,没有事物机制,补偿机制，代码发生异常就有问题的
        事物签收
            生产者只有提交了才能向消息中间件队列中放入消息
            消费者手动提交，才真正的告诉中间件队列我已经消费了,否则中间件还保留这消息，默认自动重试机制
        手动签收 
            消费者手动消费，才真正的告诉中间件队列我已经消费了,否则中间件还保留这消息
    使用MQ注意事项
        A.消费者,获取到消息之后,抛出jdbc连接异常，调用第三方接口,接口暂时无法访问?
        B.消费者,获取到消息之后,抛出数据转换异常? 必须要发布版本才能解决
        A需要重试 B不需要重试
        activemq 如果消费端抛出异常，默认自动重试
        总结: 如果消费者抛出异常,默认会自动重试
        注意事项:如果消费者代码需要发布版本进行解决的问题,不需要重试。采用记录日志+定时job健康检查+人工补偿
    消息中间件怎么保证幂等性问题
        消费者没有及时签收的情况下,MQ自动重试机制,造成重复消费的问题
            比如调用别人接口,耗时时间长,网络延迟的情况
        解决MQ幂等性问题,使用全局ID，进行区分消息。
            全局ID--可以是消息jmsMessageID的ID，业务逻辑的ID
    消费者集群不需要考虑幂等性问题,如果mq集群,就需要幂等性问题
    
    rocketmq
    mq支持消息堆积,重试机制,持久化,顺序消息,事物消息--支持分布式事物,拉去机制
    Rocketmq分布式消息中间件,集群,效率非常高。
    Activemq点对点通讯,发布订阅,本身支持集群,不支持分布式。
    MQ中发生消息堆积,消费者会宕机掉吗?不会,因为MQ缓存消息机制
    NameServer 存放生产者,消费者投递信息
    Broker 消息缓存机制 存放消息
    Producer 生产者
    Consumer 消费者
    rocketmq安装
        1.必须要有jdk环境,jdk必须要64位,1.7以上
        2.配置jvm参数
            jps查看当前运行的java程序

# 定时调度任务
    1.什么是任务调度--定时JOB 在什么时间进行执行代码任务
        任务调度场景: A系统每天注册新用户1000人,注册用户信息,登陆信息,定时发送给到我邮箱 21:00
        同步job，调度失败之后补偿机制 日志+定时JOB 分布式事物解决方案
    2.java实现定时任务有几种?
        Thread
        TimeTask
        线程池,可定时线程
        quartz定时任务调度框架
        Springboot内置定时任务调度
    3.集群情况下,实现定时JOB会产生什么原因?分布式JOB怎么解决幂等性问题
      思考:分布式Job如何解决幂等性问题
      1.使用分布式锁(zk,redis)保证只有一台服务器执行job
      2.使用配置文件 配置文件开关 加一个配置 start=true或者start=false，如果为false不执行job
      3.使用数据库唯一标识 缺点 效率低。
        传统任务调度 缺点:1.没有补偿机制2.不支持集群3.不支持路由策略4.统计5.管理平台6.报警邮箱,状态监控
    4.分布式任务调度平台
        任何job先在任务调度平台执行,再由任务调度平台路由到实际job服务器
        xxl-job



    
