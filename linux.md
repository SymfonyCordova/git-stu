# linux介绍
    linux---堡垒机(公司)---跳转机
    linux安全 开源 免费 可靠
    并发量支持比windows好
    windows---比尔盖茨开发的
    linux内核---Linus Torvalds

# 两种分区表和格式化
    1.分区
        MBR分区表: 最大支持2.1TB硬盘,最多支持4个分区
            主分区:最多只能有4个
            扩展分区:
                最多只能1个
                主分区加扩展分区最多4个
                不能写入数据,只能包含逻辑分区
            逻辑分区
        GPT分区表（全局唯一标示分区表）:GPT支持9.4ZB
        硬盘(1ZB=1024PB，1PB=1024EB，1EB=1024TB)。
        理论上支持的分区数没有限制,但windows限制128个主分区

    2.格式化(高级格式化)又称逻辑格式化
        为了写入文件系统
        它是指根据用户选定的文件系统(如FAT16,FAT32,NTFS,EXT2,EXT3,EXT4等),
        在磁盘的特定区域写入特定数据,在区域中划出一片用于存放文件分配表,目录表等用于文件管理的磁盘空间
    
    分区相当于一个柜子,格式化就是对分区进行分格子,会分一个小的和一个大的,然后在大的里面再一个一个分格子叫block(数据块,4kB)block不一定是连续的，系统会尽量连续,一个block是数据存储的最小单元
    
    每个文件都有一个节点号(INode 128B),在分得的小的格子存放了文件的Inode(inode号,权限,时间...)


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

## 网络配置
    1.配置ip地址和子网掩码
    编辑配置文件 ：
    >cd   /etc/sysconfig/network-scripts
    >cd   ifcfg-eth0    ./ifcfg-eth0.bak    //修改前先备份
    修改/etc/sysconfig/network-scripts/ifcfg-eth0 做网络的具体配置：
        DEVICE=eth0
        HWADDR=00:0C:29:EE:C7:1B
        TYPE=Ethernet
        UUID=0093d70b-1a03-4195-be15-d840614a776
        ONBOOT=no 
        MM_CONTROLLED=yes
        BOOTPROTO=dhcp
    对默认配置进行修改
        DEVICE=eth0
        HWADDR=00:0C:29:EE:C7:1B
        TYPE=Ethernet
        UUID=0093d70b-1a03-4195-be15-d840614a776
        ONBOOT=yes # 系统自动开启网络
        MM_CONTROLLED=yes 
        BOOTPROTO=static # 改为静态IP
        IPADDR=192.168.174.100 # IP和子网掩码具体配置
        NETMASK=255.255.255.0 # IP和子网掩码具体配置
        GATEWAY=192.168.174.2 # 网关，不设置网关是上不了网的
        DNS1=8.8.8.8
    重启网卡
        service network  restart/stop/start
    本机和linux互相ping通
        问题：本机可以ping同linux，但是linux不能ping通本机。
        解决：关闭本机防火墙