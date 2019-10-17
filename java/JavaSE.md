# IDE工具
	
# String

# StringBuilder

# StringBuffer(掌握)
    (1)用字符串做拼接，比较耗时并且也耗内存，而这种拼接操作又是比较常见的，
        为了解决这个问题，Java就提供了
	   一个字符串缓冲区类。StringBuffer供我们使用。
       StringBuffer线程安全的可变字符序列
	(2)StringBuffer的构造方法
		A:StringBuffer()
		B:StringBuffer(int capacity)
		C:StringBuffer(String str)
    (3)StringBuffer的方法
        public int capacity():返回当前容量。理论值
        public int length():返回长度(字符数).实际值
	(4)StringBuffer的常见功能(自己补齐方法的声明和方法的解释)
		A:添加功能
            public synchronized StringBuffer append(String str):
                可以把任意类型添加到字符串的缓冲区里面
                并返回的是字符串缓冲区本身,并不会重新开辟空间,可以链式编成
            public synchronized StringBuffer insert(int offset, String str):
                在指定位置把任意类型的数据插入到字符串缓冲区里面
                并返回的是字符串缓冲区本身,并不会重新开辟空间,可以链式编成
		B:删除功能
            public synchronized StringBuffer deleteCharAt(int index)
                删除指定位置的字符,并返回本身链式编成
            public synchronized StringBuffer delete(int start, int end)
                删除从指定位置开始到指定位置结束的内容,并返回本身
                [start, end]区间----包左不包右(几乎java都是这样)
		C:替换功能
            public synchronized StringBuffer replace(int start, int end, String str)
                从start开始到end用str替换掉 包左不包右(几乎java都是这样)
		D:反转功能
            public synchronized StringBuffer reverse()
		E:截取功能(注意这个返回值)
            start 13.07
	(5)StringBuffer的练习(做一遍)
		A:String和StringBuffer相互转换
			String -- StringBuffer
				构造方法
			StringBuffer -- String
				toString()方法
		B:字符串的拼接
		C:把字符串反转
		D:判断一个字符串是否对称
	(6)面试题
		小细节：
			StringBuffer：同步的，数据安全，效率低。
			StringBuilder：不同步的，数据不安全，效率高。
		A:String,StringBuffer,StringBuilder的区别
            StringBuffer和String的区别?
                前者长度和内容是可变的,后者是不可变的
                如果使用前者做字符拼接,不会浪费太多资源
		B:StringBuffer和数组的区别?
	(4)注意的问题：
		String作为形式参数，StringBuffer作为形式参数。
	
# 多线程
	