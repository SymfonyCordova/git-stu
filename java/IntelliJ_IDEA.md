# .vmoptions设置 64位16G内存开发大型程序才修改这些内存

```reStructuredText
-Xms128m  
-Xmx985m
-XX:ReservedCodeCacheSize=240m
-XX:+UseConcMarkSweepGC
-XX:SoftRefLRUPolicyMSPerMB=50
-ea
-XX:CICompilerCount=2
-Dsun.io.useCanonPrefixCache=false
-Djava.net.preferIPv4Stack=true
-Djdk.http.auth.tunneling.disabledSchemes=""
-XX:+HeapDumpOnOutOfMemoryError
-XX:-OmitStackTraceInFastThrow
-Djdk.attach.allowAttachSelf=true
-Dkotlinx.coroutines.debug=off
-Djdk.module.illegalAccess.silent=true
-Dawt.useSystemAAFontSettings=lcd
-Dsun.java2d.renderer=sun.java2d.marlin.MarlinRenderingEngine
-Dsun.tools.attach.tmp.only=true
-javaagent:/home/zler/jetbrains-agent-offline.jar
```

# 创建模块

```reStructuredText
1.在Eclipse中我们有Workspace(工作空间)和Project(工程)的概念，在IDEA中只有Project(工程)和Module(模块)的概念。这里的对应关系为
Eclise中的workspace 相当于 IDEA中的Project
Eclise中的Project	  相当于 IDEA中的Module
这个地方刚开始的时候会很容器理不清它们之间的关系。

2.先open module settings打开之后进行剪操作，然后再删除了
```

# 常用配置

```reStructuredText

```

# 快捷键eclipse

```reStructuredText
1.执行(run)	alt+r
2.提示补全	alt+/
3.单行注释	ctrl+/
4.多行注释	ctrl+shift+/
5.向下复制一行	ctrl+alt+down
6.删除一行或选中一行	ctrl+d
7.向下移动行	alt+down
8.向上移动行	alt+up
9.向下开始新的一行	shift+enter
10.向上开始新的一行	ctrl+shift+enter
11.如何查看源代码	ctrl+选中指定的结构 或 ctrl+shift+t
12.万能解错/生成返回值变量	alt+enter
13.退回到前一个编辑的页面	alt+left
14.进入到下一个编辑的页面	alt+right
15.查看继承关系	F4

16.格式化代码	ctrl+shift+F
17.提示方法参数类型	ctrl+alt+/
18.查看类的结构:类似于eclipse的outline ctrl+o
19.重构:修改变量名与方法名(rename)	alt+ctrl+r
20.大写转小写/小写转大写 ctrl+shift+y
21.生成构造/get/set/tostring alt+shift+s

22.查看文档说明	F2
23.收起所有方法	alt+shift+c
24.打开所有方法	alt+shift+x
25.打开代码所在硬盘文件夹	ctrl+shift+x
25.生成try-catch	alt+shift+z
26.局部变量抽取为成员变量	alt+shift+f
27.查找/替换(当前)	ctrl+f
28.查找(全局)	ctrl+h
29.查找文件	double shift
30.查找类的继承结构图	ctrl+shift+u
31.查看方法的多层重写结构	ctrl+alt+h
32.添加到收藏	ctrl+alt+f
33.抽取方法	alt+shift+m
34.打开最近修改的文件	ctrl+E
35.关闭当前打开的代码栏	ctrl+w

36.关闭打开所有代码栏	ctrl+shift+w
37.快速搜索类中的错误	ctrl+shift+q
38.选择要粘贴的内容 ctrl+shift+v
39.查找方法在哪里被调用	ctrl+shift+h
```

# 模板

```reStructuredText
Setting->Editor->Live Templates->iterations,other,output,plain

Setting->Editor->General->Postfix Completion

psvm

sout

list.for
ifn
prsf
```

# 创建Java Web Project 或 Module

1. 创建静态的Java Web

   New Module->Static Web

2. 创建动态的Java Web

   New Module->Java->JavaEE

3. 配置tomcat

   Run->Edit Configurations... -> + ->Tomcat Server->Local，选中下载的tomcat

# 关联数据库

Database

# 版本控制

```reStructuredText
设置 Settings->Version Control->git,github

克隆一个项目

    ​	VCS->Checkout from Version Control->github

    或

    ​	File->New->Project from Version Control->github

分享到仓库
	VCS->Import into Version Control->github->Share Project on GitHub\

查看本地历史
	Local History->Show History
```

# 断点调试

Settings->Build,Execution,Deployment->Debugger->Transport->Shared memory

```reStructuredText
step over 进入下一步,如果当前行断点是一个方法,则不进入当前方法体内
step into	进入下一步,如果当前行断点是一个方法,则进入当前方法体内
force step into	进入下一步,如果当前行断点是一个方法,则进入当前方法体内
step out 跳出
resume program 恢复程序运行，但如果该断点下面代码还有断点则停在下一个断点上
stop	停止
mute breakpoints	点中，使得所有的断点失效
view breakpoints	查看所有断点
```

# MAVEN设置

Settings->Build,Execution,Deployment->Build Tools

# 其他问题

```reStructuredText
1.javadoc
    Tools->Generate JavaDoc->Output directory,Local

    zh_CN,

    other command line arguments: -encoding UTF-8 charset UTF-8


2.缓存和索引的清理
	File->Invalidate Caches/Restart->Invalidate and Restart

3.取消更新
	Settings->Appearance & Behavior->System Settings->Updates

4.插件的使用
	官方插件库: https://plugins.jetbrains.com/
	Settings->Plugins
```

# 创建servlet

```reStructuredText
New->CreateNewServlet->取消Create JAVA EE 6 annotated class
```

# 快捷方式

```reStructuredText
1.查看类的继承体系 ctrl+h
```

https://download3.vmware.com/software/wkst/file/VMware-Workstation-Full-15.5.1-15018445.x86_64.bundle