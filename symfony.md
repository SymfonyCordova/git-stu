```
bundle
	1.bundle类似于其他软件中的插件
		symfony中的一切都是bundle,包括核心框架,应用的编写
		bundle就是一组结构化的文件
	
	2.创建bundle 
		创建命令: php app/console generate:bundle
			你可以创建一个blogbundle,forumbundle
	3.bundle的目录结构
		XxxxBundle.php
			作用: 将普通目录转换为symfony包的类
		Command/
			存放控制台程序
		Controller/
			存放控制器的代码
		DependencyInjection/
			symfony services的依赖注入
			保留某些依赖项注入扩展类，这些类可以导入服务配置、注册编译器过程或更多
		EventListener/
			存放程序监听器程序
		Resources/ 资源文件目录
			doc/
				index.rst bundle的根目录
			validation/
				验证程序
			serialization/
			translations/
			config/ 配置信息目录 比如路由配置routing.yml services.yml
			views/  视图存放目录
			public/
				css js images
				assets:install-console将一些静态资源连接到web/目录下
				解释: 一些资产是通过拷贝安装的。如果对这些资产进行更改，则必须再次运行此命令。
		Tests/
			测试
	4.将bundle注册到symfony框架中
		在symfony框架目录的app/AppKernel.php中registerBundles的方法里面
			加入你创建的bundle 例如 new AppBundle\AppBundle()
		注册完成后,bundle可以在任何地方使用,只要它是可以自动加载的 （通过在app/autoload.php中配置的自动加载程序）
	
	5.bundle也是一个命令空间
		Namespace				Bundle Class Name
		Acme\Bundle\BlogBundle		AcmeBlogBundle
		Acme\BlogBundle				AcmeBlogBundle
		如果你想共享自己写的bundle必须加上你的包的类名作为存储库的名称 例如 AcmeBlogBundle
		symfony自己的bundle不需要加前面的symfony 例如 FrameworkBundle
		
		每个bundle都有一个别名，它是使用下划线的bundle名称的小写
			例如: AcmeBlogBundle的别名是acme_blog  此别名用于强制项目内的唯一性，并用于定义包的配置选项
	
	6.如何给bundle加载配置外部文件和外部服务
		获取外部配置文件内容:
			参考: https://symfony.com/doc/2.8/bundles/configuration.html
			在DependencyInjection中创建Configuration.phpp配置文件
				继承Symfony\Component\Config\Definition\ConfigurationInterface接口
				并使用Symfony\Component\Config\Definition\Builder\TreeBuilder
		获取外部的服务
			参考: https://symfony.com/doc/2.8/bundles/extension.html
			在DependencyInjection中创建XxxExtension.php配置文件
				继承 Symfony\Component\DependencyInjection\Extension\Extension;
				实现load方法
					例如: 从yaml加载服务
					$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
					$loader->load('services.yml');

symfony的依赖注入
	主要讲解yaml配置
	1.设置参数
		parameters:
			mailer.transport: sendmail
		在代码中获取,设置,判断 parameter
			$container->hasParameter('mailer.transport');
			$container->getParameter('mailer.transport');
			$container->setParameter('mailer.transport', 'sendmail');
	2.构造方法注入
		services：
			mailer：
				class: AppBundle\Biz\Mailer
				arguments: ['%mailer.transpor%','%@request%']
		说明:带@是已经注入symfony容器里面的类键名
			不带@是引用前面定义的
			还有就是我就想注入的字符串是@xxx
				那么使用@@xxx
			如果是%xxx
				那么使用%%xxx
	3.类的方法注入 比如: set或add或其他
		sevices:
			newsletter_manager；
				class: App\Biz\Mailer
				calls: 
					- [setMailer, ['@mailer']]
	4.自动注入
		本质还是构造方法 并且需要在配置文件中配置
		参考: https://symfony.com/doc/current/service_container/autowiring.html
	5.其他注入
		https://symfony.com/doc/current/service_container/factories.html
		https://symfony.com/doc/current/service_container/alias_private.html
		比如如何从工厂方法注入服务
		如何给服务设定一个私有或者共有的访问权限
		如何导包
			imports:
				- { resource: services/mailer.yaml }
	6.编译扩展服务
		DependencyInjection/Compiler下面
			创建XxxPass.php(名字可以自定)类 继承 Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface接口
			实现 process方法 在process方法中的参数是容器
				获取已经存在的bean,因为这只是一个编译过程,而不是获取对象实例 所以不能使用容器的get,set方法 而是使用容器的定义方法如:
						findDefinition()
						setDefinition()
						findTaggedServiceIds
					如何使用服务定义对象
						has()
						hasDefinition()
						getDefinition()
						findDefinition()
						findTaggedServiceIds()
						setDefinition()
						register()
						
		使用tags标签方式注册服务器集合
			1.定义标签类和注册为服务
				定义标签类
					namespace AppBundle\Mail;
					class TransportChain
					{
						private $transports;

						public function __construct()
						{
							$this->transports = array();
						}

						public function addTransport(\Swift_Transport $transport)
						{
							$this->transports[] = $transport;
						}
					}
				将标签定义为服务
					services:
						app.mailer_transport_chain:
							class: AppBundle\Mail\TransportChain
				
			2.定义多个带同样的标签(app.mail_transport)的集合
				目的是为了使用addXxx方法将其添加到标签服务中去
				services:
					app.smtp_transport:
						class: \Swift_SmtpTransport
						arguments: ['%mailer_host%']
						tags:
							- { name: app.mail_transport }

					app.sendmail_transport:
						class: \Swift_SendmailTransport
						tags:
							- { name: app.mail_transport }
							
			3.在DependencyInjection\Compiler中创建MailTransportPass 
				class MailTransportPass implements CompilerPassInterface
				{
					public function process(ContainerBuilder $container)
					{
						// 检查
						if (!$container->has('app.mailer_transport_chain')) {
							return;
						}
						$definition = $container->findDefinition('app.mailer_transport_chain');
						// 获取打上app.mail_transport标签的服务集合
						$taggedServices = $container->findTaggedServiceIds('app.mail_transport');
						//遍历集合
						foreach ($taggedServices as $id => $tags) {
							//调用之前的TransportChain类的add方法将集合注册进去
							$definition->addMethodCall('addTransport', array(new Reference($id)));
						}
					}
				}
			4.将MailTransportPass注册到容器中
				在AppBundle类中进行注册
					class AppBundle extends Bundle
					{
						public function build(ContainerBuilder $container)
						{
							$container->addCompilerPass(new MailTransportPass());
						}
					}
			5.在标记上添加附加属性
				class TransportChain
				{
					private $transports;

					public function __construct()
					{
						$this->transports = array();
					}

					public function addTransport(\Swift_Transport $transport, $alias)
					{
						$this->transports[$alias] = $transport;
					}

					public function getTransport($alias)
					{
						if (array_key_exists($alias, $this->transports)) {
							return $this->transports[$alias];
						}
					}
				}
				
				services:
					app.smtp_transport:
						class: \Swift_SmtpTransport
						arguments: ['%mailer_host%']
						tags:
							- { name: app.mail_transport, alias: foo }

					app.sendmail_transport:
						class: \Swift_SendmailTransport
						tags:
							- { name: app.mail_transport, alias: bar }
				
				class TransportCompilerPass implements CompilerPassInterface
				{
					public function process(ContainerBuilder $container)
					{
						if (!$container->hasDefinition('app.mailer_transport_chain')) {
							return;
						}

						$definition = $container->getDefinition('app.mailer_transport_chain');
						$taggedServices = $container->findTaggedServiceIds('app.mail_transport');

						foreach ($taggedServices as $id => $tags) {
							foreach ($tags as $attributes) {
								$definition->addMethodCall('addTransport', array(
									new Reference($id),
									$attributes["alias"]
								));
							}
						}
					}
				}
	详情参考:https://symfony.com/doc/current/components/dependency_injection.html

事件,订阅,派遣器
	1.EventDispatcher组件使用
		EventDispatcher组件提供了一些工具，允许您的应用程序组件通过调度事件和监听事件来相互通信。
		
		如何给类添加方法:
			使用继承
			使用动态代理
			使用装饰器模式
			而symfony eventdispatcher 实现了中介模式和观察者模式
		
		Aop给类的对象方法之前和方法之后添加方法
		
		事件
			当一个事件被派遣时，它有一个唯一的事件名被用于识别（比如kernel.response），该事件可以被不计数量的监听器来监听。
			同时一个Event实例将被同时创建，并被传递给所有的监听器。Event对象自身往往包含着被派遣事件的数据。
			
		命名约定
			事件名是唯一的,可以是任何字符串
				仅使用小写字母,数字, 点(.)或下划线(_)
				在名称前缀中使用以"点"进行分割的命名空间 
					例如(order.*.user.*)
				名称末尾使用一个动词,以指出何种动作被执行
					例如(order.*.user.update)
		事件名称和事件对象 
			当派遣器通知监听器时，它把一个真正的Event对象传入那些监听器中。
		
		
		1.监听器
			use Symfony\Component\EventDispatcher\Event;
			class UserUpdateListener
			{
				public function onUserUpdateAction(Event $even)
				{
				}
			}
		
		2.派遣器
			use Symfony\Component\EventDispatcher\EventDispatcher;
			$dispatcher = new EventDispatcher();
		
		3.将监听器注册到派遣器上
			$listener = new UserUpdateListener();
			$dispatcher->addListener('user.update', array($listener, 'onUserUpdateAction'), -200);
				参数1: 字符串类型 此侦听器要侦听的事件名称
				参数2: 将在派遣器执行事件时执行的方法
				参数3：可选优先级，定义为正整数或负整数（默认为0）。数字越高，调用侦听器的时间越早。如果两个监听器具有相同的优先级，那么它们将按添加到调度程序的顺序执行。
		
			一旦监听被注册到派遣器，它就等待着事件被通知
				
		4.创建一个Event并派遣Event
			class UserUpdateEvent extends Event
			{
				const NAME = 'user.update'
				protected $user;
				
				public function __construct(User user)
				{
					$this->user = $user;
				}
				
				public function getUser()
				{
					return $this->user;
				}
			}
			
			$user = new User();
			$event = new UserUpdateEvent($user);
			//只要调用dispatch,所有监听user.update的监听器都将调用自己onUserUpdateAction方法
			$dispatcher->dispatch(UserUpdateEvent::NAME, $event);
			
			******为了灵活的传参数可以继承GenericEvent 可以传入很多参数给自己使用很方便 Biz Framework 的Event就继承GenericEvent ****
				GenericEventd继承symfony的Event
					有Event的所有方法
					__construct() 构造器可以接收事件主题和任何参数
　　　　			getSubject() 获取任意传入的对象(event对象)
　　　　			setArgument() 通过键设置一个参数
　　　　			setArguments() 设置一个参数数组
　　　　			getArgument() 通过键获取一个参数值
　　　　			getArguments() 获取所有参数值
　　　　			hasArgument() 如果某个键值存在，则返回true。
		
		=============================================================================
		
		5.事件订阅器
			1.实现EventSubscriberInterface方法
			class UserEventSubscriber implements EventSubscriberInterface
			{
				public static function getSubscribedEvents()
				{
					return array(
						KernelEvents::RESPONSE => array(
							array('onKernelResponsePre', 10),
							array('onKernelResponsePost', -10),
						),
						UserUpdateEvent::NAME => 'onUserUpdateAction',
					);
				}
			
			
				public function onKernelResponsePre(FilterResponseEvent $event)
				{
					// ...
				}
			 
				public function onKernelResponsePost(FilterResponseEvent $event)
				{
					// ...
				}
			 
				public function onUserUpdateAction(UserUpdateEvent $event)
				{
					// ...
				}
			}
			
			2.订阅器注册给派遣器
				$subscriber = new UserEventSubscriber();
				$dispatcher->addSubscriber($subscriber);
				
			3.派遣Event
				$user = new User();
				$event = new UserUpdateEvent($user);
				$dispatcher->dispatch('user.update', $event); 

				当kernel.response事件被触发时，方法onkernelresponsepre（）和onkernelresponsepost（）按该顺序被调用
		
		6.阻止事件流转和传递
			需求:一个监听者来阻止其它监听者被调用。
				监听者需要能告诉dispatcher来阻止将事件传递给后续的监听者。
				
			实现:这个可以在一个监听者内部通过stopPropagation()方法来实现。
				public function onUserUpdateAction(FilterOrderEvent $event)
				{
					// ...
					$event->stopPropagation();
				}
			
			通过isPropagationStopped()方法来判断一个事件被阻止
				$dispatcher->dispatch('user.update',$event);
				if($event->isPropagationStopped()){
					//...
				}
				
		7.派遣器总是注入一个它自己的引用传入到event对象
			所有的监听器可以通过派遣器传递给自己的Event对象的getDispatcher()方法直接获取派遣器对象
			
			public function onUserUpdateAction(FilterOrderEvent $event)
			{	
				//应用场景从一个监听者内部派遣另外的事件
				$event->getDispatcher()->dispatch('log',$event);
			}
			
		8.派遣器的简写使用方式
			由于派遣器调用dispatch方法返回的是它本身,所以可以链式调用
			$user = new User();
			$event = new UserUpdateEvent($user);
			$dispatch->dispatch('user.update', $event)->isPropagationStopped() //链式调用
		
		9.事件名称的内部自知
			所有的监听器可以通过派遣器传递给自己的Event对象的getDispatcher()方法直接获取派遣器对象
			派遣器早就知道事件的名称
			使用getName()方法来获取事件名称
			public function onUserUpdateAction(FilterOrderEvent $event)
			{	
				$event->getName()
			}
	2.symfony框架内部使用Event Listener
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

symfony-security
    文档 https://symfony.com/doc/2.8/security.html
    认证(你是谁)
    授权(你能干什么)
    攻击防护(防止伪造身份)
    
    symfony-security 过滤器链
        form_login 过滤器  处理表单的登陆的
            检查是否有用户名和密码的信息 如果有就尝试加密登陆不是就放行
        http basic 过滤器  处理http basic登陆的
            检查是否有用户名和密码的信息 如果有就尝试加密登陆不是就放行
        
        可以有多个过滤器 
        
        最终的FilterSecurity过滤器根据配置来判断是否过还是不过
        根据不符合的抛出异常
        
        根据这些过滤器来配置多种方式登陆(比如第三方登陆)
    
    1.认证
        symfony-security基本原理
            配置防火墙以及如何加载用户，到拒绝访问和获取User对象
        
            1.初始security.yml设置（认证）
            2.拒绝访问您的应用（授权）
            3.获取当前的User对象
            4.如注销和编码用户密码
        
        a.配置用户的身份验证方式
            防火墙的主要工作是配置用户的身份验证方式。他们会使用登录表吗？ HTTP基本认证(HTTP basic authentication)？ API令牌？上述所有的？   
                    firewalls:
                        main:
                            anonymous: ~
                            http_basic: ~ #这里配置身份验证方式是HTTP基本认证
            
            接下来，向security.yml添加一个access_control条目，该条目要求用户登录才能访问此URL：
                    firewalls:
                        main:
                            # ...
                    access_control:
                        # require ROLE_ADMIN for /admin*
                        - { path: ^/admin, roles: ROLE_ADMIN }      
                         
                    # 以表单方式登陆文档 https://symfony.com/doc/2.8/security/form_login_setup.html
                    # security配置属性文档 https://symfony.com/doc/2.8/reference/configuration/security.html
                    # 自定义方式认证(如token) https://symfony.com/doc/2.8/security/custom_authentication_provider.html
                    # 如果您的应用程序通过第三方服务（如Google，Facebook或Twitter）登录用户，请查看HWIOAuthBundle社区捆绑包。https://github.com/hwi/HWIOAuthBundle
        
        b.配置用户的加载方式(从哪个地方加载用户)
            当您输入用户名时，Symfony需要从某个地方加载该用户的信息。这称为用户提供者，您负责配置它。 
                Symfony有一种从数据库加载用户的内置方法，或者您可以创建自己的用户提供程序。
            服务提供者是可以配置多个的 配置的文档:
                https://symfony.com/doc/2.8/security/multiple_user_providers.html
                
            没有明确配置的用户提供程序的所有防火墙都将使用chain_provider，
                因为它是第一个指定的。反过来，chain_provider将尝试从in_memory和user_db提供程序加载用户。
            
            用户提供程序加载用户信息并将其放入User对象。
                如果从数据库或其他来源加载用户，您将使用自己的自定义User类。
                但是当您使用内存提供程序时，它会为您提供Symfony\Component\Security\Core\User\User对象。
                
            
            第一种方式:最简单（但最有限）的方法是
                    将Symfony配置为直接从security.yml文件本身加载硬编码用户。
                    这被称为内存提供程序
                    security:
                        providers:
                            in_memory:
                                memory:
                                    users:
                                        ryan:
                                            password: ryanpass
                                            roles: 'ROLE_USER'
                                        admin:
                                            password: kitten
                                            roles: 'ROLE_ADMIN'
        
                    还需要编码器
                         security:
                             # ...
                             encoders:
                                 Symfony\Component\Security\Core\User\User: plaintext 加密方式为明文
            
        c.编码用用户的密码
            encoders:
                Symfony\Component\Security\Core\User\User:
                    algorithm: bcrypt
                    cost: 12
            可以使用命令来生成加密后的字符串
                php app/console security:encode-password
    
    2.授权(角色和权限)
        用户现在可以使用http_basic或其他方法登录您的应用程序。、
        现在，您需要了解如何拒绝访问和使用User对象。这称为授权，其工作是决定用户是否可以访问某些资源（URL，模型对象，方法调用......）。
        授权过程有两个不同的方面：、
            用户在登录时会收到一组特定的角色（例如ROLE_ADMIN）。
            您添加代码，以便资源（例如URL，控制器）需要特定的“属性”（最常见的角色，如ROLE_ADMIN）才能被访问

            除了角色（例如ROLE_ADMIN）之外，您还可以使用其他属性/字符串（例如EDIT）保护资源，
            并使用选民或Symfony的ACL系统来赋予这些含义。
            如果您需要检查用户A是否可以“编辑”某个对象B（例如ID为5的产品），这可能会派上用场。请参阅访问控制列表（ACL）：保护单个数据库对象。
        角色
            当用户登录时，他们会收到一组角色（例如ROLE_ADMIN）。
            在上面的示例中，这些是硬编码到security.yml中。如果您从数据库加载用户，这些用户可能存储在表中的列中。
            您分配给用户的所有角色必须以ROLE_前缀开头。否则，它们将不会以正常方式由Symfony的安全系统处理
            （即除非您正在做一些高级操作，将FOO这样的角色分配给用户，然后检查FOO，如下所述将不起作用）。
            
            角色很简单，基本上是你根据需要发明和使用的字符串。
            例如，如果您需要开始限制对网站的博客管理部分的访问，则可以使用ROLE_BLOG_ADMIN角色保护该部分。此角色不需要在任何地方定义 - 您可以开始使用它。
            确保每个用户至少有一个角色，或者您的用户看起来没有经过身份验证。一个常见的约定是为每个用户提供ROLE_USER。
            您还可以指定角色层次结构，其中某些角色自动表示您还具有其他角色。
        
        有两种方法可以拒绝访问某些内容：
            第一种:security.yml中的access_control允许您保护URL模式（例如/ admin / *）。这很容易，但灵活性较差;
            第二种:在您的代码中通过security.authorization_checker服务。
        
        第一种:security.yml中access_control允许您保护URL保护模式
            security:
                # ...
                firewalls:
                    # ...
                    main:
                        # ...
                access_control:
                    # require ROLE_ADMIN for /admin*
                    - { path: ^/admin, roles: ROLE_ADMIN }
                    - { path: ^/admin/users, roles: ROLE_SUPER_ADMIN }
                    - { path: ^/admin, roles: ROLE_ADMIN }
            
                您可以根据需要定义任意数量的URL模式 - 每个模式都是正则表达式。
                但是，只有一个匹配。 Symfony将从顶部开始查看每个，并在找到一个与URL匹配的access_control条目后立即停止。
                除了URL之外，access_control还可以匹配IP地址，主机名和HTTP方法。它还可用于将用户重定向到URL模式的https版本
                详细配置https://symfony.com/doc/2.8/security/access_control.html
        
            角色分层
                security:
                    role_hierarchy:
                        ROLE_ADMIN:       ROLE_USER
                        ROLE_SUPER_ADMIN: [ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]
                        
                在上面的配置中，具有ROLE_ADMIN角色的用户也将具有ROLE_USER角色。 
                ROLE_SUPER_ADMIN角色具有ROLE_ADMIN，ROLE_ALLOWED_TO_SWITCH和ROLE_USER（继承自ROLE_ADMIN）。
                
                role_hierarchy选项的值是静态定义的，因此您不能将角色层次结构存储在数据库中。
                如果需要，请创建一个查找数据库中用户角色的自定义安全选民
        
        第二种:在您的代码中通过security.authorization_checker服务。
            保护控制器和其他代码
                您可以轻松拒绝来自控制器内部的访问：
                public function helloAction($name)
                {
                    // The second parameter is used to specify on what object the role is tested.
                    $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
                     // Old way :
                    // if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                    //     throw $this->createAccessDeniedException('Unable to access this page!');
                    // }
                    加入这句代码就直接不能访问了
                }
                            
            感谢SensioFrameworkExtraBundle，您还可以使用注释来保护您的控制器：
                use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
                /**
                 * @Security("has_role('ROLE_ADMIN')")
                 */
                public function helloAction($name)
                {
                    // ...
                }
                
        在模板中使用权限
            如果要检查当前用户是否在模板中具有角色，请使用内置的is_granted（）辅助函数：
                {% if is_granted('ROLE_ADMIN') %}
                    <a href="...">Delete</a>
                {% endif %}
            在2.8之前的Symfony版本中，在不在防火墙后面的页面中使用is_granted（）函数会导致异常。
            这就是为什么你还需要首先检查用户是否存在：
                {% if app.user and is_granted('ROLE_ADMIN') %}
            
        在这两种情况下，都会抛出一个特殊的AccessDeniedException，最终会在Symfony中触发403 HTTP响应。
        如果用户尚未登录，则会要求他们登录（例如，重定向到登录页面）。
        如果他们已登录但没有ROLE_ADMIN角色，则会显示403拒绝访问页面（您可以自定义）。
        如果他们已登录并具有正确的角色，则将执行代码。
        
    
        到目前为止，您已根据角色检查了访问权限 - 那些以ROLE_开头并分配给用户的字符串。
        但是，如果您只想检查用户是否已登录（您不关心角色），那么您可以使用 
        您当然也可以在access_control中使用它  
            public function helloAction($name)
            {
                if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                    throw $this->createAccessDeniedException();
                }
            }
         
        IS_AUTHENTICATED_FULLY不是一个角色，但它有点像一个角色，并且每个成功登录的用户都会拥有此角色。
        实际上，有三个特殊属性，如下所示：
        IS_AUTHENTICATED_REMEMBERED：所有登录的用户都拥有此权限，即使他们因“记住我的cookie”而登录。
                                    即使您不使用“记住我”功能，也可以使用此功能检查用户是否已登录。
        IS_AUTHENTICATED_FULLY：这类似于IS_AUTHENTICATED_REMEMBERED，但更强。
                    仅因“记住我的cookie”而登录的用户将拥有IS_AUTHENTICATED_REMEMBERED，但不会有IS_AUTHENTICATED_FULLY。
        IS_AUTHENTICATED_ANONYMOUSLY：所有用户（甚至是匿名用户）都有此功能 - 这在将URL列入白名单以保证访问时非常有用 
        
        - 一些详细信息在安全性access_control如何工作？
            https://symfony.com/doc/2.8/security/access_control.html
          
    3. 检查用户对象
        身份验证后，可以通过security.token_storage服务访问当前用户的User对象。从控制器内部看，它将如下所示
            public function indexAction()
            {
                if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                    throw $this->createAccessDeniedException();
                }
            
                $user = $this->getUser();
            
                // the above is a shortcut for this 以上是此的捷径 可以使用下面代码替换上面
                $user = $this->get('security.token_storage')->getToken()->getUser();
            }
        用户将是一个对象，该对象的类将取决于您的用户提供者。比如获取用户的姓名
            use Symfony\Component\HttpFoundation\Response;
            public function indexAction()
            {
                return new Response('Well hi there '.$user->getFirstName());
            }
        
        始终检查用户是否已登录
            检查用户是否首先进行身份验证非常重要。如果它们不是，$user将为null或字符串为anon 什么？
            是的，这是一个怪癖。如果您尚未登录，则用户在技术上是字符串anon。
            尽管getUser（）控制器快捷方式将此转换为null以方便使用。
            重点是：在使用User对象之前，请务必检查用户是否已登录，使用isGranted（）方法（或access_control）执行此操作：
            if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                throw $this->createAccessDeniedException();
            }           
            // 不要这样检查用户登陆
            if ($this->getUser()) {
            
            }
            
            在模板中检索用户
                在Twig模板中，可以通过app.user键访问此对象：
                    {% if is_granted('IS_AUTHENTICATED_FULLY') %}
                        <p>Username: {{ app.user.username }}</p>
                    {% endif %}
    
    4.注销
        请注意，使用http-basic经过身份验证的防火墙时，没有真正的注销方法：
            注销的唯一方法是让浏览器停止在每次请求时发送您的名称和密码。
            清除浏览器缓存或重新启动浏览器通常会有所帮助。
        
        通常，您还希望您的用户能够注销。幸运的是，当您激活logout配置参数时，防火墙可以自动为您处理：
        # app/config/security.yml
        security:
            firewalls:
                secured_area:
                    logout:
                        path:   /logout
                        target: /
        接下来，您需要为此URL创建路由不需创建控制器：
        logout:
            path: /logout
        一旦用户退出，他们将被重定向到由上面的目标参数（例如主页）定义的任何路径。
        
        如果在注销后需要做一些更有趣的事情，可以通过添加success_handler键
           并将其指向实现LogoutSuccessHandlerInterface的类的服务ID来指定注销成功处理程序。
    
    实战		
    个性化用户认证流程（一）	
		1.创建用户类 文档 https://symfony.com/doc/2.8/security/custom_provider.html       
			首先，无论您的用户数据来自何处，您都需要创建一个表示该数据的User类。
			用户可以根据需要查看并包含任何数据。唯一的要求是该类实现了UserInterface。
			因此，应在自定义用户类中定义此接口中的方法：
				getRoles（）
				getPassword（）
				getSalt（）
				getUsername（）
				eraseCredentials（）。仅用于清除可能存储的纯文本密码（或类似凭据）。
					如果您的用户类也映射到数据库，请注意要擦除的内容，因为在请求期间可能会保留修改后的对象
					
			  实现EquatableInterface接口也可能很有用，该接口定义了一个检查用户是否等于当前用户的方法。
				此接口需要isEqualTo（）方法
			
			symfony给我们提供了AdvancedUserInterface接口继承了UserInterface
			所以我们也可以使用AdvancedUserInterface接口
				它提供了四个方法用来校验的  如果其中任何一个返回false，则不允许用户登录。
					isAccountNonExpired() 检查用户的帐户是否已过期; 
						可以永远返回true 就是没有账户过期的这种应用场景
						怎么判断根据自己的数据结构来判断
					isAccountNonLocked() 检查用户是否被锁定; 冻结的用户是可以恢复的
					isCredentialsNonExpired() 检查用户的凭据（密码）是否已过期;
					isEnabled() 检查用户是否已启用 比如数据库的标准位 用户假删除 删除的用户不能被恢复的
			另外还要实现Serializable接口symfony会将当前的user序列化到session中
		2.创建用户提供者
                现在你有了一个User类，你将创建一个用户提供程序，
                它将从某些Web服务中获取用户信息，创建一个WebserviceUser对象，并用数据填充它。               
                用户提供程序只是一个必须实现UserProviderInterface的普通PHP类，
                    它需要定义三个方法：
                        loadUserByUsername（$ username），
                        refreshUser（UserInterface $ user）
                        supportsClass（$ class）。
                注册
                services:
                    app.webservice_user_provider:
                        class: AppBundle\Security\User\WebserviceUserProvider
						
		3.处理密码加密解密
			首先在security.yml配置加密方式
			然后在用户注册是进行加密算法
			https://symfony.com/doc/2.8/security/password_encoding.html	
			但是我们可以用symfony给我提供的 MessageDigestPasswordEncoder给我生成带salt的密码
		
		4.自定义登陆成功处理
			比如打印日志 记录登陆ip 如果是ajax请求返回json格式,如果是html请求返回页面
			继承一个Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler
			重写onAuthenticationSuccess方法即可
			
		5.自定义登陆失败处理
			比如打印日志 记录登陆ip 如果是ajax请求返回json格式,如果是html请求返回页面
			继承 Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler
			重写onAuthenticationFailure方法即可
			
		6.请看整个的yml配置
			parameters:
				app.current_user.class: Biz\User\CurrentUserservices:
			services:
				app.user_provider:
					class: Biz\User\UserProvider
					arguments: ['@service_container']
				app.admin_authenticator:
					class: SomeSecurityBundle\GuardAuthenticator\AdminAuthenticator
					arguments: ['@service_container']

			security:
				providers:
					user_provider:
						id: app.user_provider
				encoders:
					"%app.current_user.class%":
						algorithm: sha256
						encode_as_base64: true
						iterations: 5000
				firewalls:
					dev:
						pattern: ^/(_(profiler|wdt)|css|images|js)/
						security: false
					disabled:
						pattern: ^/(anon|callback)/
						security: false
					main:
						pattern:    /.*
						anonymous: true
						form_login:
							login_path: login
							check_path: login
							failure_handler: topxia.authentication.failure_handler
							success_handler: topxia.authentication.success_handler
				role_hierarchy:
					ROLE_ADMIN:       ROLE_USER
					ROLE_SUPER_ADMIN: [ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]
				access_control:
					- { path: ^/crontab, roles: IS_AUTHENTICATED_ANONYMOUSLY }
					- { path: ^/admin, roles: ROLE_ADMIN }
					- { path: ^/.*, roles: IS_AUTHENTICATED_ANONYMOUSLY }
			
	个性化用户认证流程（二）
		认证的逻辑
			认证处理流程说明
				登陆请求
				|
				UsernamePassword AuthenticationFilter    、
				| 它负责表单的登陆请求将用户输入的用户名和密码创建了UsernamePasswordToken对象 UsernamePasswordToken是继承了TokenInterface接口
				|  UsernamePasswordToken的构造方法
				|  	UsernamePasswordAuthticationToken($user, $credentials, string $providerKey, array $roles = [])
				| 	
				|  new UsernamePassword($username, $password, $providerKey) 一开始是没有role权限的 所以Authentication(未认证)
				| 
				|
				AuthenticationProviderManager 
				|  
				|  它负责收集所有的 AuthenticationProvider
				|  它有一个authenticate(TokenInterface $token)方法 
				|  拿到所有的AuthenticationProvider循环的所有的AuthenticationProvider
				|  	  就挨个问所有的provider你支不支持我这种token登陆方法
				|  它会跳出其中一个符合的这个token的AuthenticationProvider
				|  
				|  其中UsernamePasswordToken这种登陆方式(类型)的是 DaoAuthenticationProvider  DaoAuthenticationProvider继承了UserAuthenticationProvider
				|  DaoAuthenticationProvider就调用了我们提供的UserProvider->loadUserByUsername($username);
				|  如果拿到了我们的用户下信息还需要preAuthenticationChecks.check($user) 做预检查
				|         检查之前我们的用户类CurrentUser实现UserInterface的制作这三个预检查
				|                  isAccountNonLocked 
				| 				   isEnabled
				|                  isAccountNonExpired
				|  检查预检查还要组加一个检查在DaoAuthenticationProvider具体的实现
				|        就是我们之前的密码加密
				|  还要后检查 postAuthenticationChecks.check($user)
				|
				|  所有的检查都通过过后,才认为登陆成功的
				|
				|  重新生成了 new UsernamePasswordToken()这个是认证过后的对象
				|
				AuthenticationProvider 它负责验证逻辑 其中有一个方法是supports()是否支持我传进来token的类型
				| 不同的AuthenticationProvider支持的token是不同的
				|
				UserDetailsService
				|
				UserDetails->Authentication(已经认证)
				|
				认证完了成功调用我们自己写的Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler
			
				上面的过程只要一处发生错误就会抛出异常 执行我们自己写的Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler
			
			认证结果如何在多个请求之间共享
				SecurityContext PersistenceFilter
				|
				| 在DefaultAuthenticationSuccessHandler方法调用之前调用了它 
				|	它把UsernamePasswordToken保证其唯一性 重写了 hash equest
				|
				SecurityContextHolder
				|  线程级的全局变量保存这个UsernamePasswordToken或获取
				|  进来的时候看看session里面有吗？有就拿出来用
				|  出去的时候看看线程里面有吗? 有就存入session中
				| 
				SecurityContext
				|
				Authentication
				
		获取认证用户信息
			$user = $this->getUser();
			$this->get('security.token_storage')->getToken()->getUser();
				
    认证流程源码级详解
    图片验证码
		
    图片验证码重构
    添加记住我功能
    短信验证码接口开发
    短信登录开发
    短信登录配置及重构

    OAuth协议简介
    SpringSocial简介
    开发QQ登录（上）
    开发QQ登录（中）
    开发QQ登录（下）
    处理注册逻辑
    开发微信登录
    绑定和解绑处
    单机Session管理
    集群Session管理
    退出登录
    
    OAuth简介
    实现标准的OAuth服务提供商
    SpringSecurityOAuth核心源码解析
    重构用户名密码登录
    重构短信登录
    重构社交登录
    重构注册逻辑
    令牌配置
    使用JWT替换默认令牌
    基于JWT实现SSO单点登录1
    基于JWT实现SSO单点登录2
    SpringSecurity授权简介
    SpringSecurity源码解析
    权限表达式.mp4
     7-4 基于数据库Rbac数据模型控制权限
     8-1 课程总结.mp4
```

		https://symfony.com/doc/2.8/components/security/authentication.html

		1安全组件提供4个相关的身份验证事件：
			Name								Event Constant							Argument Passed to the Listener
		security.authentication.success	AuthenticationEvents::AUTHENTICATION_SUCCESS		AuthenticationEvent
			当提供程序对用户进行身份验证时，将调度security.authentication.success事件
		security.authentication.failure	AuthenticationEvents::AUTHENTICATION_FAILURE		AuthenticationFailureEvent
			当提供程序尝试身份验证但失败（即抛出AuthenticationException）时，将调度security.authentication.failure事件
		security.interactive_login		SecurityEvents::INTERACTIVE_LOGIN					InteractiveLoginEvent
			用户登陆网站后触发该事件
		security.switch_user			SecurityEvents::SWITCH_USER							SwitchUserEvent	
			每次激活switch_user防火墙侦听器时都会触发security.switch_user事件。
		
		如果是ajax请求返回json格式,如果是html请求返回页面
			如果是html请求跳转
			只需要创建一个监听security.interactive_login的监听器
		
		
	
		
		

			php app/console config:dump-reference security

























































		2.如何使用Guard创建自定义身份验证系统
			需要实现GuardAuthenticatorInterface接口的四个方法
				getCredentials(Request $request)
					这是每次请求都会执行的方法，让开发者从 $request 对象中获取登录所需要的讯息，
					比如常见表单登录的用户名和密码，或者微信登录的 code 参数。
					返回的结果可以是任意的类型，但一般来说用数组
					
					如果返回null 那么 GuardAuthenticatorInterface::start 方法将会被执行
					如果不是 null，则 GuardAuthenticatorInterface::getUser 方法将被执行
							而 getCredentials 返回的结果将作为 getUser 的第一个参数。
				start(Request $request, AuthenticationException $authException = null)
					此方法可以理解成传统 Symfony 登录系统的 entry point，即让用户登录的地方。
					看定义可以发现此方法返回一个 Response，你可以返回带登录表单的页面，或者跳转到微信 OAuth 获取 code 的接口。
					当用户提交了账号密码，或者微信返回带 code 参数的链接，第二次请求开始，将又从 getCredentials 方法重新开始。
				getUser($credentials, UserProviderInterface $userProvider)
					此方法一般来说，都需要利用 UserProvider 的 loadUserByUsername 方法，
					通过传入 $credentials 里的登录名，或者微信的 openId，返回 User 对象。
					如果通过用户名找不到对应的 User 对象，既 UserProvider::loadUserByUsername 返回 null，
						那么 GuardAuthenticatorInterface::onAuthenticationFailure 方法将会被调用；
					如果 UserProvider::loadUserByUsername 能返回 User 对象，
						那么 GuardAuthenticatorInterface::checkCredentials 方法将会被调用，
							而 $user 对象会被作为第二参数被传入，第一参数仍是 $credentials。
				checkCredentials($credentials, UserInterface $user)
					此方法将检查用户和 $credentials 是否匹配。
					比如表单登录，将 $credentials 里的密码信息和 $user 对象里的密码做对比，
					如果密码不匹配，那么你将在此方法抛出 AuthenticationException 异常或者返回 false 来表示登录失败，
					从而转向 GuardAuthenticatorInterface::onAuthenticationFailure 方法。
				onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
					当然，如果 checkCredentials 方法返回 true（即登录成功），
					那么 GuardAuthenticatorInterface::onAuthenticationSuccess 方法将会被调用，
					你可以在此方法做一些登录成功之后的事情。此方法需要返回 Response 或者 null，
					如果返回 null 将继续执行当前路径应当执行的代码；
					如果返回 Response，则此 Response 会立马发送。
					比如如果要求用户登录成功都需要返回到首页，那么你就可以在此返回 new RedirectResponse('/')。
				onAuthenticationFailure(Request $request, AuthenticationException $exception)
					最后是登录失败的处理。类似于登录成功，此方法需要返回 Response，
					比如显示登录失败的页面，或者继续显示登录表单让用户登录。
				supportsRememberMe()
				createAuthenticatedToken(UserInterface $user, string $providerKey)
			例如微信登陆 参考: https://www.chrisyue.com/use-symfony-guard-as-authentication.html
		有些是表单登陆 有些是微信登陆 有些是api登陆等等,那怎么办呢?
			参考: https://symfony.com/doc/2.8/security/multiple_guard_authenticators.html
	
		防火墙的配置 使用 php app/console debug:config security 命令来检查