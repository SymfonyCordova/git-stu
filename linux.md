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

    设备文件名

    | 硬件  | 设备文件名 |
    | ---- | ---- |
    |IDE硬盘            | /dev/hd[a-d]     |
    |SCSI/SATA/USB硬件  | /dev/sd[a-p]     |
    |光驱               | /dev/cdrom或/dev/sr0 |
    |软盘               | /dev/fd[0-1] |
    |打印机(25针)       | /dev/lp[0-1]  |
    |打印机(USB)        | /dev/usb/lp[0-15] |
    |鼠标               |  /dev/mouse  |

    分区设备名称
        /dev/hda1(IDE硬盘接口)
        /dev/sda1(SCSI硬盘接口、SATA硬盘接口)

    挂载点(使用已经存在的空目录作为挂在点) 类似于windows的盘符
        理论上所有空目录,包括新建目录都可以作为挂载点,但是
        /bin,/lib,/etc要单独分出来

    挂载
        必须分区
            /(根分区)
            swap分区(交换分区) 注意前面没有/，就是swap是没有挂载点
                如果真实内存小于4GB,swap为内存的两倍
                如果真实内存大于4GB,swap为内存一致
                实验环境,不大于2GB
        推荐分区 （虽然是推荐分区,但是最好也分区）
            /boot (启动分区,1GB)
        常用分区
            /home （用于文件服务器）
            /www (用于web服务器)

    挂载类型 自动、手动
        类型：自动 手动。
        自动：系统安装创建的挂载点，后期使用会自动与硬盘分区建立联系。
        手动：系统运行过程中，临时添加的U盘，移动硬盘不会被系统应用起来，
        需要手动创建一个文件目录并使其与该硬件进行联系，挂载。

    与新硬件形成挂载
        把挂载点目录内部的旧的文件释放出去
        再进行挂载操作

    目录说明
        bin 存放系统命令的目录,普通用户和超级用户都可以执行.是/usr/bin/目录的软连接
        sbin 存放系统命令的目录,只有超级用户才可以执行. 是/usr/sbin/目录的软连接
        usr 用于存放共享的系统资源
            /usr/bin/ 存放系统命令的目录,普通用户和超级用户
            /usr/sbin/ 存放系统命令的目录,只有超级用户才可以执行.
            /usr/lib/ 应用程序调用的函数库位置
            /usr/local/ 手工安装的软件位置 记住
            /usr/share/ 应用程序的资源文件保存位置,如帮助文档,说明文档,和字体目录
            /usr/src/ 源码包保存位置,我们手工下载的源码包和内核源码包都可以保存这里,习惯上放到/usr/local/src 记住
            /usr/src/kernels/ 内核源码保存位置
        boot 系统启动目录,保存于系统启动相关的文件,如内核文件和启动引导程序
        dev 用于存放设备文件
            例如 /dev/cdrom是光驱
            /dev/skin 是第一块scsi硬盘
        etc 存放系统配置文件(采用默认安装方式rmp安葬)的服务配置文件全部保存在此目录中
            /etc/passwd 用于存储用户信息的文件
            /etc/group   用于存储组别信息文件
        home 存放用户文件的根目录
            用户的"家目录"
            给系统每增加一个”普通用户“的同时，都会在该目录为该用户设置一个文件夹目录
            代表该用户的“家目录”，用户后期使用系统的时候会首选进入其家目录
            家目录名字默认与当前用户名字一致
            用户对家目录拥有绝对最高的权限
            波浪线代表用户处于自己的家目录
        lib 系统调用函数库保存位置。是/usr/lib/的软连接
        lib64 64位系统调用函数库保存位置。是/usr/lib64/的软连接
        lost+found 当系统意外崩溃或意外关机,而产生一些文件碎片存放在这里。当系统启动的过程中fask工具会检查这里,并修复已经损坏的文件系统
        media 挂载目录。系统建议是用来挂载媒体设备的,如软盘和关盘
        misc 挂载目录
        mnt 挂载目录 U盘 习惯上用这个
        opt 该目录类似win系统的c:/Program files目录
            该目录经常用于安装各种软件
            一般习惯安装到/usr/local/
        proc 内存映射目录，该目录可以查看系统的相关硬件信息
            比如 cat cpuinfo 能看到cpu的信号
        sys 虚拟文件系统 和proc目录相似,该目录的数据都保存在内存中,主要保存与内核相关的信息
        net 内存的挂载点 和proc，sys一样
        root 超级用户目录
        selinux 安装增强型的linux
            对系统形成保护
            会对给系统的安装软件时有干扰
            限制root的权限
        srv 服务数据目录
        tmp 用于存放各种临时文件
        var 动态数据保存位置 可变的、易变的
            该目录存储的文件经常会发生变动（增加、修改、删除)
            经常用于部署项目程序文件
            /var/www/html RPM包安装的Apache的网页主目录
            /var/lib/ 程序运行中需要调用或改变的数据保存位置 如：mysql的数据库保存在/var/lib/mysql目录中
            /var/log/ 系统日志保存位置
            /var/run/ 一些服务和程序运行后,它们的PID保存位置。如 /run/目录的软链接
            /var/spool/ 放置队列数据的目录。就是排队等待其他程序使用的数据,比如邮件队列和打印队列
            /var/spool/mail/ 新收到的邮件队列保存位置。系统新收到的邮件会保存在此目录中
            /var/spool/cron/ 系统的定时任务队列保存位置。系统的计划任务会保存在这里
        /run 是各种各样数据的家园

    ext4 
        类似于win系统的FAT32和NTFS类型
        给/boot目录单独创建一个分区结构，对其形成保护，避免其他的文件占据该目录空间
        影响服务器的开关机。

# 网络配置
    对于redhat的系统,一开始没有vim 那么使用setup命令
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
        GATEWAY=192.168.174.2 # 网关，不设置网关是上不了网的 虚拟机虚拟网卡是192.168.174.1
        DNS1=8.8.8.8
    重启网卡
        service network  restart/stop/start
    本机和linux互相ping通
        问题：本机可以ping同linux，但是linux不能ping通本机。
        解决：关闭本机防火墙
    
如果是虚拟机安装的,还需要配置虚拟机的网络配置    

| 连接方式     | 连接网卡     | 是否能连接本机      | 是否能连接局域网     | 是否能连接公网     |
| ---- | ---- | ---- | ---- | ---- |
| 桥接     | 本地真实网卡     | 可以     | 可以     | 可以     |
| NAT     | VMnet8     | 可以     | 不能     | 可以     |
| 仅主机     | VMnet1     | 可以     | 不能     | 不能     |

NAT不会占用真实的ip

# 远程工具
    xshell 个人用户免费版
    secureCRT
    putty 比较古老
    winscp 上传文件

# 注意事项
    linux严格区分大小写
    linux一切皆文件
    linux不靠扩展名区分文件类型,建议写上
    linux中所有的存储设备都必须在挂载之后才能使用

    服务器不能关机只能重启,重启之前终止正在执行的服务
        sync 数据同步命令,可以让暂时保存在内存中的数据同步到硬盘上
        shutdown -r now 重启系统 使用这个，在重启之前最好多执行几次sync
    不要在服务器访问高峰运行高负载命令
    远程配置防火墙不要把自己踢出服务器
        防火墙: 基本功能是数据包过滤(IP地址,MAC地址,端口号,协议类型,数据包中数据)
        先写一个系统定时任务,让它每5分钟清空一下防火墙规则,就算写错了也还有反悔的机会,等测试没有问题了再删除这个系统定时任务

# 用户和组的操作
    linux 系统对用户、组别、被操作的文件有独特的设置
    用户与组别对应、组别与被操作的文件对应
    后期系统使用过程中管理员root就需要关系用户是属于哪个组别的即可
    无需关系用户具体操作说明文件
    用户名:密码:用户编号:组别编号:家目录:该用户执行的shell脚本

# 常用命令
    cat -n install.log 查看文件并显示行号
    ctrl + L 清屏 
    table补全名称  
    ctrl +ｃ退出来
    reboot 重启系统
    poweroff 关闭系统
    sync 数据同步命令,可以让暂时保存在内存中的数据同步到硬盘上
    shutdown -r now 重启系统 使用这个，在重启之前最好多执行几次sync
    
    查看目录下有什么文件/目录
        ls      //list列出目录的文件信息
        ls -l 或 ll     //list -list以“详细信息“查看目录文件
        ls -a   //list -all 查看目录全部（包含隐藏文件）文件
        ls -al  //list -all list 查看目录全部（包含隐藏文件）文件,以“详细信息“展示
        ls 目录     //查看指定目录下有什么文件
        ls -i   //查看文件索引号码

    进行目录切换
        cd dirname     //进行目录切换
        cd ..   // 向上级目录切换
        cd ~ 或 cd  //直接切换到当前的对应的家目录

    查看完整的操作位置
        pwd

    用户切换
        su - 或 su - root   //向root用户切换
        exit    //退回到原用户
        su 用户名   //普通用户切换
        多次使用su指令，会造成用户的”叠加“：（su和exit 最好匹配使用）
        jinnan --->root--->jinnan  --->root--->jinnan  

    查看当前的用户是谁
        whoami

    图像界面与命令界面切换
        root用户可以切换
        init 3
        init 5

    查看一个指令对应的执行程序文件在哪
        which 指令

    目录相关操作
        创建目录  make directory
            mkdir 目录的名字
            mkdir -p  newdir/newdir/newdir                   //递归方式创建多个连续目录
            //新的多级目录数目如果大于等于2个，就要使用-p参数
            mkdir          dir/newdir                 //不用-p参数
            mkdir   -p   dir/newdir/newdir     //使用-p参数
            mkdir          dir/newdir/dir/newdir
        移动目录（文件和目录） move
            mv    dir1    dir2      //把dir1移动到dir2目录下
            mv    dir1/dir2   dir3  //把dir2移动到dir3目录下
            mv    dir1/dir2   dir3/dir4  //把dir2移动到dir4目录下
            mv    dir1/dir2   ./  //把dir2移动到当前目录下
        改名字（文件和目录）
            mv    dir  newdir     //修改dir1的名字为newdir
            mv是“移动”和“改名字”合并的指令
            mv     dir1	 ./newdir                   //dir1移动到当前目录下，并改名字为newdir
            mv     dir1/dir2	 dir3                  //dir1移动到dir3目录下，并改名字为“原名”
            mv     dir1/dir2	 dir3/newdir     //dir1移动到dir3目录下，并改名字为“newdir ”
            mv     dir1/dir2	 dir3/dir4          //dir2移动到dir4目录下，并改名字为“原名	”
            mv     dir1/dir2	 dir3/dir4/newdir   //dir2移动到dir4目录下，并改名字为“newdir"
        复制 （文件和目录）copy
            文件的复制
                cp     file1  dir/newfile2     			//file1被复制一份到dir并改名字为newfile2
                cp     file1  dir            			//file1被复制一份到dir并改名字为原名字
                cp     dir1/filea    dir2/newfile       //file1被复制一份到dir2并改名字为newfile
            目录的复制（需要设置-r[recursive递归]参数，目视目录层次）
                cp  -r   dir1    dir2            	//dir1被复制到dir2目录下，并改名字为原名
                cp  -r   dir1/dir2    dir3/newdir   //dir2被复制到dir3目录下，并改名字为newdir
                cp  -r   dir1/dir2    dir3/dir4          	//dir2被复制到dir4目录下，并改名字为原名
                cp  -r   dir1/dir2    dir3/dir4/newdir    //dir2被复制到dir4目录下，并改名字newdir
                cp  -r   dir1   ../../newdir         	//dir1被复制到上两级目录下，并改名字为newdir
        删除（文件和目录）remove
            rm    文件
            rm   -r  目录            //-r[recursive递归]递归方式删除目录
            rm   -rf   文件/目录     //-r force 递归强制方式删除文件 force强制，不需要额外的提示
            rm   -rf     /

    文件操作
        查看文件内容
            cat         filename       //打印文件内容到输出终端
            more      filename      //通过敲回车方式逐行查看文件的各个行
                //默认从第一行开始查看
                //不支持回看
                //q  退出查看
            less				//通过“上下左右”键查看文件的各个部分内容
                //支持回看
                //q 退出查看
            head  -n     filename             //查看文件的前n行内容
            tail     -n	   filename            //查看文件的末尾n行内容
            wc					//查看文件的行数`
        创建文件
            touch    dir1/filename
            touch    filename
        给文件追加内容
            echo 内容   >   文件名称   //把”内容“以覆盖写方式追加给”文件“ 
            echo 内容   >>   文件名称   //把”内容“以追加形式写给”文件“
            （如果文件不存在会创建文件）

    用户操作
        配置文件：/etc/passwd
        创建用户   user   add
            useradd
            useradd    liming                      //创建liming用户，同时会创建一个同名的组出来
            useradd    -g  gid组别编号  username     // 把用户的组别设置好，避免创建同名的组出来
            useradd    -g  gid组别编号  -u 用户编号  -d 家目录username     
        修改用户    user  modify
            usermod   -g 组编号  -u  用户编号  -d 家目录  -l  新的名字    username
                (修改家目录时需要手动创建)
        删除用户    user delete
            userdel   username
            userdel   -r   username    //删除用户同时删除其家目录
        给用户 设置密码,使其登陆系统
            passwd  用户名

    组别操作
        配置文件: /etc/group
        创建组 group add
            groupadd    music
            groupadd    movie
            groupadd    php
        修改组      group modify
            groupmod -g gid  -n 新名字  groupname
        删除组      group delete
            groupdel   groupname   //组下边如果有用户存在，就禁止删除

    查看指令可设置的参数
        man 指令

    给文件设置权限 + 增加权限  - 删除权限
        字母相对方式设置权限
            //针对一个组别设置权限，其他组别没有变化,称为“相对方式”权限设置
            chmod 指令
            chmod  u+rwx   filename //给filename文件的主人增加"读 、写、执行"权限
            chmod   g-rx      filename  //给filename文件的同组用户 删除"读 、执行"权限

            chmod  u+/-rwx,g+/-rwx,o+/-rwx filename
            说明：
                每个单元“+” "-"  只能使用一个
                可以同时给一个组或多个组设置权限，组别之间使用“,”分割
                每个单元的权限可以是rwx中的一个或多个
                chmod  u+w,g-rx,o+rw  filename   //给filename文件主人增加权限，同组删除读 、执行权限，其他组增加读、写权限
                chmod u+w,u-x  filename    //给filename文件主任增加写权限，同时删除执行权限

                chmod +/-rwx   filename   //无视具体组别，统一给全部的组设置权限
                chmod +rw   filename     //给filename全部用户增加读、写权限

        数字绝对方式设置权限
            r读 :4       w写 ：2      x执行：1
            0：没有权限
            1 : 执行
            2：写
            3：写 、执行
            4 :  读
            5： 读、执行
            6 :  读、写
            7 :  读、写、执行

            chmod  ABC filename   // ABC分别代表主人、同组、其他组用户的数字权限
            chmod   753  //主人都、写 、执行 ，同组 都执行  其他组用户 写执行

        问：字母相对 和数字绝对 方式权限设置取舍？
        答：修改的权限相对比较少的时候使用“字母方式” 相反，权限变得非常多的时候就使用“数字”方式

    在文件中查找内容
        grep  被搜寻内容      文件
        grep  hello    passwd    //在passwd文件中搜索hello内容 会把hello所在行的内容都打印到终端显示
    
    ps -A 查看系统活跃进程
    du -h 目标 以K，M，G为单位显示目录或文件占据磁盘空间的大小(block块默认=4k)
    date -s "2013-09-13 19:42:30" 给系统设置时间
    date 查看系统时间
    df -lh 查看系统分区情况
    kill -9 pid 杀死系统进程号的进程

# rpm 和 yum

    windwos控制面板 添加/卸载程序
    进行程序的安装,更新,卸载,查看
    Setup.exe 
    
    rpm命令:相当于windows的添加/卸载程序
    进行程序的安装、更新、卸载、查看
    
    程序安装: rpm -ivh 程序名
    程序查看: rpm -qa
    查看软件是否有安装： rpm -g 软件包名（完整）
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

P20