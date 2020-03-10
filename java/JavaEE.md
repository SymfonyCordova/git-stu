# 外网映射工具
    将本地服务器映射的外网
    natapp.cn 方便调试支付宝 微信

# xml

```reStructuredText
1.XML概述
	1.1XML：XML一种数据存储格式，这种数据存储格式在存储数据内容的同时，还能够保存数据之间的关系
	1.2XML保存数据的方法：XML利用标签来保存数据的内容，利用标签之间的嵌套关系来保存数据之间的关系。
	1.3XML的应用场景：
		1.3.1利用XML跨平台的特性，用来在不同的操作系统不同的开发语言之间传输数据。如果说java是一门跨平台的语言，那XML就是跨平台的数据。
		1.3.2利用XML可以保存具有关系的数据的特性，还常常被用来做为配置文件使用。，
	1.4XML文件：把XML格式的数据保存到文件中，这样的文件通常起后缀名为.XML，这样的文件就叫做XML文件，XML文件是XML数据最常见的存在形式，但是，这不是XML的唯一存在形式（在内存中或在网络中也可以存在），不要把XML狭隘的理解成XML文件。
	1.5XML校验：浏览器除了内置html解析引擎外还内置了XML解析器，利用浏览器打开XML格式的数据，就可以进行XML校验。
2.XML语法
	2.1文档声明：一个格式良好的XML必须包含也只能包含一个文档声明，并且文档声明必须出现在XML文档第一行，其前不能有其他任何内容。
		2.1.1最简单的写法：<?XML version="1.0" ?>其中的version代表当前XML所遵循的规范版本。
		2.1.2使用encoding属性指定文档所使用的字符集编码：<?XML version="1.0" encoding="gb2312" ?>
					注意：encoding属性指定的编码集和XML真正使用的编码应该一致，如果不一致就会有乱码问题。
								encoding属性默认值为老外喜欢的iso8859-1
		2.1.3使用standalone属性指定当前XML文档是否是一个独立文档：<?XML version="1.0" standalone="no" ?>,standalone默认值为yes表示是一个独立文档。
				注意：很多的解析器会忽略这个属性，但是学习知识要按标准去学，所以这个属性也要掌握。
	2.2元素
		2.2.1元素分为开始标签和结束标签，在开始标签和结束标签之间的文本称为标签体，如果一个标签即不含标签体也不包含其他标签，那这样的标签可以把开始标签和结束标签进行合并，这样的标签叫自闭标签。
		<a>xxxxx</a>   <a/>
		2.2.2一个元素也可以包含若干子元素，但是要注意所有的标签都要进行合理嵌套。
		2.2.3一个格式良好的XML文档应该具有并且只能有一个跟标签，其他标签都应该是这个跟标签的子孙标签。
		2.2.4元素的命名规范：
			区分大小写，例如，<P>和<p>是两个不同的标记。
			不能以数字或标点符号或"_"开头。
			不能以XML(或XML、或Xml 等)开头。
			不能包含空格。
			名称中间不能包含冒号（:）
	2.3属性
		一个元素可以包含多个属性，属性的值要用单引号或双引号括起来。如果属性的之中包含双引号，就要用单引号了。
		属性的命名规范，参照元素的命名规范。
	2.4注释
		<!--这是一段注释-->
		注意：注释不能出现在文档声明之前。实验：把注释写到文档声明之前，用ie打开是没问题，但是用chrome打开是报错的。这就看出来了不同的解析器有不同的处理，我们学习的时候还是按标准去学。
			注释不能嵌套注释
	2.5CDATA区、转义字符
		都可以用来转义特殊字符。
		2.5.1CDATA区<![CDATA[这是要转义的内容]]>
			被CDATA区扩起来的内容，将会被浏览器当作文本来处理。
		2.5.2转义字符
			& --> &amp;
			< --> &lt;
			>	--> &gt;
			" --> &quot;
			' --> &apos;			
		2.5.3CDATA区和转义字符的区别
			(1)CDATA区可以成段的进行转义，而转义字符一次只能转义一个字符
			(2)CDATA区转义的字符可以保存数据本来的格式只是通知解析器按文本去处理。转义字符改变了数据本身的内容，利用其他字符替代了转义字符。请思考，如果要转义的内容是一段js程序的话，如果用转义字符合适不合适？
	2.6处理指令:一段指令通知解析器以何种方式解析XML
			<?XML-stylesheet type="text/css" href="1.css" ?>指定解析器使用1.css去渲染当前的XML数据
			其实文档声明就是一个最常见的处理指令。
3.DTD技术
	3.1DTD是一门XML约束技术，用来约束XML写法。
	3.2如何在XML中引入一个DTD
			3.2.1外部引入：dtd约束文件存在在一个外部文件中，我们在XML中引入该约束。
				(1)本地文件引入：该dtd文件存在在本地硬盘中
					<!DOCTYPE 根元素的名称 SYSTEM "文件所在的路径">
				(2)公共位置文件引入:dtd约束文件存在在一个公共网络上，我们在XML引入该约束
					<!DOCTYPE 根元素的名称 PUBLIC "dtd名称" "dtd所在的URL">
			3.2.2在XML内部写dtd约束
				在文档声明下<!DOCTYPE 根元素名称 [dtd约束的内容]>
	3.3利用dtd约束XML中的元素
		<!ELEMENT 元素名称 元素约束> 
		3.3.1元素约束
				(1)存放类型
					ANY:当前声明的元素可以包含任意子元素
					EMPTY:当前声明的元素不能包含任何元素
				(2)存放内容：利用小括号括起来的元素的名称，用来表示该元素中可以存放哪些内容
					<!ELEMENT "元素名" (可以包含的元素的名称)>
					小括号中的内容，可以有多个子元素的名称
						如果用“,”分割这些子元素就表明这些子元素必须按指定的顺序出现
						如果用“|”分割这些内容就表明这些子元素只能出现其中之一
						使用“+”来表明内容可以出现一次或多次
						使用“*”来表明内容可以出现零次或多次
						使用“?”来表明内容可以出现零次或一次
						#PCDATA表明该元素可以包含标签体
						可以利用()进行组操作：
						<!ELEMENT MYFILE ((TITLE*, AUTHOR?, EMAIL)* | COMMENT)>
	3.4利用dtd约束XML中的属性
			<!ATTLIST 元素名
						属性名 属性类型 属性约束
						。。。。>
			3.4.1属性类型
			（1）CDATA：表明该属性的值是一个普通的文本值。
			（2）ENUMERATED：表明该属性的值只能取指定范围内的其中之一
			（3）ID:表明该属性值在整个文档中必须唯一，注意ID类型的属性的值必须以字母下划线开头，并且不能以数字开头，不能包含空白字符
			
			3.4.2属性约束
			（1）#REQUIRED 来表明当前这个属性是必须存在的属性
			（2）#IMPLIED 来表明当前这个属性是可选的属性
			（3）#FIXED "固定值" 来表明当前这个属性具有一个默认的值，可以不明确指定该属性，解析器会帮你加上，如果你硬是指定了一个其他的值，会出错。
			（4）"默认值" 来表明当前属性具有一个默认的值，如果给这个属性指定一个值就用指定的值，如果不指定呢，就使用默认值。
			
	3.5实体：可以理解为对一段内容的引用，如果有一段内容到处在被使用，可以将其设计为一个实体
			3.5.1引用实体：用在XML中的实体
			声明实体：<!ENTITY 实体名称 "实体内容">
			引用引用实体：&实体名称;
				
			3.5.2参数实体：用在DTD文件中的实体
			声明实体:<!ENTITY % 实体名称 "实体内容">
			引用参数实体: %实体名称;

2.XML编程:利用java程序去增删改查(CRUD)xml中的数据
	
	解析思想:
		dom解析
		sax解析
	基于这两种解析思想市面上就有了很多的解析api
		sun jaxp既有dom方式也有sax方式,并且这套解析api已经加入到j2se的规范中,意味这不需要导入任何第三方开发包就可以直接使用这种解析方式.但是这种解析方式效率低下,没什么人用.
		dom4j 可以使用dom方式高效的解析xml.
		pull
	
	!!dom4j
		导入开发包,通常只需要导入核心包就可以了,如果在使用的过程中提示少什么包到lib目录下在导入缺少的包即可


3.Schema -- xml的约束技术  --- 需要掌握名称空间的概念,会读简单的Schema就可以了,不需要大家自己会写

	Schema是xml的约束技术,出现的目的是为了替代dtd
	本身也是一个xml,非常方便使用xml的解析引擎进行解析
	对名称空间有非常好的支持
	支持更多的数据类型,并且支持用户自定义数据类型
	可以进行语义级别的限定,限定能力大大强于dtd
	相对于dtd不支持实体
	相对于dtd复杂的多,学习成本比较的高
	
	如何在xml中引入Schema --- !!!!!名称空间的概念:全世界独一无二的名字,用来唯一的标识某个资源,通常是公司的域名,只是名字而已并不真的表示资源的位置.

    
    ~~~ Schema的语法---参照Schema的文档,了解即可
```



# tomcat

```reStructuredText
一、web概述
    静态web资源：内容是静态的，不同的人在不同的时间来访问时都是相同的内容。HTML、CSS、JS
    动态web资源：内容是由程序生成的，不同的人在不同的时间访问的内容很可能是不同的。
    常见的动态web资源开发技术：
    ASP、PHP、JSP/Servlet
    C/S B/S之争
    云、移动互联网、html5、物联网
			
二、TOMCAT服务器的安装与配置
	1.常见服务器：WebLogic（BEA）、webSphere（IBM）、Tomcat（Apache）
	2.Tomcat 的下载与安装
		tomcat5要求jdk1.4以上
        tomcat6要求jdk1.5以上
        tomcat7要求jdk1.6以上
        下载地址：http://tomcat.apache.org/
        安装目录不能包含中文和空格
        JAVA_HOME环境变量指定Tomcat运行时所要用的jdk所在的位置，注意，配到目录就行了，不用指定到bin
		端口占用问题：netstat -ano命令查看端口占用信息
		Catalina_Home环境变量：startup.bat启动哪个tomcat由此环境变量指定，如果不配置则启动当前tomcat，推荐不要配置此环境变量
    3.Tomcat的目录结构
        bin--存放tomcat启动关闭所用的批处理文件
        conf--tomcat的配置文件，最终要的是server.xml
        *实验:修改servlet.xml,更改tomcat运行所在的端口号，从8080改为80
        lib--tomcat运行所需jar包
        logs--tomcat运行时产生的日志文件
        temp--tomcat运行时使用的临时目录，不需要我们关注
        webapps--web应用所应存放的目录
        work--tomcat工作目录，后面学jsp用到
	4.虚拟主机（一个真实主机可以运行多个网站，对于浏览器来说访问这些网站感觉起来就像这些网站都运行在自己的独立主机中一样，所以，我们可以说这里的每一个网站都运行在一个虚拟主机上，一个网站就是一个虚拟主机）
		4.1配置虚拟主机
			在server.xml中<Engine>标签下配置<Host>,其中name属性指定虚拟主机名，appBase指定虚拟主机所在的目录
			只在servlet.xml中配置Hosts，还不能是其他人通过虚拟主机名访问网站，还需要在DNS服务器上注册一把，我们可以使用hosts文件模拟这个过程
			默认虚拟主机：在配置多个虚拟主机的情况下，如果浏览器使用ip地址直接访问网站时，该使用哪个虚拟主机响应呢？可以在<Engine>标签上设置defaultHost来指定
	5.web应用（web资源不能直接交给虚拟主机，需要按照功能组织用目录成一个web应用再交给虚拟主机管理）
        5.1web应用的目录结构
            web应用目录
            |
            -html、css、js、jsp
            |
            -WEB-INF
            |
            -classes
            |
            -lib
            |
            -web.xml
        5.2web.xml文件的作用：
            某个web资源配置为web应用首页
            将servlet程序映射到某个url地址上
            为web应用配置监听器
            为web应用配置过滤器
            但凡涉及到对web资源进行配置，都需要通过web.xml文件
            *实验：配置一个web应用的主页
		5.3web应用的虚拟目录映射
			（1）在server.xml的<Host>标签下配置<Context path="虚拟路径" docBase="真实路径">如果path=""则这个web应用就被配置为了这个虚拟主机的默认web应用
			（2）在tomcat/conf/引擎名/虚拟主机名 之下建立一个.xml文件，其中文件名用来指定虚拟路径，如果是多级的用#代替/表示，文件中配置<Context docBase="真实目录">，如果文件名起为ROOT.xml则此web应用为默认web应用
			（3）直接将web应用放置到虚拟主机对应的目录下，如果目录名起为ROOT则此web应用为默认web应用
						~如果三处都配置默认web应用则server.xml > config/.../xx.xml > webapps
		5.4杂项
			(1)打war包：方式一：jar -cvf news.war * 方式二：直接用压缩工具压缩为zip包，该后缀为.war
			(2)通用context和通用web.xml，所有的<Context>都继承子conf/context.xml,所有的web.xml都继承自conf/web.xml
			(3)reloadable让tomcat自动加载更新后的web应用，当java程序修改后不用重启，服务器自动从新加载，开发时设为true方便开发，发布时设为false，提高性能
			(4)Tomcat管理平台，可以在conf/tomcat-users.xml下配置用户名密码及权限
```



# servlet

```reStructuredText
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

一、Servlet
    1.sun提供的一种动态web资源开发技术.本质上就是一段java小程序.可以将Servlet加入到Servlet容器中运行.
    *Servlet容器 -- 能够运行Servlet的环境就叫做Servlet容器. --- tomcat
    *web容器 -- 能够运行web应用的环境就叫做web容器 --- tomcat
    
    2.
  		写一个类实现sun公司定义的Servlet接口（此处直接继承了默认实现类GenericServlet）
				package cn.itheima;
				import java.io.*;
				import javax.servlet.*;
				
				public class FirstServlet extends GenericServlet{
					public void service(ServletRequest req, ServletResponse res) throws ServletException, java.io.IOException{
							res.getOutputStream().write("My FirstServlet!".getBytes());
					}
				}
        将写好的类配置到tomcat中的web应用的web.xml中,(配置对外访问路径)
        	<servlet>
	        <servlet-name>FirstServlet</servlet-name>
	        <servlet-class>cn.itheima.FirstServlet</servlet-class>
		    </servlet>
		    <servlet-mapping>
		        <servlet-name>FirstServlet</servlet-name>
		        <url-pattern>/FirstServlet</url-pattern>
		    </servlet-mapping>
    
    3.Servlet的调用过程/生命周期
    
         1执行Servlet的构造方法
         2执行init初始化方法
           1，2是第一次访问的时候创建servlet程序会调用
         3执行service方法
           3每次访问都会调用
         4执行destroy销毁方法
         
         通常情况下，servlet第一次被访问的时候在内存中创建对象，在创建后立即调用init()方法进行初始化。对于每一次请求都掉用service(req,resp)方法处理请求，此时会用Request对象封装请求信息，并用Response对象（最初是空的）代表响应消息，传入到service方法里供使用。当service方法处理完成后，返回服务器服务器根据Response中的信息组织称响应消息返回给浏览器。响应结束后servlet并不销毁，一直驻留在内存中等待下一次请求。直到服务器关闭或web应用被移除出虚拟主机，servlet对象销毁并在销毁前调用destroy()方法做一些善后的事情
         
    4.Servlet的继承结构
        Servlet接口 -- 定义了Servlet应该具有的基本方法
            |
            |--GenericServlet --通用基本Servlet实现,对于不常用的方法在这个实现类中进行了基本的实现,对于Service设计为了抽象方法,需要子类去实现
                    |
                    |--HttpServlet --在通用Servlet的基础上基于HTTP协议进行了进一步的强化:实现了GenericServlet中的Service方法,判断当前的请求方式,调用对应到doXXX方法,这样一来我们开发Servlet的过程中只需继承HttpServlet ,覆盖具体要处理的doXXX方法就可以根据不同的请求方式实现不同的处理.一般不要覆盖父类中的Service方法只要覆盖doGet/doPost就可以了
    
     5.Servlet的细节
        (1)一个<servlet>可以对应多个<serlvet-mapping>,从而一个Servlet可以有多个路径来访问
        (2)url-partten中的路径可以使用*匹配符号进行配置,但是要注意,只能是/开头/*结尾或*.后缀这两种方式
            ~由于*的引入,有可能一个路径被多个urlpartten匹配,这是优先级判断条件如下:
                哪个最像找哪个
                *.后缀永远匹配级最低
        (3)<serlvet>可以配置<load-on-startup>可以用来指定启动顺序
        (4)缺省Servlet:如果有一个Servlet的url-partten被配置为了一根正斜杠,这个Servlet就变成了缺省Serlvet.其他Servlet 都不处理的请求,由缺省Servlet来处理.
        其实对于静态资源的访问就是由缺省Servlet来执行
        设置404页面500页面等提示页面也是由缺省Servlet来执行
        通常我们不会自己去配置缺省Servlet
        (5)线程安全问题
            由于默认情况下Servlet在内存中只有一个对象,当多个浏览器并发访问Servlet时就有可能产生线程安全问题
            解决方案:
                加锁--效率降低
                SingleThreadModel接口 -- 不能真的防止线程安全问题
                最终解决方案:在Servlet中尽量少用类变量,如果一定要用类变量则用锁来防止线程安全问题,但是要注意锁住内容应该是造成线程安全问题的核心代码,尽量的少锁主内容,减少等待时间提高servlet的响应速度
                
二、ServletConfig -- 代表当前Servlet在web.xml中的配置信息
	<servlet>
	    <servlet-name>Demo5Servlet</servlet-name>
	    <servlet-class>cn.itheima.Demo5Servlet</servlet-class>
	    <init-param>
	    	<param-name>data1</param-name>
	    	<param-value>value1</param-value>
	    </init-param>
	 </servlet>
	 
     String getServletName()  -- 获取当前Servlet在web.xml中配置的名字
     String getInitParameter(String name) -- 获取当前Servlet指定名称的初始化参数的值
     Enumeration getInitParameterNames()  -- 获取当前Servlet所有初始化参数的名字组成的枚举
     ServletContext getServletContext()  -- 获取代表当前web应用的ServletContext对象
	
	每个Servlet对应自己的ServletConfig,所以每个Servle是不一样的,ServletConfig也是不一样的，你自己的Servlet是不能获取到别人的Servlet
	ServletConfig可以通过Servlet中的init的方法可以拿到它,但是重写init方法是一定要super.init()调用以下,否则this.getServletConfig()得不到ServletConfig
	还可以this.getServletConfig()得到
	
三、ServletContext -- 代表当前web应用
    1.做为域对象可以在整个web应用范围内共享数据，整个web只有一个ServletContext
        域对象：在一个可以被看见的范围内共享数据用到对象,类似于Map
        Map: 存数据(put) 取数据(get) 删除(remove)
        域对象：存数据(setAttribute) 取数据(getAttribute) 删除(removeAttribute)，带Attribute的
        
        作用范围：整个web应用范围内共享数据
        生命周期：当服务器启动web应用加载后创建出ServletContext对象后，域产生。当web应用被移除出容器或服务器关闭，随着web应用的销毁域销毁。
      
       void setAttribute(String,Object);
       Object getAttribute(String);
       void removeAttribute(String);
       
       通过ServletConfig获取ServletContext
       直接getServletContext()获取ServletContext
     
     2.用来获取web应用的初始化参数
     	获取web.xml中配置的上下文参数context-param
     		<context-param>
				<param-name>param1</param-name>
				<param-value>pvalue1</param-value>
			</context-param>
            this.getServletContext().getInitParameter("param1")
            this.getServletContext().getInitParameterNames()
     	获取当前的工程路径,格式:/工程路径
     		servletContext.getContextPath()
     		如http://localhost:30000/servlet/hello4 获取的是/servlet
     	获取工程部署后在服务器硬盘上的绝对路径
     		servletContext.getRealPath("/") 
     		获取的是/home/zler/桌面/intellij_idea/Base/out/artifacts/servlet_war_exploded/
     		其映射到IDEA代码的web目录
     	像Map一样存取数据
     	
     3.实现Servlet的转发
        
        重定向 : 302+Location
        请求转发 : 服务器内不进行资源流转
        
        *请求转发是一次请求一次响应实现资源流转.请求重定向两次请求两次响应.
        
      4.加载资源文件
            在Servlet中读取资源文件时:
                如果写相对路径和绝对路径,由于路径将会相对于程序启动的目录--在web环境下,就是tomcat启动的目录即tomcat/bin--所有找不到资源
                如果写硬盘路径,可以找到资源,但是只要一换发布环境,这个硬盘路径很可能是错误的,同样不行.
                为了解决这样的问题ServletContext提供了getRealPath方法,在这个方法中传入一个路径,这个方法的底层会在传入的路径前拼接当前web应用的硬盘路径从而得到当前资源的硬盘路径,这种方式即使换了发布环境,方法的底层也能得到正确的web应用的路径从而永远都是正确的资源的路径
                 this.getServletContext().getRealPath("config.properties")
                 this.getServletContext().getResourceAsStream("/1.properties")，给一个资源的虚拟路径返回到该资源真实路径的流
                
          如果在非Servlet环境下要读取资源文件时可以采用类加载器加载文件的方式读取资源
                    Service.class.getClassLoader().getResource("../../../config.properties").getPath()
                    classLoader.getResourceAsStream("../../1.properties")，此方法利用类加载器直接将资源加载到内存中，有更新延迟的问题，以及如果文件太大，占用内存过大
```

 

# Http协议

```reStructuredText
HTTP请求
	请求行
		GET /books/java.html HTTP/1.1
		请求方式 请求的资源名 所遵循的协议
		请求方式：GET、POST，
			其中GET方式在请求资源的URL后跟“？参数名=参数值&参数名=。。。”方式传递参数，传输的数据内容最大为1K
			其中POST方式在请求实体中传输数据
			除了用Form表单明确用method指定用post方式提交数据以外，其他的方式都是GET提交方式

	请求头
		Accept: text/html,image/*    客户端可以接受的数据类型
		Accept-Charset: ISO-8859-1	客户端接受数据需要使用的字符集编码
		Accept-Encoding: gzip,compress 客户端可以接受的数据压缩格式
		Accept-Language: en-us,zh-cn  可接受的语言环境
		Host: www.it315.org:80 想要访问的虚拟主机名
		If-Modified-Since: Tue, 11 Jul 2000 18:23:51 GMT 这是和缓存相关的一个头，带着缓存资源的最后获取时间
		Referer: http://www.it315.org/index.jsp 这个头表示当前的请求来自哪个链接，这个头和防盗链的功能相关
		User-Agent: Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.0) 客户端的一些基本信息
		Cookie 会在后面讲会话技术的时候单讲
		Connection: close/Keep-Alive 指定是否继续保持连接
		Date: Tue, 11 Jul 2000 18:23:51 GMT 当前时间

	实体内容
	
	
HTTP响应
	状态行
		HTTP/1.1 200 OK
		格式： HTTP版本号　状态码　原因叙述<CRLF>
		状态码：
			200：请求处理成功
			302：请求重定向
			304、307：服务器通知浏览器使用缓存
			404：资源未找到
			500：服务器端错误

	若干响应头
		Location: http://www.it315.org/index.jsp  配合302实现请求重定向
		Server:apache tomcat 服务器的基本信息
		Content-Encoding: gzip 服务器发送数据时使用的压缩格式
		Content-Length: 80 发送数据的大小
		Content-Language: zh-cn 发送的数据使用的语言环境
		Content-Type: text/html; charset=GB2312 当前所发送的数据的基本信息，（数据的类型，所使用的编码）
		Last-Modified: Tue, 11 Jul 2000 18:23:51 GMT 缓存相关的头
		Refresh: 1;url=http://www.it315.org 通知浏览器进行定时刷新，此值可以是一个数字指定多长时间以后刷新当前页面，这个数字之后也可以接一个分号后跟一个URL地址指定多长时间后刷新到哪个URL
		Content-Disposition: attachment;filename=aaa.zip 与下载相关的头
		Transfer-Encoding: chunked 传输类型，如果是此值是一个chunked说明当前的数据是一块一块传输的
		Set-Cookie:SS=Q0=5Lb_nQ; path=/search 和cookie相关的头，后面课程单讲
		ETag: W/"83794-1208174400000" 和缓存机制相关的头
		Expires: -1 指定资源缓存的时间，如果取值为0或-1浏览就不缓存资源
		Cache-Control: no-cache  缓存相关的头，如果为no-cache则通知浏览器不缓存
		Pragma: no-cache   缓存相关的头，如果为no-cache则不缓存
		以上三个头都是用来控制缓存的，是因为历史原因造成的，不同的浏览器认识不同的头，我们通常三个一起使用保证通用性。
		Connection: close/Keep-Alive   是否保持连接
		Date: Tue, 11 Jul 2000 18:23:51 GMT 当前时间
	
	实体内容

MIME类型说明
	MIME是HTTP协议中数据类型
	常见的MIME类型:
		超文本标记语言		.html,.html  text/html
		普通文本		  .txt         text/plain
		RTF文本		    .rtf		application/rtf
		GIF图片		    .gif		image/gif
		JPEG图片    	   .jpeg,.jpg   image/jpeg
		au声音文件        .au          audio/basic
		MIDI音乐文件      mid,.mid     audio/midi,audio/x-midi
		RealAudio音乐文件 .ra,ram	   audio/x-pn-realaudio
		MPEG文件         .mpg,.mpeg   video/mpeg
		AVI文件    	   .avi			video/x-msvideo
		GZIP文件         .gz          application/x-gzip
		TAR文件          .tar         application/x-tar
```

# Request和Response

```reStructuredText
Request
	Request代表请求对象，其中封装了对请求中具有请求行、请求头、实体内容的操作的方法
	1.获取客户机信息
		getRequestURL方法返回客户端发出请求完整URL
		getRequestURI方法返回请求行中的资源名部分,在权限控制中常用
		getQueryString 方法返回请求行中的参数部分
		getRemoteHost 获取客户端的IP地址
		getRemoteAddr方法返回发出请求的客户机的IP地址
		getMethod得到客户机请求方式
		getContextPath 获得当前web应用虚拟目录名称，特别重要！！！，工程中所有的路径请不要写死，其中的web应用名要以此方法去获得。

	2.获取请求头信息
		getHeader(name)方法 --- String ，获取指定名称的请求头的值
		getHeaders(String name)方法 --- Enumeration<String> ，获取指定名称的请求头的值的集合，因为可能出现多个重名的请求头
		getHeaderNames方法 --- Enumeration<String> ，获取所有请求头名称组成的集合
		getIntHeader(name)方法  --- int ，获取int类型的请求头的值
		getDateHeader(name)方法 --- long(日期对应毫秒) ，获取一个日期型的请求头的值，返回的是一个long值，从1970年1月1日0时开始的毫秒值
		
		*实验：通过referer信息防盗链
			String ref = request.getHeader("Referer");
			if (ref == null || ref == "" || !ref.startsWith("http://localhost")) {
				response.sendRedirect(request.getContextPath() + "/homePage.html");
			} else {
				this.getServletContext().getRequestDispatcher("/WEB-INF/fengjie.html").forward(request, response);
			}
	3.获取请求参数
		getParameter(name) --- String 通过name获得值
		getParameterValues（name）  --- String[ ] 通过name获得多值 checkbox
		getParameterNames  --- Enumeration<String> 获得所有请求参数名称组成的枚举
		getParameterMap  --- Map<String,String[ ]> 获取所有请求参数的组成的Map集合，注意，其中的键为String，值为String[]
		
		获取请求参数时乱码问题：
			浏览器发送的请求参数使用什么编码呢？当初浏览器打开网页时使用什么编码，发送就用什么编码。
			服务器端获取到发过来的请求参数默认使用ISO8859-1进行解码操作，中文一定有乱码问题
			对于Post方式提交的数据，可以设置request.setCharacterEncoding("UTF-8");来明确指定获取请求参数时使用编码。但是此种方式只对Post方式提交有效。而且必须要放在在doPost里面最开始的地方才生效
			对于Get方式提交的数据，就只能手动解决乱码：String newName = new String(name.getBytes("ISO8859-1"),"gb2312");此种方法对Post方式同样有效。
			在tomcat的server.xml中可以配置http连接器的URIEncoding可以指定服务器在获取请求参数时默认使用的编码，从而一劳永逸的决绝获取请求参数时的乱码问题。也可以指定useBodyEncodingForURI参数，令request.setCharacterEncoding也对GET方式的请求起作用，但是这俩属性都不推荐使用，因为发布环境往往不允许修改此属性。	
			
	4.利用请求域传递对象
		生命周期：在service方法调用之前由服务器创建，传入service方法。整个请求结束，request生命结束。
		作用范围：整个请求链。
		作用：在整个请求链中共享数据，最常用的：在Servlet中处理好的数据要交给Jsp显示，此时参数就可以放置在Request域中带过去。
		
	5.request实现请求转发
		request.getRequestDispatcher("/servlet/Demo17Servlet").forward(request, response)
		
		ServletContext可以实现请求转发，request也可以。
		在forward之前输入到response缓冲区中的数据，如果已经被发送到了客户端，forward将失败，抛出异常
		在forward之前输入到response缓冲区中的数据，但是还没有发送到客户端，forward可以执行，但是缓冲区将被清空，之前的数据丢失。注意丢失的只是请求体中的内容，头内容仍然有效。
		在一个Servlet中进行多次forward也是不行的，因为第一次forward结束，response已经被提交了，没有机会再forward了
		总之，一条原则,一次请求只能有一次响应，响应提交走后，就再没有机会输出数据给浏览器了。
		
	6.RequestDispatcher进行include操作
		forward没有办法将多个servlet的输出组成一个输出，因此RequestDispatcher提供了include方法，可以将多个Servlet的输出组成一个输出返回个浏览器
			request.getRequestDispatcher("/servlet/Demo17Servlet").include(request, response);
			response.getWriter().write("from Demo16");
			request.getRequestDispatcher("/servlet/Demo18Servlet").include(request, response);
		常用在页面的固定部分单独写入一个文件，在多个页面中include进来简化代码量。
	
	7.请求转发的特点:
		浏览器地址栏没有变化
		他们是一次请求
		他们共享Request域中的数据
		可以转发到WEB-INF目录下
			比如: request.getRequestDispatcher("/WEB-INF/aa.html").forward(request, response)
		是否可以访问工程以外的资源
			不能:比如request.getRequestDispatcher("www.baidu.com").forward(request, response)只能在转发到本地本机本项目的web服务
			
			
Base标签
	设置页面相对路径工作时参照的地址
	<base href="http://localhost:8080/aa/bb/" />

Response
	1.Resonse的继承结构：
			ServletResponse--HttpServletResponse
	2.Response代表响应，于是响应消息中的 状态码、响应头、实体内容都可以由它进行操作,由此引伸出如下实验：
	3.利用Response输出数据到客户端
		response.getOutputStream（）.write("中文".getBytes())输出数据，这是一个字节流，是什么字节输出什么字节，而浏览器默认用平台字节码打开服务器发送的数据，如果服务器端使用了非平台码去输出字符的字节数据就需要明确的指定浏览器编码时所用的码表，以防止乱码问题。response.addHeader("Content-type","text/html;charset=gb2312")
		response.getWriter().write(“中文”);输出数据，这是一个字符流，response会将此字符进行转码操作后输出到浏览器，这个过程默认使用ISO8859-1码表，而ISO8859-1中没有中文，于是转码过程中用?代替了中文，导致乱码问题。可以指定response在转码过程中使用的目标码表，防止乱码。response.setCharcterEncoding("gb2312");
		其实response还提供了setContentType("text/html;charset=gb2312")方法，此方法会设置content-type响应头，通知浏览器打开的码表，同时设置response的转码用码表，从而一行代码解决乱码。
	4.利用Response 设置 content-disposition头实现文件下载
			设置响应头content-disposition为“attachment;filename=xxx.xxx”
			利用流将文件读取进来，再利用Response获取响应流输出
			如果文件名为中，一定要进行URL编码，编码所用的码表一定要是utf-8
	5.refresh头控制定时刷新
		设置响应头Refresh为一个数值，指定多少秒后刷新当前页面
		设置响应头Refresh为 3;url=/Day05/index.jsp,指定多少秒后刷新到哪个页面
		可以用来实现注册后“注册成功，3秒后跳转到主页”的功能
		在HTML可以利用<meta http-equiv= "" content="">标签模拟响应头的功能。
	6.利用response设置expires、Cache-Control、Pragma实现浏览器是否缓存资源，这三个头都可以实现，但是由于历史原因，不同浏览器实现不同，所以一般配合这三个头使用
		6.1控制浏览器不要缓存（验证码图片不缓存）设置expires为0或-1设置Cache-Control为no-cache、Pragma为no-cache
		6.2控制浏览器缓存资源。即使不明确指定浏览器也会缓存资源，这种缓存没有截至日期。当在地址栏重新输入地址时会用缓存，但是当刷新或重新开浏览器访问时会重新获得资源。
			如果明确指定缓存时间，浏览器缓存是，会有一个截至日期，在截至日期到期之前，当在地址栏重新输入地址或重新开浏览器访问时都会用缓存，而当刷新时会重新获得资源。
	7.Response实现请求重定向
		7.1古老方法：response.setStatus(302);response.addHeader("Location","URL");
		7.2快捷方式：response.sendRedirect("URL");
	*8.输出验证码图片
	
	9.Response注意的内容：
		9.1对于一次请求，Response的getOutputStream方法和getWriter方法是互斥，只能调用其一，特别注意forward后也不要违反这一规则。
		9.2利用Response输出数据的时候，并不是直接将数据写给浏览器，而是写到了Response的缓冲区中，等到整个service方法返回后，由服务器拿出response中的信息组成HTTP响应消息返回给浏览器。
		9.3service方法返回后，服务器会自己检查Response获取的OutputStream或者Writer是否关闭，如果没有关闭，服务器自动帮你关闭，一般情况下不要自己关闭这两个流。
		


URL编码
	1.由于HTTP协议规定URL路径中只能存在ASCII码中的字符，所以如果URL中存在中文或特殊字符需要进行URL编码。
	2.编码原理：
		将空格转换为加号（+） 
		对0-9,a-z,A-Z之间的字符保持不变 
		对于所有其他的字符，用这个字符的当前字符集编码在内存中的十六进制格式表示，并在每个字节前加上一个百分号（%）。如字符“+”用%2B表示，字符“=”用%3D表示，字符“&”用%26表示，每个中文字符在内存中占两个字节，字符“中”用%D6%D0表示，字符“国”用%B9%FA表示调对于空格也可以直接使用其十六进制编码方式，即用%20表示，而不是将它转换成加号（+） 
		说明：
		如果确信URL串的特殊字符没有引起使用上的岐义或冲突你也可以对这些字符不进行编码，而是直接传递给服务器。例如，http://www.it315.org/dealregister.html?name=中国&password=123 
		如果URL串中的特殊字符可能会产生岐义或冲突，则必须对这些特殊字符进行URL编码。例如，服务器会将不编码的“中+国”当作“中国”处理。还例如，当name参数值为“中&国”时，如果不对其中的“&”编码，URL字符串将有如下形式：http://www.it315.org/dealregister.html?name=中&国&password=123，应编码为：http://www.it315.org/dealregister.html?name=中%26国&password=123 
		http://www.it315.org/example/index.html#section2可改写成http://www.it315.org/example%2Findex.html%23section2 
	3.在java中进行URL编码和解码
		URLencoder.encode("xxxx","utf-8");
		URLDecoder.decode(str,"utf-8");


请求重定向和请求转发的区别 
	1.区别
			RequestDispatcher.forward方法只能将请求转发给同一个WEB应用中的组件；而HttpServletResponse.sendRedirect 方法还可以重定向到同一个站点上的其他应用程序中的资源，甚至是使用绝对URL重定向到其他站点的资源。 
			如果传递给HttpServletResponse.sendRedirect 方法的相对URL以“/”开头，它是相对于服务器的根目录；如果创建RequestDispatcher对象时指定的相对URL以“/”开头，它是相对于当前WEB应用程序的根目录。 
			调用HttpServletResponse.sendRedirect方法重定向的访问过程结束后，浏览器地址栏中显示的URL会发生改变，由初始的URL地址变成重定向的目标URL；调用RequestDispatcher.forward 方法的请求转发过程结束后，浏览器地址栏保持初始的URL地址不变。
			HttpServletResponse.sendRedirect方法对浏览器的请求直接作出响应，响应的结果就是告诉浏览器去重新发出对另外一个URL的访问请求；RequestDispatcher.forward方法在服务器端内部将请求转发给另外一个资源，浏览器只知道发出了请求并得到了响应结果，并不知道在服务器程序内部发生了转发行为。 
			RequestDispatcher.forward方法的调用者与被调用者之间共享相同的request对象和response对象，它们属于同一个访问请求和响应过程；而HttpServletResponse.sendRedirect方法调用者与被调用者使用各自的request对象和response对象，它们属于两个独立的访问请求和响应过程。 
	2.应用场景（参照图想）
		通常情况下都用请求转发，减少服务器压力
		当需要更新地址栏时用请求重定向，如注册成功后跳转到主页。
		当需要刷新更新操作时用请求重定向，如购物车付款的操作。
```



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


​    
​        给容器中注册组件总结
​            1.包括扫描+组件注解(@Controller/@Service/@Repository/@Component)
​            2.@Bean[导入第三包里面的组件]
​            3.@Import[快速给容器导入一个组件]
​                1.@Import(要导入到容器的组件),容器就会自动注册这个组件,id默认是全类名
​                2.ImportSelector:返回导入的组件的全类名数组(批量导入) 需要写一个类实现ImportSelector
​                3.ImportBeanDefinitionRegistrar: 手动注册bean到容器 需要写一个类实现ImportBeanDefinitionRegistrar
​            4.使用Spring提供的FactoryBean(工厂Bean): 需要写一个类实现FactoryBean 这个和第三方框架整合时,经常用到
​                getBean("colorFactoryBean")获取的是工厂返回的对象bean
​                getBean("&colorFactoryBean")获取的就是是工厂本身对象bean
​    
​    Bean的生命周期      
​        容器管理bean的生命周期
​            生命周期:bean创建--初始化---销毁的过程
​            我们可以自定义初始化和销毁方法,容器在bean进行到当前生命周期的时候来调用我们自定义的初始化和销毁方法
​        整个生命周期调用方法的流程
​            构造方法(对象创建)
​                单例:在容器启动的时候创建对象
​                多例:在每次获取的时候创建对象
​            BeanPostProcessor.postProcessBeforeInitialization
​            初始化方法:
​                对象创建完成,并赋值好,调用初始化方法
​            BeanPostProcessor.postProcessAfterInitialization
​            销毁方法
​                单例:在容器关闭的时候
​                多例:容器不会管理这个bean，容器不会调用销毁方法
​        整个生命周期调用方法的流程的操作
​            1.指定初始化和销毁方法
​                通过@Bean指定init-method="" destory-method=""
​            2.通过Bean实现InitializingBean接口(定义初始化逻辑) DisposableBean接口实现销毁逻辑
​            3.可以使用JSR250
​                @PostConstruct注解用于在bean创建完成并且属性赋值完成,来执行初始化方法（用在方法上）
​                @PreDestory注解用于容器销毁bean之前通知我们进行清理工作（用在方法上）
​            4.新建一个处理器实现 BeanPostProcessor,bean的后置处理器
​                在bean初始化前后进行一些处理工作
​                postProcessBeforeInitialization:在初始化之前工作
​                postProcessAfterInitialization:在初始化之后工作
​        BeanPostProcessor在Spring底层的使用
​            bean赋值,注入其他组件,@Autowired,生命周期注解功能,@Async,...等都是XxxBeanPostProcessor的使用
​            之后在学习的过程中只要对bean的一些注解,接口实现特殊功能，看看到底有没有对应的XxxBeanPostProcessor
​    
​    属性赋值
​        @Value
​            基本的数值
​                @Value("战三")
​                private String name;
​            可以写SpEl表达式, #{}
​                @Value("#{20-2}")
​                private Integer age;
​            可以 ${} 取出配置文件【properties】中的值(在运行环境变量里面的值) 可用@PropertySource配合
​                @Value("${person.nickName}")
​                private String nickName;
​        @PropertySource读取外部配置文件的k/v保存到运行的环境变量中;加载完外部的配置文件以后使用${}取出配置文件的值
​            spring容器有一个保存环境的组件,可取出来配置文件的配置信息
​        自动装配
​            自动装配：Spring利用依赖注入(DI)，完成对IOC容器中各组件的依赖关系赋值
​            1.@Autowired【是Spring定义的】
​                @Autowired 
​                    1.默认按照类型去容器找对应的组件:applicationContext.getBean(UserDao.class)
​                    2.如果找到多个相同类型的组件,再将属性的名称作为组件的id去容器中找
​                    3.使用@Qualifier指定需要装配的在组件id，而不使用属性名
​                    4.自动装配默认一定要将属性赋值好,没有就报错；
​                        可以使用@Autowired(required=false)；不是必须要装配的
​                    5.@Primary:让Spring进行自动装配的时候,默认使用首选的bean；
​                        也可以继续使用@Qualifier指定需要装配的bean的名字
​                @Qualifier 
​                    @Autowired(required=false)默认是true
​                    @Qualifier("personDao")
​                    private UserDao dao
​                @Primary
​                    @Primary
​                    @Bean("BookDao2")
​            2.Spring还支持使用@Resource(JSR250)和@Inject(JSR330)【是java规范的注解】
​                @Resource:默认是按照组件名称进行装配的；
​                    没有支持@Primary功能和@Autowired(required=false)功能
​                @Inject:
​                    需要导入javax.inject包和@Autowired的功能一样,但是required=false
​            3.@Autowired：构造器,参数,方法,属性;都是从容器中获取参数组件的值
​                可以标记在方法位置上；
​                    比如bean的setter方法上
​                    @Bean+方法参数；参数从容器中获取；默认不写@Autowired效果都是一样的,都能自动装配
​                可以标记在有参构造方法上,如果组件只有一个有参构造器,
​                    这个有参构造器的@Autowired可以省略,参数位置的组件还是可以自动从容器中获取
​                可以标记在方法的参数上
​            4.自定义组件想要使用Spring容器底层的一些组件(ApplicationContext, BeanFactory,xxx...等)
​                自定义组件实现XxxAware,在创建对象的时候,会自动调用接口规定的方法注入相关组件;
​                把Spring底层一些组件注入到自定义的Bean中
​                XxxAware:功能使用XxxProcessor后置处理器来实现的；
​                    ApplicationContextAware==>ApplicationContextAwareProcessor
​                还有 BeanNameAware，EmbeddedValueResolveWare,等等
​            5.@Profile: 指定组件在哪个环境下才能被注册到容器中,不指定,任何环境下都能注册这个组件
​                1.加了环境标识的bean，只有这个环境激活的时候才能注册到容器中。默认有一个default环境
​                2.写在配置类上只有是指定的环境的时候,整个配置类里面的所有配置才能开始生效、
​                3.没有标注环境标识的bean在,任何环境下都是加载的
​                激活方式    
​                    1.使用命令行动态参数激活 -Dspring-profiles.active=test
​                    2.代码方式
​                    //1.创建一个applicationContext
​                    AnnotationConfigApplicationContext app = new AnnotationConfigApplicationContext();
​                    //2.设置需要激活的环境
​                    app.getEnvironment().setActiveProfiles("test", "dev");
​                    //3.注册主配置类
​                    app.register(CustomConfigProp.class);
​                    //4.启动刷新容器
​                    app.refresh();
​                Spring为我们提供的可以根据当前环境,动态的激活和切换一系列组件的功能
​                开发环境,测试环境,生存环境
​                数据源:(/A)(/B)(/C)
​                @Profile("test")
​    AOP
​        1.需要导入spring-aspects包
​        2.将业务逻辑组件和切面类都加入容器,告诉Spring哪个是切面类@Aspect
​        3.在切面类上的每一个通知方法上标注通知注解,告诉Spring何时何地的运行(切入点表达式)
​        4.开启基于注解的aop模式 @EnableAspectJAutoProxy(配置类中加)，一般@Enable...都是开启什么配置的
​            前置通知(@Before)
​            后置通知(@AfterReturning)
​            异常通知(@AfterThrowing)
​            最终通知(@After)
​            绕通知(@Around)
​        例子:
​            @Aspect //告诉spring这是一个切面类
​            public class LogAspects {
​    
​                //抽取公共的切点表达式
​                //1.本类引用
​                //2.其他的切面引用
​                @Pointcut("execution(  public int com.zler.aop.MathCalculator.*(..))")
​                public void pointCut(){}
​    
​                @Before("pointCut()")
​                public void logStart(JoinPoint joinPoint){
​                    Object[] args = joinPoint.getArgs();
​                    String name = joinPoint.getSignature().getName();
​                    System.out.println(""+name+"运行...参数列表是:{"+ Arrays.asList(args)+"}");
​                }
​    
​                @After("com.zler.aop.LogAspects.pointCut()")
​                public void logEnd(JoinPoint joinPoint){
​                    System.out.println(""+joinPoint.getSignature().getName()+"结束");
​                }
​    
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


# Zooker
    分布式锁
    注册中心
    负载均衡

# Dubbo
    RPC调用框架