# FFMPEG下载编译与安装

```shell
git clone https://git.ffmpeg.org/ffmpeg.git
config --help
make && make install 
```

网络慢 手动下载

```shell
scp ffmpeg-snapshot.tar.bz2 zler@172.16.150.7:/home/zler/ffmpeg
tar jxvf ffmpeg-snapshot.tar.bz2
```

解压后对每个模块进行介绍

```
libavformat： 对多媒体格式进行解析和封装
libavutil：常用的工具
libavcodec：所有音频的编解码 它不对具体进行编解码 主要是将其他的模块插入进来
libavdevice： 对机器的设备进行处理的 对音频视频的采集 桌面的采集
libavresample：对音频进行重采样 这个用的比较少
libavfilter：对音频视频的后期处理 对视频进行过滤镜
libswresample：对音频的操作
libswscale：对视频的操作
```

 ./configure --help 查看都有哪些模块

```shell
./configure --help  | more ## 分页模块
./configure  --list-filters
./configure  --list-encoders
./configure  --list-decoders
```

安装

```shell
./configure --prefix=/usr/local/ffmpeg \
	--enable-gpl \
	--enable-nonfree \
	--enable-libfdk-aac \
	--enable-libx264 \
	--enable-libx265 \
	--enable-filter=delogo \ ##可以生成视频中水印
	--enable-debug \ ##打开调试 正式线上不用安装
	--enable-optimizations \ ##关闭了优化
	--enable-libspeex \
	--enable-videotoolbox \
	--enable-shared \ ##生成共享库
	--enable-pthreads \
	--enable-version3 \
	--enable-hardcoded-tables \
	--cc=clang \
	--host-cflags= --host-ldflags=
```

去除注释

```
./configure --prefix=/Users/zler/ffmpeg \
	--enable-gpl \
	--enable-nonfree \
	--enable-libass \
	--enable-indev=avfoundation \
	--enable-libfdk-aac \
	--enable-libx264 \
	--enable-libx265 \
	--enable-filter=delogo \
	--enable-debug \
	--enable-optimizations \
	--enable-libspeex \
	--enable-shared \
	--enable-pthreads \
	--enable-version3 \
	--enable-hardcoded-tables \
	--cc=clang --host-cflags= --host-ldflags=
```

当然也可以使用系统安装方式 brew apt yum等等 搞到最后还是使用 sudo apt install ffmpeg.  Mac 下使用 brew install ffmpeg

# ffmpeg常用命令分类

```
比如可以将mp4转成flv
可以将一段音频和视频进行合并
裁剪 录制

基础信息查询命令
录制命令
分解/复用命令 （其实就是类似于将mp4转成flv）
处理原始数据命令 （通过音频设备视频设备进行采集 并且可以加工）

剪切与合并命令 （可以将一段音频和视频进行合并 可以裁剪一个视频和音频的一部分）
图片/视频互转命令 （有一个视频可以按秒转成一张张图片 也可以将一张张图片再圆成一个视频）
直播相关命令 （我可以推流 远端的客户端可以拉流）
各种滤镜命令 （可以给一个视频加一个logo 也可以删除logo 也可以对视频进行反转滤镜）
```

# ffmpeg的处理流程

![66](./img/66.png)



```reStructuredText
输入文件：比如 mp4 flv等这些文件我们称之为封装格式的文件，这个封装格式的文件可以想象为一个盒子，在这个盒子里面我们可以装各种内容包括音频数据、视频数据、字幕数据等等

打开这个盒子我们称之为 demuxer 打开这个盒子后暴露给我们的是音频数据 视频数据 字幕数据等 把这些数据称之为编码数据 因为这些数据是压缩后的数据 不是原始的数据 

把这些压缩后的数据进行解码decoder，解码过后我们就拿到了原始数据

拿到原始数据我们可以进行修改 比如720px 我们可以缩小为480px，然后对这个数据进行编码encoder

然后我们要将编码过后的数据进行封装muxer，封装成一种流行的格式 这种格式交给播放器 播放器又认识 播放器就知道怎么解码 播放 

```

# ffmpeg基本信息查询命令

| -version  | 显示版本           | -formats     | 显示可用的格式     |
| --------- | ------------------ | ------------ | ------------------ |
| -demuxers | 显示可用的demuxers | -protocols   | 显示可用的协议     |
| -muxers   | 显示可用的muxers   | -filters     | 显示可用的过滤器   |
| -devices  | 显示可用的设备     | -pix_fmts    | 显示可用的像素格式 |
| -codecs   | 显示所有的编解码器 | -sample_fmts | 显示可用的采样格式 |
| -decoders | 显示可用的解码器   | -layouts     | 显示channel名称    |
| -encoders | 显示所有的编码器   | -colors      | 显示识别的颜色名称 |
| -bsfs     | 显示比特流filter   |              |                    |

# ffmpeg录屏命令

```shell
#录制
ffmpeg -f avfoundation -i 1 -r 30 out.yuv
-f: 指定使用mac 下 avfoundation库 采集数据
-i: 指定从哪儿采集数据，它是一个文件索引号
	0:代表摄像头的索引值
	1:代表屏幕的索引值
-r: 指定帧数

#播放
ffplay -s 2880x1800 -pix_fmt uyvy422 out.yuv
ffplay -s 2880x1800 out.yuv

#avfoundation这个库所支持设备列表
ffmpeg -f avfoundation -list_devices true -i ""
```

# fmpeg录屏声音命令

```shell
ffmpeg -f avfoundation -i :0 out.wav
:0 代表音频设备

# 播放
ffplay out.wav
```

# fmpeg分解/复用命令

![67](./img/67.png)

```shell
## demuxer:分解过程
## muxer: 复用
ffmpeg -i out.mp4 -vcodec copy -acodec copy out.flv # 不考虑分解码
-i: 输入文件
-vcodec copy: 视频编码处理方式
-acodec copy: 音频编码处理方式

ffmpeg -i f35.mov -vcodec copy -acodec copy f35.mp4
ffmpeg -i aa.mov -vcodec copy -acodec copy aa.mp4 #视频转化到其他格式
ffmpeg -i aa.mov -an -vcodec copy aa.h264 # 只抽取视频
ffmpeg -i aa.mov -acodec copy -vn aa.aac # 只抽取音频
```

# fmpeg处理原始数据命令

原始数据:ffmpeg解码后的数据 对于音频就是pcm数据，对于视频就是yuv数据

原始数据播放器是播发不了的

```shell
## fmpeg提取yuv数据
ffmpeg -i input.mp4 -an -c:v rawvideo -pix_fmt yuv420p out.yuv
-an：a 代表音频 n 代表not 意思就是不要音频
-c:v rawvideo: 指定编码方式rawvideo

ffmpeg -i aa.mp4 -an -c:v rawvideo -pix_fmt yuv420p aa.yuv

ffplay aa.mp4  #报错 Picture size 0x0 is invalid
#因为原始数据是没有宽和高的

ffplay -s 1280x720 aa.yuv  # 指定分辨率来播放

## fmpeg提取pcm数据
ffmpeg -i aa.mp4 -vn -ar 44100 -ac 2 -f s16le aa.pcm
-vn:不要视频
-ar: a 音频 r 采样率  音频的采样率是多少
-ac: a 音频 c(chanel) 声道  音频是 单声道 还是 双声道 还是 立体声
-f: 音频存储格式是什么 s有符号16进制le小头 

ffplay aa.pcm #报错或者无效的数据 不知道什么样的采样率 也不知道是单身道还是多声道
ffplay -ar 44100 -ac 2 -f s16e aa.pcm

## 我们提取出这些原始数据可以验证我们基于ffmpeg的二次开发时候这些命令非常重要
```

# ffmpeg 各种滤镜命令

<img src="./img/69.jpg" alt="69" style="zoom:50%;" />

```shell
 #加水印 去水印 画中画 视频裁剪 音频倍速等等
 #滤镜都是对解码后的数据进行处理
 ffmpeg -i aa.mp4 -vf crop=in_w-600:in_h-200 -c:v libx264 -c:a copy bb.mp4
 -vf: v视频 f 滤镜
 crop 视频具体的哪个滤镜 滤镜的名字 每个滤镜的方式不一样的
 				in_w-200:in_h-200 宽度-400 高度-200
 
 -c:v libx264: 指定视频编码方式
 -c:a copy: 指定音频编码方式 copy 就是不指定拷贝原油的编码方式
 

```

# ffmpeg剪切与合并命令 

```shell
## 对音视频进行裁剪
ffmpeg -i xxmm.mp4 -ss 00:00:05	 -t 5 xxmm.ts
## 对音视频进行合并
ffmpeg -f concat -i a.txt hb.mp4
	a.txt 内容为 'file filename' 格式
    file 'aa.ts'
    file 'xxmm.ts'
```

# ffmpeg图片/视频互转命令

```shell
# 视频转图片
ffmpeg -i xxmm.mp4 -r 1 -f image2 image-%3d.jpeg
  -r 转化为图片的帧率是多少 1代表 每秒钟转换成1张图片
  -f 转成什么格式的
  image-%3d.jpeg 代表 输出的文件名

# 图片转视频 将一堆图片合并成一个视频
ffmpeg -i image-%3d.jpeg tupian.mp4

# ffmpeg还可以转播 移动端音视频入门
```

# ffmpeg直播相关命令

```shell
#直播推流
ffmpeg -re -i xxmm.mp4 -c copy -f flv rtmp://server/live/streamName
-re 减慢帧率速度
-c 是音视频  -avcodec 音频 -vcodec 视频 的总和
-f 格式的

#直播拉流
ffmpeg -i rtmp://server/live/streamName -c copy dump.flv
-c 拉到的流是否进行重新编码

ffplay rtmp://58.200.131.2:1935/livetv/hunantv # 播放湖南卫视
ffplay http://ivi.bupt.edu.cn/hls/cctv1hd.m3u8 # 播放cctv1
 
ffmpeg -i rtmp://58.200.131.2:1935/livetv/hunantv -c copy laliu.flv
ffmpeg -i http://ivi.bupt.edu.cn/hls/cctv1hd.m3u8 -c copy laliu.m3u8
```

<img src="./img/70.jpg" alt="70" style="zoom:50%;" />

# ffmpeg初级开发

Ffmpeg日志的使用及目录操作

介绍ffmpeg的基本概念及常见结构体

对复用/解服用及流的操作的各种实战

<img src="./img/74.jpg" alt="74" style="zoom:50%;" />

# ffmpeg日志的系统

```c
#include <libavutil/log.h>
av_log_set_level(AV_LOG_DEBUG)
av_log(NULL, AV_LOG_INFO,"...%S\n", op)
  
# 编译 gcc ffmpeg_log.c -o ffmpeg_log -g -lavutil
```

常用日志级别

```
AV_LOG_ERROR 最高
AV_LOG_WARNING 依次
AV_LOG_INFO 依次
AV_LOG_DEBUG 依次
设置日志级别那么级别一下不会打印 以上的会打印
```

文件的删除与重命名

```
avpriv_io_delete() //删除文件
avpriv_io_move() //重命名 移动

```

编译

```shell
## /usr/local/Cellar/ffmpeg/4.3_3/lib/

## /usr/local/Cellar/ffmpeg/4.3_3/include/  

gcc ffmpeg_file.c -o ffmpeg_file -g -I /usr/local/Cellar/ffmpeg/4.3_3/include/ -L /usr/local/Cellar/ffmpeg/4.3_3/lib/ -l avformat 
```

代码

```c
#include <libavformat/avformat.h>

int main(int argc, char const *argv[])
{
    int ret;
    ret = avpriv_io_move("111.txt", "222.txt");
    if(ret < 0){
        av_log(NULL, AV_LOG_ERROR, "fail to rename file %s \n", "111.txt");
        return -1;  
    }
    av_log(NULL,AV_LOG_INFO, "success rename \n");  
    //url
    ret = avpriv_io_delete("./my.txt");
    if(ret < 0){
        av_log(NULL, AV_LOG_ERROR, "fail to delete file %s \n", "ny.txt");
        return -1;
    }
    av_log(NULL, AV_LOG_INFO, "success to delete my.txt \n");
    return 0;
}
```

# ffmpeg对目录进行操作

```
avio_open_dir()
avio_read_dir()
avio_close_dir()
#结构体
AVIODirContext 操作目录的上下文	
AVIODirEntry 目录项 用于存放文件名 文件大小信息
```

代码

```c
#include <libavutil/log.h>
#include <libavformat/avformat.h>

int main(int argc, char const *argv[])
{
    int ret;
    AVIODirContext *ctx = NULL;
    AVIODirEntry *entry = NULL; 
    
    av_log_set_level(AV_LOG_INFO);
    
    ret = avio_open_dir(&ctx, "./", NULL);
    if(ret < 0){
        av_log(NULL, AV_LOG_ERROR, "can't open dir:%s\n", av_err2str(ret));
        return -1;
    }

    while (1){
        ret = avio_read_dir(ctx, &entry);
        if(ret < 0){
            av_log(NULL, AV_LOG_ERROR, "can't read dir:%s\n", av_err2str(ret));
            goto END;
        }

        if(!entry){
            break;
        }

        av_log(NULL, AV_LOG_INFO, "%12"PRId64" %s \n", entry->size, entry->name);

        avio_free_directory_entry(&entry);//释放
    }

END:   
    avio_close_dir(&ctx); //错误时释放

    return 0;
}

```

# 多媒体文件基本概念

```
多媒体文件其实是一个容器

在容器里有很多流(Stream/Track)
	轨道：轨道永远不相交的 不同的流是不相交的 即使是多个音频和多个视频都是不相交的

每种流是由不同的编码器编码的

从流中读取的数据称为包
	在一个包中包含着一个或者多个桢
```

# 几个重要的结构体

```c
AVFormatContext 格式上下文 各个api的桥梁
AVStream 流 多个视频流 多个音频流 多个字母流
AVPacket 包 一个个包获得桢 桢就可以获得原始数据
```

<img src="/Users/zler/Desktop/doc/img/75.jpg" alt="75" style="zoom:50%;" />

容器盒子打开就是解复用 -> 获取容器许多的流  ->读取流的数据包 -> 对数据包（包里拿到数据帧）进行解码拿到原始数据  -> 变声 倍速播放 录播 -》释放相关资源

# [实战] 打印音视频信息

我们工作生活中经常想知道这个多媒体的音频是什么格式 视频是什么格式 音频采样率是多少 视频的帧数是多少

```
av_register_all() 将ffmpeg所定义的编解码库 一些格式 格式库 格式协议 网络协议 全部注册到程序里面
avformat_open_input() 打开一个多媒体文件 识别多媒体格式是什么 输出结构体AVFormatContext
avformat_close_input() 关闭
av_dump_format() 将多媒体的mete信息打印出来
```

代码

```c
#include <libavutil/log.h>
#include <libavformat/avformat.h>

int main(int argc, char const *argv[])
{
    AVFormatContext * fmt_ctx = NULL;
    int ret;

    av_log_set_level(AV_LOG_INFO);

    av_register_all();

    //参数一 输出AVFormatContext结构体指针 参数二 文件名 参数三 指定输入的格式  参数四 使用命令行传入的参数
    ret = avformat_open_input(&fmt_ctx, "./aa.mp4", NULL, NULL);
    if(ret < 0){
        av_log(NULL, AV_LOG_ERROR, "Can't open file:%s\n", av_err2str(ret));
        return -1;
    }

    //参数2 流的索引值 自定义 参数3 文件名  参数4 0是输入流 1是输出流
    av_dump_format(fmt_ctx, 0, "./aa.mp4", 0);

    avformat_close_input(&fmt_ctx);

    return 0;
}
```

# [实战] 抽取音频数据

```
av_init_packet() 初始化数据包
av_find_best_stream() 在多媒体文件中找到最好的一路流
av_read_frame() 将流中的一个个数据包读取到
av_packet_unref() 释放数据包
```

代码

```c
#include <libavutil/log.h>
#include <libavformat/avformat.h>
#include <stdio.h>

#define ADTS_HEADER_LEN  7;

void adts_header(char *szAdtsHeader, int dataLen){

    int audio_object_type = 2;
    int sampling_frequency_index = 7;
    int channel_config = 2;

    int adtsLen = dataLen + 7;

    szAdtsHeader[0] = 0xff;         //syncword:0xfff                          高8bits
    szAdtsHeader[1] = 0xf0;         //syncword:0xfff                          低4bits
    szAdtsHeader[1] |= (0 << 3);    //MPEG Version:0 for MPEG-4,1 for MPEG-2  1bit
    szAdtsHeader[1] |= (0 << 1);    //Layer:0                                 2bits 
    szAdtsHeader[1] |= 1;           //protection absent:1                     1bit

    szAdtsHeader[2] = (audio_object_type - 1)<<6;            //profile:audio_object_type - 1                      2bits
    szAdtsHeader[2] |= (sampling_frequency_index & 0x0f)<<2; //sampling frequency index:sampling_frequency_index  4bits 
    szAdtsHeader[2] |= (0 << 1);                             //private bit:0                                      1bit
    szAdtsHeader[2] |= (channel_config & 0x04)>>2;           //channel configuration:channel_config               高1bit

    szAdtsHeader[3] = (channel_config & 0x03)<<6;     //channel configuration:channel_config      低2bits
    szAdtsHeader[3] |= (0 << 5);                      //original：0                               1bit
    szAdtsHeader[3] |= (0 << 4);                      //home：0                                   1bit
    szAdtsHeader[3] |= (0 << 3);                      //copyright id bit：0                       1bit  
    szAdtsHeader[3] |= (0 << 2);                      //copyright id start：0                     1bit
    szAdtsHeader[3] |= ((adtsLen & 0x1800) >> 11);           //frame length：value   高2bits

    szAdtsHeader[4] = (uint8_t)((adtsLen & 0x7f8) >> 3);     //frame length:value    中间8bits
    szAdtsHeader[5] = (uint8_t)((adtsLen & 0x7) << 5);       //frame length:value    低3bits
    szAdtsHeader[5] |= 0x1f;                                 //buffer fullness:0x7ff 高5bits
    szAdtsHeader[6] = 0xfc;
}

int main(int argc, char const *argv[])
{ 
    int ret;
    int auido_index;
    int len; 
    const char * src = NULL;
    const char * dst = NULL;
    AVPacket pkt;
    AVFormatContext * fmt_ctx = NULL;

    av_log_set_level(AV_LOG_INFO);

    if(argc < 3){
        av_log(NULL, AV_LOG_ERROR, "参数少于三个\n");
        return -1;
    }

    src = argv[1];
    dst = argv[2];
    if(src == NULL || dst == NULL){
        av_log(NULL, AV_LOG_ERROR, "src 和 dst不能为NULL\n");
        return -1;
    }

    av_register_all();

    //参数一 输出AVFormatContext结构体指针 参数二 文件名 参数三 指定输入的格式  参数四 使用命令行传入的参数
    ret = avformat_open_input(&fmt_ctx, src, NULL, NULL);
    if(ret < 0){
        av_log(NULL, AV_LOG_ERROR, "Can't open file:%s\n", av_err2str(ret));
        avformat_close_input(&fmt_ctx);
        return -1;
    }
    
    FILE * dst_fd = fopen(dst, "wb");
    if(dst_fd == NULL){
        av_log(NULL, AV_LOG_ERROR, "不能打开输出文件\n");
        avformat_close_input(&fmt_ctx);
        return -1;
    }

    //参数2 流的索引值 自定义 参数3 文件名  参数4 0是输入流 1是输出流
    av_dump_format(fmt_ctx, 0, src, 0);

    //参数二 指定获取音频流 视频流 文字流... 参数三 要处理流的索引号 不知道就填写-1 参数四 相关的流的索引号 不知道就填写-1
    //参数五 要处理流的编解码器 不知道就填写NULL 参数五 标志 不知道就填写0
    ret = av_find_best_stream(fmt_ctx, AVMEDIA_TYPE_AUDIO, -1, -1, NULL, 0);
    if(ret < 0){
        av_log(NULL, AV_LOG_ERROR, "不能找到最好的流\n");
        avformat_close_input(&fmt_ctx);
        fclose(dst_fd);
        return -1;
    }
    auido_index = ret;

    av_init_packet(&pkt);
    while(av_read_frame(fmt_ctx, &pkt) > 0){
        if(pkt.stream_index == auido_index){
            //增加adts的头
            char adts_header_buf[7];
            adts_header(adts_header_buf, pkt.size);
            fwrite(adts_header_buf, 1, 7, dst_fd);

            len = fwrite(pkt.data, 1, pkt.size, dst_fd);
            if(len != pkt.size){
                av_log(NULL,AV_LOG_ERROR,"警告 数据长度不等于包的大小\n");
            }
        }

        av_packet_unref(&pkt);
    }
 
    avformat_close_input(&fmt_ctx);
    if(dst_fd){
        fclose(dst_fd);
    }

    return 0;
}
```

[实战] 抽取视频数据

```
Start code 通过特征码 来区分每一桢
SPS/PPS 去解码的参数 分辨率...
codec->extradata
```

代码

```c
#include <stdio.h>
#include <libavutil/log.h>
#include <libavformat/avio.h>
#include <libavformat/avformat.h>

#ifndef AV_WB32
#   define AV_WB32(p, val) do {                 \
        uint32_t d = (val);                     \
        ((uint8_t*)(p))[3] = (d);               \
        ((uint8_t*)(p))[2] = (d)>>8;            \
        ((uint8_t*)(p))[1] = (d)>>16;           \
        ((uint8_t*)(p))[0] = (d)>>24;           \
    } while(0)
#endif

#ifndef AV_RB16
#   define AV_RB16(x)                           \
    ((((const uint8_t*)(x))[0] << 8) |          \
      ((const uint8_t*)(x))[1])
#endif

static int alloc_and_copy(AVPacket *out,
                          const uint8_t *sps_pps, uint32_t sps_pps_size,
                          const uint8_t *in, uint32_t in_size)
{
    uint32_t offset         = out->size;
    uint8_t nal_header_size = offset ? 3 : 4;
    int err;

    err = av_grow_packet(out, sps_pps_size + in_size + nal_header_size);
    if (err < 0)
        return err;

    if (sps_pps)
        memcpy(out->data + offset, sps_pps, sps_pps_size);
    memcpy(out->data + sps_pps_size + nal_header_size + offset, in, in_size);
    if (!offset) {
        AV_WB32(out->data + sps_pps_size, 1);
    } else {
        (out->data + offset + sps_pps_size)[0] =
        (out->data + offset + sps_pps_size)[1] = 0;
        (out->data + offset + sps_pps_size)[2] = 1;
    }

    return 0;
}

int h264_extradata_to_annexb(const uint8_t *codec_extradata, const int codec_extradata_size, AVPacket *out_extradata, int padding)
{
    uint16_t unit_size;
    uint64_t total_size                 = 0;
    uint8_t *out                        = NULL, unit_nb, sps_done = 0,
             sps_seen                   = 0, pps_seen = 0, sps_offset = 0, pps_offset = 0;
    const uint8_t *extradata            = codec_extradata + 4;
    static const uint8_t nalu_header[4] = { 0, 0, 0, 1 };
    int length_size = (*extradata++ & 0x3) + 1; // retrieve length coded size, 用于指示表示编码数据长度所需字节数

    sps_offset = pps_offset = -1;

    /* retrieve sps and pps unit(s) */
    unit_nb = *extradata++ & 0x1f; /* number of sps unit(s) */
    if (!unit_nb) {
        goto pps;
    }else {
        sps_offset = 0;
        sps_seen = 1;
    }

    while (unit_nb--) {
        int err;

        unit_size   = AV_RB16(extradata);
        total_size += unit_size + 4;
        if (total_size > INT_MAX - padding) {
            av_log(NULL, AV_LOG_ERROR,
                   "Too big extradata size, corrupted stream or invalid MP4/AVCC bitstream\n");
            av_free(out);
            return AVERROR(EINVAL);
        }
        if (extradata + 2 + unit_size > codec_extradata + codec_extradata_size) {
            av_log(NULL, AV_LOG_ERROR, "Packet header is not contained in global extradata, "
                   "corrupted stream or invalid MP4/AVCC bitstream\n");
            av_free(out);
            return AVERROR(EINVAL);
        }
        if ((err = av_reallocp(&out, total_size + padding)) < 0)
            return err;
        memcpy(out + total_size - unit_size - 4, nalu_header, 4);
        memcpy(out + total_size - unit_size, extradata + 2, unit_size);
        extradata += 2 + unit_size;
pps:
        if (!unit_nb && !sps_done++) {
            unit_nb = *extradata++; /* number of pps unit(s) */
            if (unit_nb) {
                pps_offset = total_size;
                pps_seen = 1;
            }
        }
    }

    if (out)
        memset(out + total_size, 0, padding);

    if (!sps_seen)
        av_log(NULL, AV_LOG_WARNING,
               "Warning: SPS NALU missing or invalid. "
               "The resulting stream may not play.\n");

    if (!pps_seen)
        av_log(NULL, AV_LOG_WARNING,
               "Warning: PPS NALU missing or invalid. "
               "The resulting stream may not play.\n");

    out_extradata->data      = out;
    out_extradata->size      = total_size;

    return length_size;
}

int h264_mp4toannexb(AVFormatContext *fmt_ctx, AVPacket *in, FILE *dst_fd)
{

    AVPacket *out = NULL;
    AVPacket spspps_pkt;

    int len;
    uint8_t unit_type;
    int32_t nal_size;
    uint32_t cumul_size    = 0;
    const uint8_t *buf;
    const uint8_t *buf_end;
    int            buf_size;
    int ret = 0, i;

    out = av_packet_alloc();

    buf      = in->data;
    buf_size = in->size;
    buf_end  = in->data + in->size;

    do {
        ret= AVERROR(EINVAL);
        if (buf + 4 /*s->length_size*/ > buf_end)
            goto fail;

        for (nal_size = 0, i = 0; i<4/*s->length_size*/; i++)
            nal_size = (nal_size << 8) | buf[i];

        buf += 4; /*s->length_size;*/
        unit_type = *buf & 0x1f;

        if (nal_size > buf_end - buf || nal_size < 0)
            goto fail;

        /*
        if (unit_type == 7)
            s->idr_sps_seen = s->new_idr = 1;
        else if (unit_type == 8) {
            s->idr_pps_seen = s->new_idr = 1;
            */
            /* if SPS has not been seen yet, prepend the AVCC one to PPS */
            /*
            if (!s->idr_sps_seen) {
                if (s->sps_offset == -1)
                    av_log(ctx, AV_LOG_WARNING, "SPS not present in the stream, nor in AVCC, stream may be unreadable\n");
                else {
                    if ((ret = alloc_and_copy(out,
                                         ctx->par_out->extradata + s->sps_offset,
                                         s->pps_offset != -1 ? s->pps_offset : ctx->par_out->extradata_size - s->sps_offset,
                                         buf, nal_size)) < 0)
                        goto fail;
                    s->idr_sps_seen = 1;
                    goto next_nal;
                }
            }
        }
        */

        /* if this is a new IDR picture following an IDR picture, reset the idr flag.
         * Just check first_mb_in_slice to be 0 as this is the simplest solution.
         * This could be checking idr_pic_id instead, but would complexify the parsing. */
        /*
        if (!s->new_idr && unit_type == 5 && (buf[1] & 0x80))
            s->new_idr = 1;

        */
        /* prepend only to the first type 5 NAL unit of an IDR picture, if no sps/pps are already present */
        if (/*s->new_idr && */unit_type == 5 /*&& !s->idr_sps_seen && !s->idr_pps_seen*/) {

            h264_extradata_to_annexb( fmt_ctx->streams[in->stream_index]->codec->extradata,
                                      fmt_ctx->streams[in->stream_index]->codec->extradata_size,
                                      &spspps_pkt,
                                      AV_INPUT_BUFFER_PADDING_SIZE);

            if ((ret=alloc_and_copy(out,
                               spspps_pkt.data, spspps_pkt.size,
                               buf, nal_size)) < 0)
                goto fail;
            /*s->new_idr = 0;*/
        /* if only SPS has been seen, also insert PPS */
        }
        /*else if (s->new_idr && unit_type == 5 && s->idr_sps_seen && !s->idr_pps_seen) {
            if (s->pps_offset == -1) {
                av_log(ctx, AV_LOG_WARNING, "PPS not present in the stream, nor in AVCC, stream may be unreadable\n");
                if ((ret = alloc_and_copy(out, NULL, 0, buf, nal_size)) < 0)
                    goto fail;
            } else if ((ret = alloc_and_copy(out,
                                        ctx->par_out->extradata + s->pps_offset, ctx->par_out->extradata_size - s->pps_offset,
                                        buf, nal_size)) < 0)
                goto fail;
        }*/ else {
            if ((ret=alloc_and_copy(out, NULL, 0, buf, nal_size)) < 0)
                goto fail;
            /*
            if (!s->new_idr && unit_type == 1) {
                s->new_idr = 1;
                s->idr_sps_seen = 0;
                s->idr_pps_seen = 0;
            }
            */
        }


        len = fwrite( out->data, 1, out->size, dst_fd);
        if(len != out->size){
            av_log(NULL, AV_LOG_DEBUG, "warning, length of writed data isn't equal pkt.size(%d, %d)\n",
                    len,
                    out->size);
        }
        fflush(dst_fd);

next_nal:
        buf        += nal_size;
        cumul_size += nal_size + 4;//s->length_size;
    } while (cumul_size < buf_size);

    /*
    ret = av_packet_copy_props(out, in);
    if (ret < 0)
        goto fail;

    */
fail:
    av_packet_free(&out);

    return ret;
}

int main(int argc, char *argv[])
{
    int err_code;
    char errors[1024];

    char *src_filename = NULL;
    char *dst_filename = NULL;

    FILE *dst_fd = NULL;

    int video_stream_index = -1;

    //AVFormatContext *ofmt_ctx = NULL;
    //AVOutputFormat *output_fmt = NULL;
    //AVStream *out_stream = NULL;

    AVFormatContext *fmt_ctx = NULL;
    AVPacket pkt;

    //AVFrame *frame = NULL;

    av_log_set_level(AV_LOG_DEBUG);

    if(argc < 3){
        av_log(NULL, AV_LOG_DEBUG, "the count of parameters should be more than three!\n");
        return -1;
    }

    src_filename = argv[1];
    dst_filename = argv[2];

    if(src_filename == NULL || dst_filename == NULL){
        av_log(NULL, AV_LOG_ERROR, "src or dts file is null, plz check them!\n");
        return -1;
    }

    /*register all formats and codec*/
    av_register_all();

    dst_fd = fopen(dst_filename, "wb");
    if (!dst_fd) {
        av_log(NULL, AV_LOG_DEBUG, "Could not open destination file %s\n", dst_filename);
        return -1;
    }

    /*open input media file, and allocate format context*/
    if((err_code = avformat_open_input(&fmt_ctx, src_filename, NULL, NULL)) < 0){
        av_strerror(err_code, errors, 1024);
        av_log(NULL, AV_LOG_DEBUG, "Could not open source file: %s, %d(%s)\n",
               src_filename,
               err_code,
               errors);
        return -1;
    }

    /*dump input information*/
    av_dump_format(fmt_ctx, 0, src_filename, 0);

    /*initialize packet*/
    av_init_packet(&pkt);
    pkt.data = NULL;
    pkt.size = 0;

    /*find best video stream*/
    video_stream_index = av_find_best_stream(fmt_ctx, AVMEDIA_TYPE_VIDEO, -1, -1, NULL, 0);
    if(video_stream_index < 0){
        av_log(NULL, AV_LOG_DEBUG, "Could not find %s stream in input file %s\n",
               av_get_media_type_string(AVMEDIA_TYPE_VIDEO),
               src_filename);
        return AVERROR(EINVAL);
    }

    /*
    if (avformat_write_header(ofmt_ctx, NULL) < 0) {
        av_log(NULL, AV_LOG_DEBUG, "Error occurred when opening output file");
        exit(1);
    }
    */

    /*read frames from media file*/
    while(av_read_frame(fmt_ctx, &pkt) >=0 ){
        if(pkt.stream_index == video_stream_index){
            /*
            pkt.stream_index = 0;
            av_write_frame(ofmt_ctx, &pkt);
            av_free_packet(&pkt);
            */

            h264_mp4toannexb(fmt_ctx, &pkt, dst_fd);

        }

        //release pkt->data
        av_packet_unref(&pkt);
    }

    //av_write_trailer(ofmt_ctx);

    /*close input media file*/
    avformat_close_input(&fmt_ctx);
    if(dst_fd) {
        fclose(dst_fd);
    }

    //avio_close(ofmt_ctx->pb);

    return 0;
}
```

# [实战] 将MP4转成FLV格式

```
avformat_alloc_output_context2() 创建输出上下文 
avformat_free_context()//释放上下文
avformat_new_stream()//创建新的流
avcodec_parameters_copy() //拷贝编解码的参数

avformat_write_header() //写入到输出文件的header 
av_write_frame()/av_interleaved_write_frame() 写数据

av_write_trailer() 将写入的缓冲区最终写入到输出文件
```

代码

```c

```

# [实战] 从MP4截取一段视频

```
av_seek_frame() 跳一段时间
```

# [实战] 实现一个简单的小咖秀

```
将两个媒体文件中分别抽取音频与视频轨
将音频与视频轨合成一个新的文件
对音频与视频轨进行裁剪
```

# ffmpeg中级开发

```
H264解码
H264编码
AAC解码
AAC编码

常见的结构体
  添加头文件 libavcodec/avcodec.h
  AVCodec 编码器结构体
  AVCodecContext 编码器上下文
  AVFrame 解码后的帧 帧的格式yuv   frame是帧的意思
结构体的内存分配和释放
	av_frame_alloc/av_frame_free
	avcodec_alloc_context3 编解码器的上下文
	avcodec_free_context 释放编解码器的上下文

解码步骤
	查找解码器 avcodec_find_decoder 就是在一个流(流的id)中找到解码器
	打开解码器 avcodec_open2
	解码 avcodec_decode_video2
	最终解码为未压缩的数据yuv rgb 然后比如通过openGL渲染
编码步骤
	查找编码器 avcodec_find_encoder_by_name 通过名字找到编码器
	设置编码参数，打开编码器 avcodec_open2
	编码 avcodec_encode_video2

avcodec_register_all() //只注册编解码器
```



# 基于ffmpeg直播推流流程

<img src="./img/71.jpg" alt="71" style="zoom:50%;" />

<img src="./img/72.jpg" alt="72" style="zoom:50%;" />

协议: rtmp(长链接)，http-flv(adobe)实时性比较高(长链接)  苹果的hls(短链接)

​	推流基本上用rtmp来做 默认端口为1935

​	拉流播放的时候使用 http-flv来做

​	电视实时性要求不高的用hls

服务器：nginx-rtmp   crtmpserver

直播播放器： vls  ffplay 网页端基于flash的播放器插件(adobe)

采集设备：电脑自带的摄像机 usb摄像机 嵌入式的摄像机设备这种设备采集的数据是rgb原始数据 要进行转换

# 直播服务器配置

流媒体服务器：

​	第三方大厂： 七牛  腾讯  网易

​    局域网： red5(java) 和FMS商用

​	crtmpserver(开源)

​	nginx+rtmp插件(开源)

```shell
docker run -ti  --name=zler-crtmpserver -p 1935:1935 -p 80:80 -p 8080:8080 -p 443:443 -d ubuntu:16.04 /bin/bash
```

安装crtmpserver

```shell
apt-get -y update
apt-get install -y cmake --fix-missing
apt-get install -y libssl-dev
apt-get install -y wget
apt-get install -y unzip
apt-get install -y build-essential
wget https://codeload.github.com/j0sh/crtmpserver/zip/centosinit
unzip centosinit
cd crtmpserver-centosinit/builders/cmake
cmake .
make
./crtmpserver/crtmpserver ./crtmpserver/crtmpserver.lua
```

ffmpeg -re -i laliu.flv -c copy -f flv rtmp://172.16.150.7/live/test1





安装nginx和rtmp模块

```shell
# 前提是安装gcc g++ libssl-dev
wget http://nginx.org/download/nginx-1.12.1.tar.gz
tar -zxvf nginx-1.12.1.tar.gz 
apt-get install libpcre3-dev
apt-get install zlib1g-dev
git clone https://github.com/arut/nginx-rtmp-module.git
./configure --add-module=/root/nginx-rtmp-module-master ##看看有没有库没安装
make
make install
#默认是安装在/usr/local/nginx
cd /usr/local/nginx/conf
vim nginx.conf 添加如下配置：
		# 和http同级别
    rtmp 
    {
      server
      {
        listen 1935;
        chunk_size 4096;
        application live
        {
          live on;	
        }	
      }
    }
    #在http下server同级别
        server {
          listen 8080;
          location /stat {
            rtmp_stat all;
            rtmp_stat_stylesheet stat.xsl;
          }
          location /stat.xsl {
            root /root/nginx-rtmp-module-master/stat.xsl;
          }
        }
cd /usr/local/nginx
./sbin/nginx -tc ./conf/nginx.conf
./sbin/nginx 
```

ffmpeg -re -i laliu.flv -c copy -f flv rtmp://172.16.150.7/live

vlc 播放器 配置 rtmp://172.16.150.7/live

使用ffplay播放

ffplay rtmp://172.16.150.7/live --fflags nobuffer

# web播放器

