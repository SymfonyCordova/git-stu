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


