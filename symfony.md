```
```
 composer create-project symfony/framework-standard-edition my_project_name "2.8.*"
 php app/console server:run
 
 symfony安装程序检查系统是否准备好运行symfony应用程序。
 但是，命令控制台的PHP配置可能与PHP Web配置不同。
 因此，symfony提供了一个可视化配置检查器。访问以下URL以检查您的配置并在继续之前修复任何问题：
    http://localhost:8000/config.php
 
 symfony提供一个命令来检查项目的依赖项是否包含任何已知的安全漏洞：
    php app/console security:check
    
 service文档
    https://symfony.com/doc/2.8/service_container.html
    默认的parameters
        array(
            'kernel.root_dir' => realpath($this->rootDir) ?: $this->rootDir,
            'kernel.environment' => $this->environment,
            'kernel.debug' => $this->debug,
            'kernel.name' => $this->name,
            'kernel.cache_dir' => realpath($this->getCacheDir()) ?: $this->getCacheDir(),
            'kernel.logs_dir' => realpath($this->getLogDir()) ?: $this->getLogDir(),
            'kernel.bundles' => $bundles,
            'kernel.bundles_metadata' => $bundlesMetadata,
            'kernel.charset' => $this->getCharset(),
            'kernel.container_class' => $this->getContainerClass(),
        ),
    
    php app/console debug:container
    
 
 bundle文档
    https://symfony.com/doc/2.8/bundles.html
    php app/console generate:bundle
 
 database文档
    http://www.symfonychina.com/doc/current/doctrine.html
    https://github.com/davedevelopment/phpmig
    
    php app/console doctrine:database:create
    
    bin\phpmig init
    
    bin\phpmig migrate
    
    vendor/bin/phpmig generate YourClassName
 
 command文档
    php app/console generate:command
    
 Event Listener文档
 
    事件表  https://symfony.com/doc/2.8/reference/events.html
    Name	                KernelEventsConstant	Argument passed to the listener
    
    kernel.request	        KernelEvents::REQUEST	        GetResponseEvent
        说明:在确定控制器之前，在Symfony中很早就会发送此事件。向请求添加信息或提前返回响应以停止处理请求非常有用
    kernel.controller	    KernelEvents::CONTROLLER	    FilterControllerEvent
        说明:在控制器被执行之前，初始化一些东西，或改变控制器。
    kernel.view	            KernelEvents::VIEW	            GetResponseForControllerResultEvent
        说明:在执行控制器之后调度此事件，但仅在控制器未返回Response对象时调度。将返回值（例如带有一些HTML内容的字符串）转换为Symfony所需的Response对象非常有用：
    kernel.response	        KernelEvents::RESPONSE	        FilterResponseEvent
        说明:在控制器或任何kernel.view侦听器返回Response对象之后调度此事件。在发送回复之前修改或替换响应很有用（例如，添加/修改HTTP标头，添加cookie等）：
    kernel.finish_request	KernelEvents::FINISH_REQUEST	FinishRequestEvent
        说明:子请求完成后将调度此事件。重置应用程序的全局状态很有用（例如，翻译器侦听器将翻译器的语言环境重置为父请求之一）：
    kernel.terminate	    KernelEvents::TERMINATE	        PostResponseEvent
        说明:在发送响应之后（在执行handle（）方法之后）调度此事件。执行缓慢或复杂的任务非常有用，这些任务不需要完成即可发送响应（例如发送电子邮件）。
    kernel.exception	    KernelEvents::EXCEPTION	        GetResponseForExceptionEvent
        说明:若任何一个时间点抛出异常，则kernel.exception事件被触发
        
        每个事件都是KernelEvent的子类
            getRequestType（）
                返回请求的类型（HttpKernelInterface :: MASTER_REQUEST或HttpKernelInterface :: SUB_REQUEST）。
            getKernel（）返回处理请求的内核。
            Request（）返回正在处理的当前请求
    
    
    https://symfony.com/doc/2.8/components/event_dispatcher.html
        使用Symfony Framework时，kernel.exception有两个主要的监听器。
            ExceptionListener in HttpKernel
             1.抛出的异常将转换为FlattenException对象，该对象包含有关请求的所有信息，但可以打印和序列化
             2.如果原始异常实现HttpExceptionInterface，则在异常上调用getStatusCode（）和getHeaders（）并用于填充FlattenException对象的头和状态代码。
                 这个想法是在创建最终响应时在下一步中使用它们。
             3.执行控制器并传递展平的异常。要呈现的确切控制器作为构造函数参数传递给此侦听器。此控制器将返回此错误页面的最终响应。
            ExceptionListener in Security
             此侦听器的目标是处理安全性异常，并在适当时帮助用户进行身份验证（例如，重定向到登录页面）。
             
    
    https://symfony.com/doc/2.8/event_dispatcher.html Events and Event Listeners create register     
        注册 例如
            api.listener.access_token_validate_listener:
                class: ApiBundle\Listener\AccessTokenValidateListener
                arguments:    ['@service_container']
                tags:
                    - { name: kernel.event_listener, event: kernel.request, method: onKernelRequest, priority:255 }
            name 固定写法 
                kernel.event_listener   监听
                    监听器更灵活，因为bundle可以根据某些配置值有条件地启用或禁用每个监听器。
                kernel.event_subscriber 订阅监听
                    订阅者更容易重用，因为事件的知识保存在类中而不是服务定义中。这就是为什么Symfony在内部使用订户的原因;
                
            event 依赖的事件名字就是上表的Name
            method 监听器调用的方法 一般是on+驼峰 其中 Name = kernel.exception 默认的方法是onKernelException（）
            priority 事件的优先级  -255到255之间
    
    symfony 过滤器案例 面向AOP编程
        https://symfony.com/doc/2.8/event_dispatcher/before_after_filters.html     
 kernel文档
     const VERSION = '2.8.42';
     const VERSION_ID = 20842;
     const MAJOR_VERSION = 2;
     const MINOR_VERSION = 8;
     const RELEASE_VERSION = 42;
     const EXTRA_VERSION = '';
     const END_OF_MAINTENANCE = '11/2018';
     const END_OF_LIFE = '11/2019';
 	
 	HttpKernel
 	KernelInterface
 		registerBundles()	  返回一个数组 注册Bundles
 		registerContainerConfiguration(LoaderInterface $loader) 加载容器配置
 		boot()		引导当前内核
 		shutdown()	关闭内核，该方法主要用于功能测试。
 		getBundles()	获取注册的bundle实例
 		isClassInActiveBundle() 检查给定的类名是否属于活动bundle
 		getBundle()	根据名称返回一个bundle，并可选地 返回其子类
 		locateResource 	返回给定资源的文件路径
 		getName		获取内核的名称
 		getEnvironment	获取环境
 		isDebug		检查是否启用了调试模式
 		getRootDir	获取应用程序根目录
 		getContainer	获取当前容器
 		getStartTime	获取请求开始时间（如果禁用调试，则不可用）
 		getCacheDir	获取缓存目录
 		getLogDir	获取日志目录
 		getCharse	获取应用程序的字符集
 		handle                     处理将其转换为响应的请求 
 
 	TerminableInterface
 		terminate 终止 请求/响应 周期
```
```
