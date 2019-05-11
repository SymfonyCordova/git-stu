# linux介绍
    linux---堡垒机(公司)---跳转机
    linux安全 开源 免费 可靠
    并发量支持比windows好
    windows---比尔盖茨开发的
    linux内核---Linus Torvalds

# linux目录
    bin 存放二进制可执行文件
    sbin 存放二进制可执行文件,只有root才能访问
    etc 存放系统配置文件
    usr 用于存放共享的系统资源
    home 存放用户文件的根目录
    root 超级用户目录
    dev 用于存放设备文件
    lib 存放跟文件系统程序运行所需要的共享库
    mnt 系统管理员安装临时文件系统的安装点
    boot 存放用于系统引导时使用的各种文件
    tmp 用于存放各种临时文件
    var 用于存放运行时需要改变数据的文件

# rpm 和 yum
    windwos控制面板 添加/卸载程序
    进行程序的安装,更新,卸载,查看
    Setup.exe 

    rpm命令:相当于windows的添加/卸载程序
    进行程序的安装、更新、卸载、查看

    程序安装: rpm -ivh 程序名
    程序查看: rpm -qa
    程序卸载: rpm -e --nodeps 程序名

    yum命令:相当于可以联网的rpm命令
    相当于先联网下载程序安装包、程序的更新包
    自动执行rpm命令

# ubuntu .deb包安装方法
    dpkg -i package.deb 	    安装包
    dpkg -r package 	        删除包
    dpkg -P package 	        删除包（包括配置文件）
    dpkg -L package 	        列出与该包关联的文件
    dpkg -l package 	        显示该包的版本
    dpkg –unpack package.deb 	解开 deb 包的内容
    dpkg -S keyword 	        搜索所属的包内容
    dpkg -l 	                列出当前已安装的包
    dpkg -c package.deb 	    列出 deb 包的内容
    dpkg –configure package 	配置包

# google-chrome 正向代理
    sudo apt update
    sudo apt install shadowsocks
    vim /etc/shadowsocks.json
    {
        "server": "hk.d.cloudss.win",
        "server_port": 30984,
        "local_address": "127.0.0.1",
        "local_port": 1080,
        "password": "MENXIN520",
        "timeout": 300,
        "method":"rc4-md5",
        "fast_open": false
    }
    sudo sslocal -c /etc/shadowsocks.json -d start
    到chrome下载安装包安装
    chrome://version/查看配置信息
    google-chrome --proxy-server="socks5://127.0.0.1:1080"