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
    