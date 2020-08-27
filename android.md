# 学习地址

https://www.bilibili.com/video/BV12J411876t?from=search&seid=3437281578862326829

​	P17

# 介绍android

- android基础相关知识

  - android是什么?
    - android是一种机遇linux的开源的操作系统
    - 主要用于智能设备，如智能手机、平板
    - android与iOS区别 一个是开源 一个闭源

- android系统架构

  - linux内核层 包含了很多驱动

    - 显示驱动 蓝牙驱动 相机驱动 闪存驱动 进程间通信 usb驱动 键盘驱动 wifi驱动 音频驱动 电源驱动

  - 类库层和安卓运行时

    - 类库层

      - c和c++语言写的
      - surface manager 显示管理器
      - media framework多媒体框架
      - Sqlite 数据库
      - OpenGL|ES 3d图库
      - FreeType 字体
      - WebKit 浏览器内核
      - SGL
      - SSL 安全通信协议
      - libc c语言核心库

    - 安卓运行时

      - core libraries 核心jar包

      - dvm 安卓的jvm虚拟机

        - dvm基于寄存器，编译和运行都会更快

        - jam基于内存中的栈 编译和运行都会慢些

        - dvm:执行.dev格式的字节码 是对.class文件进行压缩产生的
        -  jvm执行.class字节码
        - dvm：一个应用启动一个虚拟机
        - jvm:  一个设备就开启一个虚拟机

  - 应用框架层

    - java语言写的
    - activity manager 界面 
    - window manager 窗口   相当于js的window
    - content providers 内容提供者
    - view system 相当于js的标签div
    - notification manager 通知栏
    - package manager  apk包管理
    - telephony manager 电话管理器
    - resource manager 资源管理 图标 图片
    - location manager 定位管理器
    - xmpp service 即使通讯协议

  - 应用层

    - home 主页
    - contacts 联系人
    - phone 电话
    - browser 浏览器 
    - 日历等等

# 第一个android应用

- 搭建开发环境
- 开发第一个应用

# 三个开发调试工具

- adb
- dams
- log