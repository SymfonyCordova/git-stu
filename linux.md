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
    
# 常用命令
    [root@localhost ~] #
        []: 这是体是符的分隔符号,没有特殊含义
        root: 显示的是当前的登陆用户
        @: 分隔符号,没有特殊含义
        localhost: 当前系统的简写主机名称
        ～: 代表用户当前所在的目录 在家目录
        #: 命令提示符。超级用户#，普通用户是$
    ctrl + L 清屏 
    table 补全名称  
    ctrl +ｃ退出来
    reboot 重启系统
    poweroff 关闭系统
    sync 数据同步命令,可以让暂时保存在内存中的数据同步到硬盘上
    shutdown -r now 重启系统 使用这个，在重启之前最好多执行几次sync
    hostname 查看主机名称
    ps -A 查看系统活跃进程
    du -h 目标 以K，M，G为单位显示目录或文件占据磁盘空间的大小(block块默认=4k)
    df -lh 查看系统分区情况
    kill -9 pid 杀死系统进程号的进程
    alias 显示命令的别名
    
    查看目录下有什么文件/目录
        ls      列出目录的文件信息
        ls -l   以“详细信息“查看目录文件
        ll      以“详细信息“查看目录文件
        ls -a   查看目录全部（包含隐藏文件）文件
        ls -al  查看目录全部（包含隐藏文件）文件,以“详细信息“展示
        ls 目录  查看指定目录下有什么文件
        ls -i   查看文件的i节点号   
        ls -lh  人性化显示
        ls -ld  显示目录本身

        第一列: 权限
        第二列: 引用计数. 文件的引用计数代表该文件的硬链接数个数,而目录的引用计数代表该目录有多少个一级子目录
        第三列: 所有者,也就是文件所属哪个用户
        第四列: 所属组,也就是文件所属哪个组织
        第五列: 文件大小 字节单位
        第六列: 文件的修改时间
        第七列: 文件名


    进行目录切换
        cd dirname 进行目录切换
        cd .. 向上级目录切换
        cd ~ 或 cd  直接切换到当前的对应的家目录
        cd - 进入上次所在目录

    创建目录
        mkdir 目录的名字
        mkdir -p newdir/newdir/newdir 递归方式创建多个连续目录
                                      新的多级目录数目如果大于等于2个，就要使用-p参数
        mkdir dir/newdir              不用-p参数
        mkdir -p dir/newdir/newdir    使用-p参数
        mkdir dir/newdir/dir/newdir

    删除文件或目录
        rm 文件
        rm -r  目录     -r[recursive递归]递归方式删除目录
        rm -rf 文件/目录 -r force 递归强制方式删除文件 force强制，不需要额外的提示
        rm -rf /
        这个删除是不能反悔的,所以再删除之前可以安装extundelete数据恢复软件

    创建文件
        touch dir1/filename 如果没有此文件,就创建文件,如果有此文件只是修改访问时间,不会修改文件内容的
        touch filename

    给文件追加内容
        echo 内容 > 文件名称   把”内容“以覆盖写方式追加给”文件“ 如果文件不存在会创建文件
        echo 内容 >> 文件名称  把”内容“以追加形式写给”文件“ 如果文件不存在会创建文件

    查看文件内容
        stat filename 显示文件或文件系统的详细信息 linux是没有文件创建时间
        cat filename 打印文件内容到输出终端
        cat -n filename 查看文件并显示行号
        cat -A filename[相当于-vET选项的整合]  查看文件并列出所有隐藏符号
        more filename 分屏显示文件 默认从第一行开始查看,不支持回看
            b:向上翻页
            空格:向下翻页
            回车键:向下滚动一行
            q:退出查看
            /字符串:搜索
        less filename 分行显示文件
            通过“上下左右”键查看文件的各个部分内容
            支持回看
            q 退出查看
        head -n filename 查看文件的头n行内容
        tail -n filename 查看文件的末尾n行内容
        tail -f filename 监听文件的新增内容
        wc filename 查看文件的行数

    硬链接
        ln -d 源文件 硬链接文件
        源文件和硬链接文件拥有相同的Inode和Block
        修改任意一个文件,另一个都改变
        删除任意一个文件,另一个都能使用
        硬链接标记不清,很难确认硬链接文件位置,不建议使用
        硬链接不能链接目录
        硬链接不能跨分区

    软链接
        ln -s 源文件 软链接文件 相当于快捷方式
        软链接和源文件拥有不同的Inode和Block
        两个文件修改任意一个,另一个都改变
        删除软链接,源文件不受影响，删除源文件,软链接不能使用
        软链接没有实际数据,只保存源文件的Inode,无论源文件多大,软链接大小不变
        软链接的权限是最大权限lrwxrwxrwx，但是由于没有实际数据,最终访问时需要参考源文件权限
        软链接可以链接目录
        软链接可以跨分区
        软链接特征明显,建议使用软链接
        软链接一定要写绝对路径
    
    文件的复制
        cp     file1  dir/newfile2     			file1被复制一份到dir并改名字为newfile2
        cp     file1  dir            			file1被复制一份到dir并改名字为原名字
        cp     dir1/filea    dir2/newfile       file1被复制一份到dir2并改名字为newfile

    目录的复制（需要设置-r[recursive递归]参数，目视目录层次）
        cp -r dir1 dir2            	     dir1被复制到dir2目录下，并改名字为原名
        cp -r dir1/dir2 dir3/newdir        dir2被复制到dir3目录下，并改名字为newdir
        cp -r dir1/dir2 dir3/dir4          dir2被复制到dir4目录下，并改名字为原名
        cp -r dir1/dir2 dir3/dir4/newdir   dir2被复制到dir4目录下，并改名字newdir
        cp -r dir1 ../../newdir         	 dir1被复制到上两级目录下，并改名字为newdir
        cp -a 相当于-dpr选项的集合. 目标文件和源文件一模一样
        cp -d 如果源文件为软链接(对硬链接无效),则复制出的目标文件也为软链接
        cp -i 询问,如果目标文件已经存在,则会询问是否覆盖
        cp -p 复制后目标文件保留源文件的属性(包括所有者，所属组、权限和时间)

    查看系统时间
        date
        date -s "2013-09-13 19:42:30" 给系统设置时间

    移动目录（文件和目录）剪切
        mv dir1 dir2           把dir1移动到dir2目录下
        mv dir1/dir2 dir3       把dir2移动到dir3目录下
        mv dir1/dir2 dir3/dir4  把dir2移动到dir4目录下
        mv dir1/dir2 ./         把dir2移动到当前目录下

    改名字（文件和目录）
        mv dir newdir                   修改dir1的名字为newdir
        mv dir1 ./newdir                dir1移动到当前目录下，并改名字为newdir
        mv dir1/dir2 dir3               dir1移动到dir3目录下，并改名字为“原名”  
        mv dir1/dir2 dir3/newdir        dir1移动到dir3目录下，并改名字为“newdir ”
        mv dir1/dir2 dir3/dir4          dir2移动到dir4目录下，并改名字为“原名	”
        mv dir1/dir2 dir3/dir4/newdir   dir2移动到dir4目录下，并改名字为“newdir"        

    给文件设置权限
        - --- --- ---
        文件类型 主人权限 同组权限 其他组权限
        linux文件类型
            -:代表普通文件
            b:块设备文件
            c:字符设备文件
            d:目录文件
            l:软链接文件
            p:管道符文件
            s:套接字文件
        权限 r(读) w(写) x(执行)
        字母相对方式设置权限
            +:增加权限 -:删除权限 =:设置权限
            u:主人权限 g:同组权限 o:其他组权限
            针对一个组别设置权限，其他组别没有变化,称为“相对方式”权限设置
            chmod u+rwx filename 给filename文件的主人增加"读 、写、执行"权限
            chmod g-rx  filename 给filename文件的同组用户 删除"读 、执行"权限
            chmod u+/-rwx,g+/-rwx,o+/-rwx filename
            说明：
                每个单元“+” "-"  只能使用一个
                可以同时给一个组或多个组设置权限，组别之间使用“,”分割
                每个单元的权限可以是rwx中的一个或多个
                chmod u+w,g-rx,o+rw filename 给filename文件主人增加权限，同组删除读 、执行权限，其他组增加读、写权限
                chmod u+w,u-x filename 给filename文件主任增加写权限，同时删除执行权限
                chmod u=rwx,g=r,o=w    不用关心文件的权限直接设置上权限
                chmod +/-rwx filename  无视具体组别，统一给全部的组设置权限
                chmod +rw filename     给filename全部用户增加读、写权限
        数字绝对方式设置权限
            r读:4 w写:2 x执行:1
            0:没有权限
            1:执行
            2:写
            3:写、执行
            4:读
            5:读、执行
            6:读、写
            7:读、写、执行
            chmod ABC filename ABC分别代表主人、同组、其他组用户的数字权限
            chmod 753 主人都、写 、执行 ，同组 都执行  其他组用户 写执行
            常用的数字权限 644 文件基本权限 755目录的基本权限 777最大权限
        问:字母相对 和数字绝对 方式权限设置取舍?
        答:修改的权限相对比较少的时候使用“字母方式” 相反，权限变得非常多的时候就使用“数字”方式

    用户操作
        配置文件：/etc/passwd
            用户名:密码:用户编号:组别编号:家目录:该用户执行的shell脚本
        创建用户
            useradd liming                     创建liming用户，同时会创建一个同名的组出来
            useradd -g  gid组别编号  username    把用户的组别设置好，避免创建同名的组出来
            useradd -g  gid组别编号  -u 用户编号  -d 家目录username     
        修改用户
            usermod   -g 组编号  -u  用户编号  -d 家目录  -l  新的名字    username
                (修改家目录时需要手动创建)
        删除用户
            userdel username
            userdel -r username 删除用户同时删除其家目录
        给用户 设置密码,使其登陆系统
            passwd 用户名

    组别操作
        配置文件: /etc/group
        创建组
            groupadd music
            groupadd movie
            groupadd php
        修改组
            groupmod -g gid -n 新名字 groupname
        删除组
            groupdel groupname 组下边如果有用户存在，就禁止删除

    修改文件和目录的所有者和所属组
        chown 主人 filename
            chown user1 abc 把文件abc所有者改为user1
        chown 主人.组别 filename
        chown 主人:组别 filename
            chown root.root bcd
            chown root:root bcd
        chown .组别 filename
        chown :组别 filename 
        chown -R  主人.组别   dir 通过递归方式设置目录的属性组信息
        chown -R  765  dir 通过递归方式设置目录的权限
        chgrp 修改文件和目录的所属组,这个一般不用
            chgrp user1 bcd 给文件bcd修改为user1组
        注意事项
            普通用户可以修改所有者是自己的文件的权限
            普通用户不能修改文件的所有者(哪怕文件是属于普用用户的,也不能送给别人)
            只有超级用户才能修改文件的所有者和所属组
    
    umask默认权限
        linux有6种基本权限 r,w,x,umask,...
        新建了一个文件就有了一个默认权限 保证文件和目录都有权限
        umask 可以查看到默认文件是系统设置好的
        系统针对文件新建默认的最大权限666,没有执行(x)权限,执行权限是有危险的
        系统针对目录新建默认的最大权限777,对于目录没有这个风险
        umask 033 是临时修改了默认权限,要想永久修改默认权限，必须修改配置文件
        umask 永久修改默认权限
            vi /etc/profile 这是环境变量配置文件 里面修改umask值
        umask默认权限计算方式:
            二进制进行逻辑与和逻辑非联合运算才得到新建文件和新建目录的默认权限
            但是这是计算机的计算方式,人类计算它太复杂了,我们可以按照字母来计算
            文件的默认权限最大只能是666，而umask的值是022
                -rw-rw-rw- 减去 -----w--w- 等于默认文件的权限 -rw-r--r--
            目录的默认权限最大可以是777，而umask的值是022
                drwxrwxrwx 减去 d----w--w- 等于默认目录的权限 drwx-r-xr-x
                减完是负的就是没有权限,因为没有负的权限

    帮助命令查看文档命令
        man 指令查看帮助手册 manual pages
            man ls
                上箭头:向上移动一行
                下箭头:向下移动一行
                PgUp:向上翻一页
                PgDn:向下翻一页
                g:移动到第一页
                G:移动到最后一页
                q: 退出
                /字符串:从当前页向下搜索字符串
                ?字符串:从当前页向上搜索字符串
                n:在搜索字符串时,可以使用n键找到下一个字符串
                N:在搜索字符串时,可以使用N键反向找字符串
            命令的帮助级别
                1:普通用户执行的系统命令和可执行文件的帮助
                2:内核可以调用的函数和工具的帮助
                3:c语言函数的帮助
                4:设备和特殊文件的帮助
                5:配置文件的帮助
                6:游戏的帮助(个人版的Linux中是有游戏的)
                7:杂项的帮助
                8:超级用户可以执行的系统命令的帮助
                9:内核的帮助
            man -f 命令 或者 whatis 查看命令拥有哪个级别的帮助
            man -k 命令 或者 apropos 查看和命令相关所有帮助 没什么用
        info 指令查看帮助信息是一套完整的资料
            info ls
                上箭头:向上移动一行
                下箭头:向下移动一行
                PgUp:向上翻一页
                PgDn:向下翻一页
                Tab:在有"*"符号的节点间进行切换
                回车:进入有"*"符号的子页面,查看详细帮助信息
                u:进入上一层信息(回车是进入下一层信息)
                n:进入下一小节信息
                p:进入上一小节信息
                ?:查看帮助信息
                q:退出info信息
        help 只能获取shell内置命令的帮助信息 基本不用
            什么是shell内置命令(shell自带的)
                type cd 显示 cd 是 shell 内建
            什么是外部命令(别人开发的)
                type mkdir 显示 mkdir 是 /bin/mkdir
        --help选项
            ls --help

    搜索
        whereis 搜索系统命令的命令,不能搜索普通文件，只能搜索系统命令
            会显示源文件和帮助文档
        which 搜索系统命令的命令,不能搜索普通文件，只能搜索系统命令
            如果这个命令存在别名,会显示这个命令的别名
        whoami 查看当前的用户是谁
        locate 按照文件名搜索普通文件
            优点: 按照数据库搜索,搜索速度快,消耗资源小。数据库位置/var/lib/mlocate/mlocate.db
            缺点: 只能按照文件名来搜索文件,而不能执行更复杂的搜索,比如按照权限,大小,修改,时间等搜索文件
        updatedb 更新数据库
            vim /etc/updatedb.conf 禁止了搜索一些
        find 文件查找
            find       查找目录    选项     选项值    选项     选项值
            1) -name选项 根据名字进行查找
            >find   / -name  passwd[完全名称] //“递归遍历”系统全部目录，寻找名称等于“passwd”文件
            >find   / -name "pas*"[模糊查找]   //在系统全部目录，模糊查找一个文件是“pas”开始的文件
            >find  /  -name  "*er*"     //文件名字出现"er"字样即可，不要位置
            2)限制查找的目录层级 -maxdepth   -mindepth
            -maxdepth  限制查找的最深目录
            -mindepth  限制查找的最浅目录
            >find / -name passwd -maxdepth 4
            >find / -maxdepth 4 -mindepth 3    -name passwd 
            3)根据大小为条件进行文件查找
            -size   +/-数字
            +号表示大小大于某个范围
            -号表示大小小于某个范围
            大小单位：
            -size 5   //单位是512字节  5*512字节
            -size 10c  //单位是“字节”   10字节
            -size  3k   //单位是“千字节” 3*1024字节
            -size  6M  //单位是 “1024*千字节 ” 6M兆字节
            > find ./  -size  14c    //在当前目录查找大小等于14字节的文件
            >find  / -size +500M    //在系统全部目录里边查找大小大于50M的文件
        pwd 查看完整的操作位置

    用户切换
        su - 或 su - root 向root用户切换
        exit 退回到原用户
        su 用户名 普通用户切换
            多次使用su指令，会造成用户的”叠加“：（su和exit 最好匹配使用）
            jinnan --->root--->jinnan  --->root--->jinnan

    图像界面与命令界面切换
        root用户可以切换
        init 3
        init 5

    查看一个指令对应的执行程序文件在哪
        whatis 指令是干什么的
        makewhatis 更新whatis数据库

    在文件中查找内容
        grep 被搜寻内容 文件
        grep hello passwd 在passwd文件中搜索hello内容 会把hello所在行的内容都打印到终端显示

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

P26