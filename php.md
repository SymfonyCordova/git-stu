# php7的编译安装和性能比较

```shell
 9000
开启一个服务器
	docker run -ti --name=zler-source -p 9000:9000 -p 1935:1935 -p 80:80 -p 8080:8080 -p 443:443 -d ubuntu:16.04 /bin/bash

安装 
	gcc g++
  apt-get install libxml2-dev

下载php源码包并戒烟
  tar -zxvf php-5.6.37.tar.gz 
  tar -zxvf php-7.1.0.tar.gz 

解压后其中的三个文件夹
	Zend 核心
	ext 扩展
	sapi

编译
	./configure -h > test 将帮助信息放到test

 测试学习编译
 ./configure --prefix=/root/output/php-7.1.0 \
    --enable-fpm \
    --enable-debug
 
 生产环境编译
 ./configure --prefix=/usr/local/php-7.1.0 \
    --enable-fpm

	--enable-debug意思是方便gdb调试 默认gcc不会开启这个 因为优化的比这个性能好
	--enable-fpm意思给我安装php-fpm 默认是不会安装的

  make 编译
  make install 将编译后的可执行文件放到了指定的安装目录/root/output/php-7.1.0
  
编译完成进入安装目录,安装目录下面有这几个文件夹
	bin  etc  include  lib  php  sbin  var
	sbin：文件夹下面有php-fpm
	bin：文件夹下是php的可执行程序

比较php7和php5的性能
   ./configure --prefix=/root/output/php-7.0.2 --enable-fpm
   ./configure --prefix=/root/output/php-5.6.37 --enable-fpm
   ./configure --prefix=/root/output/php-7.1.0 --enable-fpm
  在php-7.1.0中的Zend目录下有bench.php micro_bench.php 进行测试
  拿bench.php执行耗时
    php-5.6.37              1.997
    php-7.0.2               0.616
    php-7.1.0               0.596
  拿micro_bench.php执行耗时
    php-5.6.37             10.046
    php-7.0.2              3.303
    php-7.1.0              3.230
```

# php7新特性

```php
//1.太空船操作符 <=>
//2.类型的声明
	declare(strict_types=1) //strict_types=1表示开启严格模式
  function aa(int a):int{}
//3.null合并操作符号
//4.常量数组 这个数组不可修改
	define('ANIMALS',['dog', 'cat', 'bird']);
//NameSpace批量导入
//throwable接口
//Closure::call()
//intdiv(10, 3) 10/3
//list的方括号写法
	$arr = [1,2,3];
	list($a, $b, $c) = $arr;
	[$a,$b,$c] = $arr;
//抽象语法树(AST)
	($a)['b']=1
```

# 基本变量-zval

```c
struct _zval_struct {
  zend_value value; //8个字节
  union u1; //4个字节
  union u2; //4个字节
}

typedef union _zend_value{
  zend_long lval,
  double dval;
  zend_refcounted *counted; //
  zend_string *str;
  zend_array *arr;
  zend_object *obj;
  zend_resource *res; //资源类型
  zend_reference *ref; //引用类型
  zend_ast_ref *ast; //抽象语法树
  zval *zv;
  void *ptr;
  zend_class_entry *ce; //类
  zend_function *func; //函数
} zend_value;

union{
  struct{
    ZEND_ENDIAN_LOHI_4(
    	zend_uchar type, //区分类型
      zend_uchar type_flags,
      zend_uchar const_flags,
      zend_uchar reserved,
    )
  } v;
  unit32_t type_info;//为了快速求出大小
}u1;

union {
  uint32_t next;
  uint32_t cache_slot;
  uint32_t lineno;
  uint32_t num_args;
  uint32_t fe_pos;
  uint32_t fe_iter_idx;
  uint32_t access_flags;
  uint32_t property_guard;
}u2;
```



# 内存管理

Zend_string 写时复制  

```php
$a = "abc";
$b = $a;  //不会开辟空间 而是引用数refcount+1 指向同一个地址
$a = "de"; //此时会开辟新的空间 
```

Zend_reference 引用类型

```php
$a = "abc";
$b = &$a; // $a $b都变成了引用类型
$a = "de";
echo $a;
echo $b; //此时$a修改了$b也跟着修改了 指向同一块空间

unset($b); //只是将b 的zval改成is_null类型 a和b的地址都没变 只是b的zval变成了0就是null a没变
echo $b; //空
echo $a; //de
```

Zend_array   就是HashTable

```php
//nTableSize 初始化数组的时候大小是8 不够的时候扩容 每次都会乘以2的扩容
//头插法
```

Small 内存管理 large 内存管理

```
用户申请的内存 在zend先分配一页内存 然后将这一页内存 进行等分割, 然后用双向链表链接起来,只返回其中一个给用户使用 等下次又有人申请内存就直接从链表中取就可以了,不需要重复的申请内存
```

内存对齐

