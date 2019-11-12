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
    配置ip地址和子网掩码
    编辑配置文件 ：
    cd /etc/sysconfig/network-scripts
    cp ifcfg-eth0 ./ifcfg-eth0.bak  修改前先备份
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
    复制镜像可能需要重置UUID
        vi /etc/sysconfig/network-scripts/ifcfg-eth0
            删除MAC地址行
        rm -rf /etc/udev/rules.d/70-persistent-net.rules
            删除MAC地址和UUID绑定文件
        shutdown -r now
            重启服务器

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
        od 打开二进制文件
            -tc
        du -h 目标 以K，M，G为单位显示目录或文件占据磁盘空间的大小(block块默认=4k)
        df -lh 查看系统分区情况

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
        用户相关文件/etc/passwd
            root:  x:    0:   0:  root:  /root:     /bin/bash
            games: x:    5:   60:  games:/usr/games:/usr/sbin/nologin
            用户名:密码:用户ID:组ID:用户说明:家目录:该用户执行的shell脚本
            用户ID:
                0 超级用户UID.如果用户UID为0,代表这个账号是管理员账号
                    那Linux如何把普通用户升级成为管理员呢?就是把其他用户的UID修改为0就可以了,这点和Windows是不同的.
                1-499 系统用户(伪账号)UID.这些UID账号是系统保留给系统系统账户的UID
                    也就是说UID是1-499范围内的用户是不能登陆系统的,而是用来运行系统或服务的.其中1-99是系统保留的账号,
                    系统自动创建.100-499是预留给用户系统创建系统账号的
                500-65535 普通用户ID.建立的普通用户UID从500开始,最大到65535.
                    这些用户足够使用了,但是如果不够也不用害怕,2.6.x内核以后的Linux系统用户UID已经可以支持2的32次方这么多了
        影子文件/etc/shadow
            root:*:17960:0:99999:7:::
            用户名:加密密码:密码最近更改时间:两次密码的修改间隔时间:密码有效期:密码修改到期前的警告天数:密码过期后的宽限天数:
                密码失效时间:保留
            加密密码:我们也可以在密码前人为的加入!或*改变加密值让密码暂时生效,使用这个用户无法登陆,达到暂时禁止用户的目的
                注意所有伪用户的密码都是!!或*,代表没有密码是不能登陆的.当然我新创建的用户如果不设定密码,它的密码也是!!,
                代表这个用户没有密码,不能登陆
            密码最近更改时间:
                date -d "1970-01-01 15775 days"
                2013年03月11日星期一 00:00:00 CST
                echo $(($(date --date="2013/03/11" +%s)/86400 +1))    
        用户组信息文件/etc/group
            root:x:0:root
            组名:组密码位:GID:此组中支持的其他用户.附加组是此组的用户
            初始组:每个用户初始组只能有一个,初始组只能有一个,一般都是和用户名相同的组作为初始组
            附加组:每个用户可以属于多个附加组.要把用户加入组,都是加入附加组
        组密码文件/etc/gshadow
            如果我给用户组设定了组管理员,并给该用户组设定了组密码,组密码就保存在这个文件当中.
            组管理员就可以利用这个密码管理这个用户组了.
        用户邮箱目录
            /var/spool/mail
        用户模板目录
            /etc/skel/
        创建用户
            手动添加用户
                /etc/passwd
                /etc/shadow
                /etc/group
                /etc/gshadow
                /home/user1
                /var/spool/mail/user1
            useradd 选项 用户名
                -u 550 指定UID
                -g 组名 指定初始组,不要手工指定
                -G 组名 指定附加组,把用户加入组,使用附加组
                -c 说明 添加说明
                -d 目录 手工指定家目录,目录不需要事先建立
                -s shell /bin/bash
            useradd默认值
                useradd添加用户时参考的默认值文件主要有两个,分别是/etc/default/useradd和/etc/login.defs
        设定密码
            passwd 用户名
                -l:暂时锁定用户
                -u:解锁用户
                --stdin:可以将通过管道符输出的数据作为用户密码.主要在批量添加用户时使用
            passwd直接回车代表修改当前用户的密码
            echo "123" | passwd --stdin lamp可以使用字符串作为密码不需要人机交互
            可以通过命令,把密码修改日期归零(shadow第三字段),这样用户一登陆就要修改密码
            change -d 0 lamp
        修改用户
            usermod
                -u 用户编号: 修改用户的UID
                -d 家目录: 修改用户的家目录.家目录必须写绝对路径
                -c 用户说明: 修改用户的说明信息,就是/etc/passwd文件的第五个字段
                -g 组名: 修改用户的初始组,就是/etc/passwd文件的第四个字段
                -G 组名: 修改用户的附加组,其实就是把用户加入其他组用户,常用这个
                -s shell: 修改用户的登陆shell.默认时/bin/bash
                -e 日期: 修改用户的失效日期,格式为"YYYY-MM-DD",也就是/etc/shadow文件的第八个字段
                -L: 临时锁定用户
                -U: 解锁用户
            改名usermod -l 新名 旧名,但是不建议,可以删除旧用户,再建立新用户
        删除用户同时删除其家目录
            userdel username
            userdel -r username 删除用户同时删除其家目录
        切换用户身份
            su 用户名
                -:选项只使用-代表连带用户的环境变量一起切换
                -c 命令:仅执行一次命令,而不切换用户身份

    组管理操作
        配置文件: /etc/group
        创建组
            groupadd music
            groupadd movie
            groupadd php
        修改组
            groupmod -g gid -n 新名字 groupname
        删除组
            groupdel groupname 组下边如果有用户存在，就禁止删除
        把用户加进组或从组中删除
            gpasswd 组名
                -a 用户名:把用户加入组,其实就是把用户加入其他组用户
                -d 用户名:把用户从组中删除
            比usermod好用
        
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
        whatis 指令是干什么的
        makewhatis 更新whatis数据库
        find 在目录中搜索文件
            按照文件名搜索
                -name 按照文件名搜索
                    find / -name passwd[完全名称] “递归遍历”系统全部目录，寻找名称等于“passwd”文件
                    find / -name "pas*"[模糊查找] 在系统全部目录，模糊查找一个文件是“pas”开始的文件
                    find / -name "*er*"  文件名字出现"er"字样即可，不要位置
                -iname 按照文件名搜索，不区分文件名大小写
                -inum  按照inode号搜索
                可以使用通配符
            限制查找的目录层级
                -maxdepth  限制查找的最深目录
                -mindepth  限制查找的最浅目录
                find / -name passwd -maxdepth 4
                find / -maxdepth 4 -mindepth 3 -name passwd 
            按照文件大小为条件进行文件查找
                -size   +/-数字
                +号表示大小大于某个范围
                -号表示大小小于某个范围
                大小单位：
                -size 5   默认单位是512字节  5*512字节
                -size 10c 单位是“字节”   10字节
                -size 3k  单位是“千字节” 3*1024字节
                -size 6M  单位是 “1024*千字节 ” 6M兆字节
                find ./  -size  14c 在当前目录查找大小等于14字节的文件
                find  / -size +500M 在系统全部目录里边查找大小大于50M的文件
            按照文件的修改时间来搜索
                -atime [+|-]时间: 按照文件访问时间搜索
                -mtime [+|-]时间: 按照文件数据修改时间搜索
                -ctime [+|-]时间: 按照文件状态修改时间搜索
                -5: 代表5天内修改的文件
                 5: 代表前5～6天那一天修改的文件
                +5: 代表6天前修改的文件
            按照权限搜索
                -perm  权限模式: 查找文件权限刚好等于权限模式的文件
                -perm -权限模式: 查找文件权限全部包含权限模式的文件
                -perm +权限模式: 查找文件权限全部包含权限模式任意一个权限的文件
            按照所有者和所属组搜索
                -uid 用户ID:  按照用户ID查找所有者是指定ID的文件
                -gid 组ID:   按照用户组ID查找所属组是指定ID的文件
                -user 用户名: 按照用户名查找所有者是指定用户的文件
                -group 组名:  按照组名查找所属组是指定用户组的文件
                -nouser:     查找没有所有者的文件
                按照所有者和所属组搜索时,"-nouser"选项比较常用,主要用于查找垃圾文件
                只有一种情况例外，那就是外来文件。比如光盘和U盘中的文件如果是windows复制的,
                在Linux中查看就是没有所有者的文件;再比如手工源码包安装的文件,也可能没有所有者
            按照文件类型搜索
                -type d: 查找目录
                -type f: 查找普通文件
                -type l: 查找软链接文件
            逻辑运算
                -a: and 与
                -o: or 或
                -not: not 非
                find 目录 条件 逻辑运算符 条件
                find . -size +1k -a -type f
                find . -size +1k -o -type f
                find . -not -name cangls
            其他选项
                -exec
                -ok
        grep 在文件中搜索符合条件的字符串
            grep "搜索内容" 文件名
            -i 忽略大小写
            -n 输出行号
            -v 取反
            --color=auto 搜索出的关键字用颜色显示
            搜索的内容可以使用正则表达式
    
    管道符
        命令1 | 命令2
        命令1的正确输出作为命令2的操作符号
            ll -a /etc/ | more
            将ll -a /etc/的输出想象是一个临时文件,然后使用more来查看
            ll /etc | grep yum 只要是管道符那么命令1的输出是字符串,命令2要将命令1的内容当作字符串来处理
            统计正在链接的网络链接数量 netstat -an | grep ESTABLISHED | wc -l
        其中的许多指令（grep head tail wc ls 等等）都可以当做管道符号使用。
        ls -l | wc 计算当前目录一共有多少文件
        grep sbin passwd | wc 计算passwd 文件中出现sbin内容的行数
        is -l | head -20 | tail -5 查看当前目录中第16-20个文件信息

    别名
        alias 显示设置命令的别名 照顾管理员的习惯 别名的优先级大于系统的命令
        alias ser='service network restart'
        alias 临时生效的,要向永久生效,需要写如环境变量配置文件~/.bashrc

    快捷键
        table 补全名称
        ctrl + A 把光标移动到命令行的开头
        ctrl + E 把光标移动到命令行的结尾
        ctrl + C 强制终止当前命令
        ctrl + L 清屏
        ctrl + U 删除或剪切光标之前的命令。
        ctrl + Y 粘贴ctrl + U剪切的内容
        ctrl + B 向左
        ctrl + F 向右
        history 历史操作列表
        history -c 清除历史命令
        ctrl + P 向上切换历史操作命令
        ctrl + N 向下切换历史操作命令
        ctrl + H 删除光标前面的字符  backspace  
        ctrl + D 删除光标后面的字符(光标盖住的字符)

    压缩
        zip:
            压缩
                zip 生成压缩包的名字 压缩的文件
                zip 生成压缩包的名字 -r 压缩的目录(-r递归操作)
                zip zna.zip anaconda-ks.cfg
                zip zna.zip -r aa
            解压缩
                unzip 压缩包的名字 默认解压到当前目录
                unzip 压缩包的名字 -d　指定解压目录
                uzip ana.zip -d /tmp/
        gz:
            压缩
                gzip 源文件 会删除源文件
                -c: 将压缩数据输出到标准输出中,可以用于保留源文件
                -r: 压缩目录下的文件,但是不会对这个目录进行压缩,也就是不会打包
                gzip -c abc >> abc.gz 这样是可以保留源文件的,默认是不保留源文件
                gzip -r abc
            解压缩
                gzip -d
                gunzip
        bz2:
            压缩
                bzip2 源文件 不能压缩目录
                -k: 压缩时,保留源文件
                -v: 显示压缩的详细文件
            解压缩
                bzip2 -d: 解压缩
                bunzip2 压缩包的名字
        tar 不使用z/j参数, 该命令只能对文件或目录打包
            -j:	使用bzip2方式压缩文件
            -z: 使用gzip方式压缩文件
            -c: 创建,压缩,打包
            -x:	释放,解压缩,解打包
            -t: 只是查看包，不解压缩
            -f: 指定压缩文件的名字
            -v:	显示提示信息 压缩解压缩 可以省略
            压缩
                打包不压缩: tar -cvf test.tar 123 abc bcd
                打包压缩bzip2: tar -jcvf 生成压缩包的名字(xxx.tar.bz2)　要压缩的文件或目录
                打包压缩gzip: tar -zcvf 生成压缩包的名字(xxx.tar.gz)　 要压缩的文件或目录    　
            解压缩
                解压bzip2: tar -jxvf  xxx.tar.bz2要压缩的名字(默认解压到当前目录)
                解压gzip:  tar -zxvf  xxx.tar.gz压缩包名字　-C 压缩的目录
            注意包的后缀名
        rar 必须手动安装该软件(sudo apt install rar)
            -a: 压缩
            x: 解压缩
            压缩
                rar a 生成的压缩文件的名字（temp）　压缩的文件或者目录
            解压缩
                rar x　压缩文件名　(解压缩目录)
    
    关机和重启
        sync 数据同步命令
            刷新文件系统缓冲区
            可以让暂时保存在内存中的数据同步到硬盘上
        shutdown
            -c: 取消已经执行的shutdown命令
            -h: 关机
            -r: 重启
            后面可以跟一个时间
            shutdown -r 05:30
            shutdown -r now 重启系统 使用这个，在重启之前最好多执行几次sync
        reboot 重启系统
            现在reboot是安全的,但是还是使用shutdown
        poweroff 关闭系统 
            不会正确保存的正在使用的数据 不建议使用
        halt 关闭系统 
            不会正确保存的正在使用的数据 不建议使用
        init 3
        init 5
        init 0
        hostname 查看主机名称
        ps -A 查看系统活跃进程
        kill -9 pid 杀死系统进程号的进程
        pwd 查看完整的操作位置

    网络
        配置IP地址 参考网络配置
        ifconfig 查看IP信息
            enp1s0: flags=4163<UP,BROADCAST,RUNNING,MULTICAST>  mtu 1500
            #标志                                               最大传输单元
            inet 10.0.11.147  netmask 255.255.254.0  broadcast 10.0.11.255
            #IP地址            子网掩码                广播地址
            inet6 fe80::1a86:574f:5df2:d134  prefixlen 64  scopeid 0x20<link>
            #IPv6地址(目前没有生效)
            ether 98:e7:f4:f3:e6:3c  txqueuelen 1000  (以太网)
            #MAC地址
            RX packets 85705  bytes 84865698 (84.8 MB)
            RX errors 0  dropped 0  overruns 0  frame 0
            #接收的数据包情况
            TX packets 44099  bytes 6132250 (6.1 MB)
            TX errors 0  dropped 0 overruns 0  carrier 0  collisions 0
            #发送的数据包情况
        ping 刺探网络
            -b: 后面加入广播地址,用于对整个网段进行刺探
            -c 次数: 用于指定ping的次数
            -s 字节: 指定刺探包的大小
            ping -b -c 4 10.0.11.255 用于探测局域网上有多少台电脑
        netstat
            -a: 列出所有网络状态,包括Socket程序
            -c: 指出每隔几秒刷新一次网络状态
            -n: 地使用IP址和端口号显示,不使用域名与服务名
            -p: 显示PID和程序名
            -t: 显示使用TCP协议端口的链接状态
            -u: 显示使用UDP协议端口的链接状态
            -l: 仅显示监听状态的链接
            -r: 显示路由表
            netstat -tuln 查询本机所有开启端口
                Proto: 网络链接协议,一般就是TCP协议和UDP协议
                Recv-Q: 表示接收到的数据,已经在本地的缓冲中,但是还没有被进程取走
                Send-Q: 表示从本机发送,对方还没有收到的数据,依然在本地的缓冲中,一般是不具备ACK标志包的数据包
                Local Address: 本机IP地址和端口号
                Foreign Address: 远程主机的IP地址和端口号
                State: 状态
                    LISTEN: 监听状态,只有TCP协议需要监听,而UDP协议不需要监听
                    ESTABLISHED: 已经建立链接状态。如果使用-l选项,则看不到已经建立链接的状态
                    SYN_SENT: SYN发起包,就是主动发起链接的数据包
                    SYN_RECV: 接收到主动链接的数据包
                    FIN_WAIT1: 正在中断的链接
                    FIN_WAIT2: 已经中断的链接,但是正在等待对方主机确认
                    TIME_WAIT: 链接已经中断,但是套接字依然在网络中等待结束
            netstat -tulnp 查看到是哪个程序占用了端口,并且可以知道这个程序的PID
            netstat -an 查看所有
            netstat -rn 查网关
        write 向指定的登陆的用户发送信息
            write 用户名 终端号
            write user1 pts/1
            hello
            I will be in 5 mintues to restart, please save your data
            向在pts/1(远程终端1)登陆的user1用户发送信息,使用Ctrl+D快捷键保存发送的数据
        wall 向所有的登陆的用户发送信息
            wall "I will be in 5 mintues to restart, please save your data"
            Ctrl+D发送的数据
        mail 邮件
            发邮件
                mail user1
                    Subject:hello       <-邮件标题
                    Nice to meet you    <-邮件具体内容
                    .                   <-使用"."来结束邮件输入
                mail -s "test mail" root < /root/anaconda-ks.cfg 发送文件内容 -s指定邮件的标题
                    把/root/anaconda-ks.cfg文件的内容发送给root用户
            查看邮件
                mail 查看邮件
                N:选择其中一份没有看过的邮件
                h:列出邮件标题
                d:删除指定邮件
                s:保存邮件
                quit:退出,并把自己操作过的邮件进行保存
                exit:退出,但是不保存任何操作
                ?:帮助文档

    系统痕迹
        w 显示系统中正在登陆用户的信息
            14:16:49 up  1:09,  1 user,  load average: 1.89, 1.82, 1.76
            #系统时间   持续开机时间 登陆用户  系统在1分钟,5分钟,15分钟前的平均负载
            USER     TTY      来自           LOGIN@   IDLE   JCPU   PCPU WHAT
            zler     :0       :0               13:09   ?xdm?   2:29   0.01s /usr/lib/gdm3/gdm-x-session --run-script env GNOME_SHELL_SESSION_MODE=ubuntu gnome-session --session=ubuntu
        who 显示系统中正在登陆用户的信息
        last 查看系统所有登陆过的用户信息
        lastlog 查看系统中所有用户最后一次的登陆时间
        lastb 查看错误登陆的信息

    挂载
        linux所有的存储设备都必须挂载使用,包括硬盘
            将空的目录与硬件设备进行链接
            光盘设备文件名是 /dev/hdc, /dev/sro
            无论哪个系统的操作系统都有软链接/dev/cdrom与可以作为光盘的设备文件名
        挂载和卸载光盘
            mount 查询系统已经挂载的设备
            mkdir /mnt/cdrom 新建一个空的目录       
            mount -t iso9660 /dev/cdrom /mnt/cdrom 把光驱挂载到cdrom目录
            /mnt/cdrom 退出光盘
            umount /dev/sr0 卸载光驱
            umount /dev/cdrom (硬件)卸载光驱
            umount /mnt/cdrom (挂载点)卸载光驱
            eject 弹出光盘
        挂载和卸载U盘
            fdisk -l U盘会和硬盘共用设备文件名,所以U盘的设备文件名不是固定的,需要手工查询/dev/sdb4
            mkdir /mnt/usb
            mount -t vfat /dev/sdb4 /mnt/usb/  vfat=windows的FT32
            mount -t vfat -o iocharset=utf8 /dev/sdb4 /mnt/usb/ 指定字符集显示中文
            umount /mnt/usb/ 卸载
        mount
            -a:依据配置文件/etc/fstab的内容,自动挂载
            -t 文件系统: 加入文件系统类型来指定挂载的类型,可以ext3,ext4,iso9660等文件系统
            -l 卷标名: 挂载指定卷标的分区,而不是安装设备文件名挂载
            -o 特殊选项: 可以指定挂载的额外选项,比如读写权限,同步异步等 如果不指定则默认值生效.
        挂载NTFS分区
            linux的驱动加载顺序
                驱动直接放入系统内核之中.这种驱动主要是系统启动加载必须的驱动,数量较少
                驱动以模块的形式放入硬盘.大多数驱动都已这种方式保存,保存位置在
                    /lib/modules/3.10.0-862.el7.x86_64/kernel中
                    /lib/modules/5.0.0-31-generic/kernel/中
                驱动可以被linux识别,但是系统认为这种驱动一般不常用,默认不加载.如果需要加载这种驱动
                    需要重新编译内核,而NTFS文件系统的驱动就属于这种情况
                硬件不能被linux内核识别,需要手工安装驱动.当然前提是厂商提供了该硬件针对linux的驱动
                    否则就需要自己手动开发驱动了
            NTFS-3G安装NTFS文件系统模块
                下载NTFS-3G插件,从官网:http://www.tuxera.com/community/ntfs-3g-download
                安装NTFS-3G插件
                    要保证gcc安装了
                    tar -zxvf ntfs-3g_ntfsprogs-2013.1.13.tgz
                    cd ntfs-3g_ntfsprogs-2013.1.13
                    ./configure
                    make
                    make install
                安装完成可以挂载使用windows的NTFS分区了.
                    不过要注意挂载分区时的文件系统不是ntfs，而是ntfs-3g
                    mount -t ntfs-3g /dev/sdb1 /mnt/win

# 通配符
    匹配文件名,完全匹配
    ?:匹配一个任意的字符
    *:匹配0个或者任意多个字符,也可以是匹配任何内容
    []:匹配中括号中任意一个字符。
        [abc]代表一定匹配一个字符,或者是a,或者是b,或者是c
    [-]:匹配中括号中任意一个字符, -代表一个范围。
        [a-z]代表匹配一个小写字母
    [^]:逻辑非,表示匹配不是中括号内的一个字符
        [^0-9]代表匹配一个不是数字的字符

# 正则表达式
    用于匹配字符串,包含匹配
    ?:匹配前一个字符重复0次,或1次
    *:匹配前一个字符重复0次,或任意多次
    []:匹配中括号任意一个字符
        [abc]代表一定匹配一个字符,或者是a,或者是b，或者c
    [-]:匹配中括号任意一个字符，-代表一个范围
        [a-z]代表匹配一个小写字母
    [^]:逻辑非,表示匹配不是中括号内的一个字符
        [^0-9]代表匹配一个不是数字的字符
    ^: 匹配行首  
    $: 匹配行尾

# vim
    vim是一个全屏幕纯文本编辑器,是vi的增强版
    alias vi='vim'，永久生效,请放入环境变量配置文件(~/.bashrc)
    进入编辑器模式
        a: 光标所在字符后插入
        A: 光标所在字符行尾插入
        i: 光标所在字符前插入 不发生任何变换
        I: 光标所在行行首插入
        o: 在光标下插入新行
        O: 在光标上插入新行
        s: 删除光标所在字符
    尾行模式的操作
        ZZ保存退出
        :q 退出编辑器
        :w 对修改后的内容进行保存
        :wq 保持修改并退出编辑器
        :q! （不保存）强制退出编辑器
        :w! 强制保存
        :wq! 强制保存并退出编辑
        :set nu   设置行号
        :set nonu 取消行号
        :数字 跳转到光标所在行
        查找
            :/查找内容 从光标所在行向下查找
            :?查找内容 从光标所在行向上搜索
                n 下一个
                N 上一个
        替换
            :s/cont1/cont2/  替换光标所在行的第一个cont1 字符串cout1被替换为cont2
            :1,10s/cont1/cont2/g  替换1到10行的所有字符串cout1被替换为cont2
            :s/cont1/cont2/g 替换光标所在行的全部cont1
            :%s/cont1/cont2/g 替换整个文档的cont1
            :1,10s/^/#/g 注释1到10行 ^代表行首
            :1,10s/^#//g 取消注释
            :1,10s/^/\/\//g 注释1到10行
            :1,10s/^\/\///g 取消注释
    命令模式操作
        移动光标
            字符级
                左 下 上 右  移动光标
                h  j  k l 
            单词级
                w：word移动到下个单词的首字母
                e:    end 移动到下个（本）单词的尾字母
                b:    before移动到上个（本）单词的首字母
            行级
                $:    行尾
                0:    行首
                ^:    行首
            段落级
                {：上个（本）段落首部
                }：下个（本）段落尾部
            屏幕级
                H：屏幕首部
                L: 屏幕尾部
            文档级
                gg:移动到文件头
                G:文档尾部
                1G：文档第一行
                nG:文档第n行
        内容删除
            dd:  删除光标当前行
            2dd：包括当前行在内，向后删除2行内容
            ndd：包括当前行在内，删除后边n行内容
            :10,20d 删除指定范围内的行
            x:   删除光标所在字符
            nx:  删除光标所在字符的n个字母
            dG:  从光标所在行删到文件尾
            cw:  从光标所在位置删除至单词结尾，并进入编辑模式        
        内容复制
            yy:  复制光标当前行
            2yy： 包括当前行在内，向后复制2行内容
            nyy： 包括当前行在内，复制后边n行内容
            p：   对（删除）复制好的内容进行粘贴到光标后
            P：   对（删除）复制好的内容进行粘贴到光标前
        相关快捷键
            u: 撤销
            ctrl+r: 反撤销
            J： 合并上下两行
            r： 单个字符替换
            R: 从光标所在处开始替换字符,按ESC结束
            .点：重复执行上次最近的指令
    vim的配置文件"~/.vimrc"，把你需要的参数写入配置文件   
        :syntax on  开启语法颜色
        :syntax off 关闭语法颜色
        :set hlsearch 高亮显示
        :set nohlsearch 不高亮显示
        :set ruler 右下角的状态栏
        :set noruler 不右下角的状态栏
        :set showmode 设置左下角的状态栏入INSERT
        :set noshowmode 取消左下角的状态栏入INSERT
        :set list 设置显示隐藏字符
        :set nolist 设置不显示隐藏字符
        :set tx=4 设置Tab为4个空格
    使用技巧
        导入文件内容
            :r 文件名 把文件的内容导入到光标处
            :r!命令 在vim中执行系统命令
            :r !命令 在vim中执行系统命令,并把结果导入到光标所在行
        设定快捷键
            :map 快捷键 快捷键的命令 自定义快捷键
            :map ^P I#<ESC> 按"ctrl + p"时,在行首加入注释
            :map ^B ^x      按"ctrl + b"时,删除行首第一个字母(删除注释)
            :map ^D yyp     复制当前行到下一行
            注意:^P快捷键不能手工输入,需要执行ctrl+v然后ctrl+p
        字符替换
            :ab 源字符 替换字符 
            :ab mymail shenchao@163.com 当碰到"mymail"时,转变为邮箱
        多文件打开
            vim -o abc bcd 上下分屏打开两个文件
            ctrl+w加左右箭头来切换屏幕
            vim -O abc bcd 左右分屏打开两个文件
            ctrl+ww:来切换屏幕
            :wqall保存所有文件   

# 软件包管理
    软件包分类
        源码包
            开源,如果有足够的能力,可以修改源代码
            可以自由选择需要的功能
            软件是编译安装,所以更加适合自己的系统,更加稳定也更加高效
            卸载方便
            安装过程步骤较多,尤其安装较大的软件集合时(如LAMP),容易出现拼写错误
            编译过程时间较长,安装比二进制安装时间长
            因为是编译安装,安装过程中一旦报错新手很难解决
        二进制包
            window的.exe
            linux的debian和ubuntu的.dpkg
            linux的redhat的.rpm
    软件包安装建议
        源码包:如果服务是给大量客户端访问的,建议使用源码包,源码包效率高(LAMP)
        二进制包:如果程序是给少量用户访问,或者本地使用的,建议RPM或者dpkg包,因为RPM或者dpkg包管理方便
    rpm和yum
        windwos控制面板 添加/卸载程序 进行程序的安装,更新,卸载,查看,Setup.exe
        包的依赖性
        包全名:如果操作的是未安装软件包,则使用全包名,而且需要注意绝对路径
        包名:如果操作的是已经安装的软件包,则使用包名即可,系统会生产RPM包的数据库(/var/lib/rpm),
            而且可以在任何路径使用
        rpm命令:相当于windows的添加/卸载程序,进行程序的安装、更新、卸载、查看Step.exe
        安装: rpm -ivh 包全名 安装包
            -i: install
            -v: 显示更详细的信息
            -h: 打印显示安装进度
            --nodeps:不检查依赖性
            --prefix:指定安装位置,不建议指定位置,rpm包安装会记录安装位置的数据库,卸载的时候会找到并卸载，
                源码包安装需要指定安装位置,不然默认位置乱放,不好卸载,源码包卸载很简单直接删除安装目录
            --force:强制安装,不管是否已经安装,都重新安装
                如果一个软件的文件被我们误删除,那么没法启动这个软件,可以使用强制安装,再重新安装一片
            --test:测试安装,不会实际安装,只是检测一下依赖性
            rpm包安装后软件的位置，不是绝对的只是大部分
                /etc/ 配置文件安装目录
                /usr/bin/ 可执行的命令安装
                /usr/lib/ 程序所使用的函数库保存位置
                /usr/share/doc/ 基本的软件使用手册保存位置
                /usr/share/man/ 帮助文档保存位置
            rpm安装的包如何启动
                service 服务名 start|stop|restart|status
                /etc/rc.d/init.d/httpd start|stop|restart
                service搜索的也是/etc/rc.d/init.d/目录
        升级: rpm -Uvh 包全名
            这个只是升级安装包
        升级安装: rpm -Fvh 包全名
            升级安装包并安装
        卸载: rpm -e 包名
            --nodeps:不检查依赖性
            -e: 卸载
            卸载的时候也会按照安装的依赖卸载
        查看:rpm -q 包名
                查询是本地是否已安装
            rpm -qa 包名
                查询所有
            rpm -qi 包名
                查询软件信息
            rpm -qip 包全名
                查还没有安装的软件包的信息
            rpm -ql 包名
                查询已经安装的软件包中的文件列表和安装的完整目录
            rpm -qlp 包全名
                查询还没有安装的软件包中的文件列表和打算安装的位置
            rpm -qf 系统文件名
                查询系统文件属于哪个包
            rpm -qR 包名
                查询所有系统中和已经安装的软件包的依赖关系的软件包
            rpm -Va
                校验本机已经安装的所有软件包
                校验是为了保证是否是正版的比如:md5加密的文件包
                验证的包的内容比如大小,配置文件,等等
            rpm -V 包名
                校验本机已经安装的软件包
            rpm -Vf 系统文件名
                校验某个系统文件是否被修改
            rpm -g 包全名
                查看软件是否有安装
            rpm2cpio 包全名 | cpio -idv . 文件绝对路径
                提取RPM包中文件，比如httpd的配置文件
        数字证书:
            校验方法只能对已经安装的RPM包中的文件进行校验,但如果RPM包本身就被动手脚,
            那么校验就不能解决问题。
            数字证书的特点:
                首先必须找到原厂的公钥文件,然后进行安装
                再安装RPM包,会去提取RPM包中的证书信息,然后和本机安装的原厂证书进行验证
                如果验证通过,则允许安装;如果验证不通过,则不允许安装并警告
            数字证书的位置:
                光盘里面RPM-GPG-KEY-CentOS-6
                本机/etc/pki/rpm-gpg/RPM-GPG-KEY-CentOS-6
            数字证书导入
                rpm --import RPM-GPG-KEY-CentOS-6
            查看系统安装过的数字证书
                rpm -qa | grep gpg-pubkey
        yum:相当于可以联网的rpm命令
            相当于先联网下载程序安装包、程序的更新包,自动执行rpm命令
            联网安装的话,不需要手动解决安装包的各种依赖包
            yum源配置文件保存在/etc/yum.repos.d/目录中,文件的扩展名一定是"*.repo"
            yum操作大部分是要访问源服务器
            yum list 
                查询所有可用软件包列表
            yum list 包名
                查询yum源服务器中是否包含某个软件包
            yum search 关键字
                搜索服务器上所有和关键字相关软件包
            yum info 包名
            yum -y install 包名
                -y:自动回答yes
            yum -y update 包名
            yum remove 包名
            yum grouplist 
                查看可以安装的软件组
            yum groupinfo 软件组名
                查看软件组的详细信息
            yum -y groupinstall 软件组名
                安装软件组
            yum groupremove 软件组名
                卸载软件组
    dpkg和apt-get
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
        apt-get命令:相当于可以联网的dpkg命令
            相当于先联网下载程序安装包、程序的更新包,自动执行dpkg命令
    源码包安装
        下载软件包
        解压缩
        进入解压缩文件
        ./configure: 编译前准备
            安装之前需要检测系统环境是否符合安装要求
            自定义需要的功能选型./configure支持的功能选项较多,可以执行./configure --help命令、
                查询支持的功能.一般都会通过./configure --prefix=安装路径,来指定安装路径
            把系统环境的检测结果和定义好的功能选项写入Makefile文件,后续的编译和安装需要依赖这个文件的内容
            Makefile只有执行了./configure后才会生成这个文件
        make: 编译
            make会调用gcc编译器,并读取Makefile文件中的信息进行系统软件编译.编译的目的就是把源码程序转变成
                为linux识别的可执行文件,这些可执行文件保存在当前目录下.编译过程较为耗时,需要有足够的耐性
        make clean: 清空编译内容(非必须步骤)
            如果在./configure或make编译中报错,那么我们在重新执行命令前一定要记得执行make clean命令,它
                会清空Makefile文件或编译产生的.o头文件
        make install: 编译安装
            这才是真正的安装过程,一般会写清楚程序的安装位置.如果忘记指定安装目录,则可以把这个命令的执行过程
                保存下来,以备将来删除使用
    打入补丁
        diff -Naur /root/test/old.txt /root/test/new.txt > txt.patch
            比较两个文件的不同,同时生成txt.patch补丁文件
        patch -pn < 补丁文件
            按照补丁文件进行更新
    脚本安装程序
        就是一个shell脚本,里面写了一些RPM包和源码包的安装命令
        Webmin软件
            这个是用web浏览器来管理linux服务器的一个软件
            http://sourceforge.net/projects/webadmin/files/webwin/
            https://sourceforge.net/projects/webadmin/files/webmin/1.930/webmin-1.930.tar.gz/download
        tar -zxvf webmin-1.930.tar.gz
        ./Setup.sh

# 登陆终端
    本地字符终端  tty1-6        alt+F1-6
    本地图形终端  tty7          ctrl+alt+F7(按住3秒,安装启动图形界面)
    远程终端     pts/0-255

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
