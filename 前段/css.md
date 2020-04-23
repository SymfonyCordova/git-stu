# css字体样式属性

## font-size:字体号大小

font-size属性用于设置字号,该属性的值可以使用相对长度,也可以使用绝对长度单位。其中,相对长度单位比较常用,推荐使用像素单位px,绝对长度单位使用较少。具体如下:

| 相对长度单位 |              说明              |
| :----------: | :----------------------------: |
|      em      | 相当于当前对象内文本的字体尺寸 |
|      px      |     像素，最常用，推荐使用     |
| 绝对长度单位 |              说明              |
|      in      |              英寸              |
|      cm      |              厘米              |
|      mm      |              毫米              |
|      pt      |               点               |



## font-family:字体

font-family属性用于设置字体。网页中常用的字体由宋体、微软雅黑、黑体等,假如将网页中所有段落文本的字体设置为微软雅黑，可以使用如下CSS样式代码:

p{font-family:"微软亚黑";}

可以同时指定多个字体,中间以逗号隔开,表示浏览器不支持第一个字体,则会尝试下一个,直到找到合适的字体

> :+1: 常用技巧:

```text
1.现在网页中普遍使用14px+
2.尽量使用偶数的数字字号。ie6等老式浏览器支持奇数会有BUG
3.各种字体之间必须使用英文状态下的逗号隔开
4.中文字体需要加英文状态下的引号,英文字体一般不需要加引号。当需要设置英文字体时,英文字体名必须位于中文字体名之前
5.如果字体名中包括空格、#、$等符号,则该字体必须加英文状态下的单引号或双引号,例如font-family:"Times New Roman";。
6.尽量使用系统默认字体,保证在任何用户的浏览器都正确显示。
```



## CSS Unicode字体

在CSS中设置字体名称,直接写中文是可以的。但是在文件编码(GB2312、UTF-8等)不匹配时会产生乱码的错误。xp系统不支持类似微软雅黑的中文。

方案一: 你可以使用英文来代替。比如font-family:"Microsoft Yahei"。

方案二: 在CSS直接使用Unicode编码来写字体名称可以避免这些错误。使用Unicode写中文字体名称,浏览器是可以正确的解析的font-family:"\\5FAE\\8F6F\\9ED1"，表示设置字体为"微软雅黑"

可以通过escape()来测试属于什么字体

| 字体名称    | 英文名称        | Unicode编码                |
| ----------- | --------------- | -------------------------- |
| 宋体        | SimSun          | \5B8B\4F53                 |
| 新宋体      | NSimSun         | \65B0\5B8B\4F53            |
| 黑体        | SimHei          | \9ED1\4F53                 |
| 微软雅黑    | Microsoft YaHei | \5FAE\x8F6F\6B63\9ED1\4F53 |
| 楷体_GB2312 | KaiTi_GB2312    | \6977\4F53_GB2312          |
| 隶书        | LiSu            | \96B6\4E66                 |
| 幼园        | YouYuan         | \5E7C\5706                 |
| 华文细黑    | STXihei         | \534E\6587\7EC6\9ED1       |
| 细明体      | MingLiU         | \7EC6\660E\4F53            |
| 新细明体    | PMingLiU        | \65B0\7EC6\660E\4F53       |

我们以后尽量只写unicode字体,写宋体和微软雅黑  "\5FAE\x8F6F\6B63\9ED1\4F53", "\5B8B\4F53"

## font-weight:字体粗细

字体加粗了用b和strong标签之外,可以使用CSS来实现,但是CSS是没有语义的。

```reStructuredText
font-weight属性用于定义字体的粗细,其可用属性值:normal(不加粗)、bold、bolder、lighter、100～900(100的整数倍)  
```

:+1:小技巧:

```reStructuredText
数字400等价normal,而700等价于bold。但是我们更喜欢用数字表示
```



## font-style:字体风格

字体倾斜除了用i和em标签之外,可以使用css来实现,但是CSS是没有语义的

font-style属性用于定义字体风格,如设置斜体、倾斜或正常字体，其可用属性值如下:

normal:默认值,浏览器会显示标准的字体样式

italic:浏览器会显示斜体的字体样式

oblique:浏览器会显示倾斜的字体样式

:+1:小技巧:

```reStructuredText
平时我们很少给文字加斜体,发而喜欢给斜体标签(em, i)改为普通模式
```



## font:综合设置字体样式(重点)

font属性用于对字体样式进行综合设置,其基本语法格式如下:

```reStructuredText
选择器{font:  font-style font-weight  font-size/line-height  font-family}
```



```reStructuredText
使用font属性时,必须按上面语法格式中的顺序书写,不能更换顺序,各个属性以空格隔开。
注意:其中不需要设置的属性可以省略(取默认值),但必须保留font-size和font-family属性,否则font属性将不起作用
```



# css注释

```reStructuredText
css规则是使用	/*  需要注释的内容   */ 进行注释的
```

例如:

```css
p {
    font-size:  14px;
}
```

# 选择器(重点)

## 标签选择器

标签选择器是指用HTML标签名作为选择器,按标签名称分类,为页面中某一类标签指定统一的CSS样式。基本语法格式如下:

```reStructuredText
标签名{属性1:属性值1;属性2:属性值2;属性3:属性值3;}  或者
元素名{属性1:属性值1;属性2:属性值2;属性3:属性值3;}
```

标签选择器最大优点是能快速为页面中同类型的标签统一样式,同时这也是它的缺点,不能设计差异化样式。

## 类选择器

类选择器使用"."(英文点号)进行标识,后面紧跟类名,其基本语法格式如下:

```reStructuredText
.类名{ 属性1:属性值1;属性2:属性值2;属性3:属性值3; }
```

```reStructuredText
标签调用的时候用  class="类名" 即可
```

类选择器最大的优势是可以为元素对象定义单独或相同的样式

:+1:小技巧:

```reStructuredText
1.长名称或词组可以使用中横线来为选择器命名。
2.不建议使用"_"下划线来命名css选择器。
```

输入的时候少按一个shift键;

浏览器兼容问题(比如使用_tips的选择器命名,在IE6是无效的)

能良好区分JavaScript变量命名(JS变量命名是用"_")

```reStructuredText
3.不能纯数字、中文等命名,尽量使用英文字母来表示
```



## 多类名选择器

```html
<style>
    .font20 {
        font-size: 20px;
    }
    .font14 {
        font-size: 14px;
    }
    .pink {
        color: pink;
    }
    .fontWeight {
        font-weight: bold;
    }
</style>
<body>
    <div class="font20 pink fontWeight" >亚瑟</div>
</body>
```

注意:

```reStructuredText
1.样式显示效果跟HTML元素中的类名先后顺序没有关系,受CSS样式书写的上下顺序有关
2.各个类名中间用空格隔开
```

多类名选择器在后期布局中比较复杂的情况下,还是较多使用的

## id选择器

id选择器使用"#"进行标识，后面紧跟id名,其基本语法格式如下:

```reStructuredText
#id名{ 属性1:属性值1;属性2:属性值2;属性3:属性值3; }
```

该语法中,id名即为HTML元素的id属性值,大多数HTML元素都可以定义id属性,元素的id值是唯一的,只能对应文档中某一个具体的元素。

用法基本和类选择器相同

## id选择器和类选择器区别

w3c标准规定,在同一个页面内,不允许有相同名字的id对象出现,但是允许相同的class。

类选择器(class)好比人的名字,是可以多次重复使用的,比如 张位 王位 李位 李娜

id选择器 好比人的身份证号码, 全中国是唯一的,不得重复。只能使用一次。

总结: 类选择器和id选择器的区别就是在使用次数上

## 通配符选择器

通配符选择器用"*"号表示,他是所有选择器中作用范围最广的,能匹配页面中所有的元素。基本语法格式如下:

```reStructuredText
* { 属性1:属性值1;属性2:属性值2;属性3:属性值3; }
```

例如下面的代码,使用通配符选择器定义CSS样式,清除所有HTML标记的默认边距。

```css
* {
    margin: 0; /*定义外边距*/
    padding: 0; /*定义内边距*/
}
```

注意:

​	这个通配符选择器,就像我们的电影明星中的梦中情人,想想它就好了,但是它不会和你过日子

## 伪类选择器

首先,这也是一个选择器,伪类选择器用于向某些选择器添加特殊的效果。比如给链接添加特殊效果,比如可以选择第1个,第n个元素。

```reStructuredText
为了和我们刚才学的类选择器相区别,类选择器是一个点 比如 .demo {}  而我们的伪类用2个点就是冒号 比如  :link {}
```

### 链接伪类选择器

- :link /\*未访问的链接\*/
- :visited /\*已访问的链接  我们已经点击过一次的状态\*/
- :hover /\*鼠标移动到链接上\*/
- :active /\* 选定的链接 当我们点击别松开鼠标显示的状态 \*/

注意写的时候,他们的顺序尽量不要颠倒 按照 lvha的顺序。 love hate 记忆法 或者  lv包包 非常 hao

实际工作,我们简单写链接伪元素选择器就好了

```css
a {
    	font-weight: 700;
    	font-size: 16px;
    	color: gray;
}
a:hover {
    	color: red;
}
```



### 结构(位置)伪类选择器(CSS3)

- :first-child: 选取属于其父元素的首个子元素的指定选择器
- :last-child: 选取属于其父元素的最后一个子元素的指定选择器
- :nth-child(n):  匹配属于其父元素的第N个子元素,不论元素的类型 even 偶数 odd奇数 n从0开始 2n,2n+1
- :nth-last-child(n): 选择器匹配属于其元素的第N个子元素的每个元素,不论元素的类型,从最后一个子元素开始计数 。从下往上来数
- n可以是数字、关键字或公式



### 目标伪类选择器

:target目标伪类选择器 :选择器可用于选择当前活动的目标元素

# CSS外观属性

## color:文本颜色

color属于用于定义文本的颜色,其取值方式有如下3种:

1. 预定义的颜色值,如red, green, blue等
2. 十六进制,如 #FF0000,#FF6600,#29D794等。实际工作中,十六进制是最常用的定义颜色的方式。
3. RGB代码,如红色可以表示rgb(255,0,0)或rgb(100%,0%,0%)

需要注意的是,如果使用RGB代码的百分比颜色，取值为0时也不能省略百分号,必须写为0%。

## line-height:行间距

line-height属性用于设置行间距,就是行与行之间的距离,即字符的垂直间距,一般称为行高。line-height常用的属性值单位有三种,分别为像素px，相对值em和百分比%，实际工作中使用最多的是像素px。

一般情况下，行距比字号大7.8像素左右就可以了

## text-align:水平对齐方式

```reStructuredText
text-align属性用于设置文本内容的水平对齐,相当于html中align对齐属性。其可用属性值如下:
```

left: 左对齐(默认值)

right: 右对齐

center: 居中对齐

## text-index:首行缩进

text-index属性用于设置首行文本的缩进,其属性值可为不同单位的数值、em字符宽度的倍数、或相对于浏览器窗口宽度的百分比%,允许使用负值,建议使用em作为设置单位

1em就是一个字的宽度 如果是汉字的段落, 1em 就是一个汉字的宽度

## letter-spacing:字间距

letter-spacing属性用于定义字间距,所谓字间距就是字符与字符之间的空白。其属性值可为不同单位的数值,允许使用负值,默认为normal。

## word-spacing:单词间距

word-spacing属性用于定义英文单词之间的间距,对中文字符无效。和letter-spacing一样,其属性值可为不同单位的数值,允许使用负值，默认为normal.

word-spacing和letter-spacing均可对英文进行设置。不同的是letter-spacing定义的为字母之间的距离,而word-spacing定义的为英文单词之间的间距。

## 颜色半透明(css3)

文字颜色到了CSS3我们可以采取半透明的格式了语法格式如下:

```css
color: rgba(r,g,b,a) a是alpha 透明的意思 取值范围 0～1之间  color: rgba(0,0,0,0.3)
```



## 文字阴影(CSS3)

以后我们可以给我们的文字添加阴影效果了shadow影子

```css
text-shadow: 水平垂直 垂直位置 模糊距离 阴影颜色;
```

| 值       | 描述                                |
| -------- | ----------------------------------- |
| h-shadow | 必须。水平阴影的位置。允许负值      |
| v-shadow | 必须。垂直阴影的位置。允许负值      |
| blur     | 可选。模糊距离。                    |
| color    | 可选。阴影的颜色。参阅[CSS颜色值]() |



## word-break:自动换行

normal 使用浏览器默认的换行规则

break-all 允许在单词内换行

keep-all 只能在半角空格或连字符处换行

## text-overflow:文字溢出

# sublime快捷方式

sublime可以快速提高我们代码的书写方式

1. 生成标签直接输入标签名 按tab键即可 比如 div 然后tab键, 就可以生成
2. 如果想要生成多个相同标签 加上*就可以了 比如 div\*3就可以快速生成3个div
3. 如果有父子级关系的标签,可以用>比如 ul > li 就可以了
4. 如果有兄弟关系的标签, 用 + 就可以了 比如 ul > li 就可以了
5. 如果生成带有类名或者id名字的，直接写.demo 或者 #two tab就可以了

# 引入css样式表(书写位置)

CSS可以写到哪个位置?是不是一定写在html文件里面

## 内部样式表

内嵌式是将CSS代码集中写在HTML文档的head头部标签中,并且用style标签定义,其基本语法格式如下:

## 行内式(内联样式)

内联样式,又有人称行内样式、行间样式、内嵌样式。是通过标签的style属性来设置元素的样式,其基本语法格式如下:

```css
<标签名 style="属性1:属性值1;属性2:属性值2;属性3:属性值3;">内容</标签名>
```

语法中,style是标签的属性,实际上任何HTML标签都拥有style属性,用来设置行内式。其中属性和值的书写规范与css样式规则相同,行内式只对其所在的标签及嵌套在其中的子标签起作用



## 外部样式表(外链式)

嵌入式是将所有的样式放在一个或多个以.css为扩展名的外部样式表文件中,通过link标签将外部样式表文件链接到HTML文档中，其基本语法格式如下:

```css
<head>
	<link href="css文件的路径" type="text/css" rel="stylesheet" />
</head>
```

注意: link是单标签哦!!!

该语法中,link标签需要放在head头部标签中,并且必须指定link标签的三个属性,具体如下:

```reStructuredText
href: 定义所在链接外部样式表文件的URL，可以是相对路径，也可以是绝对路径
type: 定义所在链接文档的类型,在这里需要指定为"text/css"，表示链接的外部文件CSS样式表
rel: 定义当前文档与被链接文档之间的关系,在这里需要指定为"stylesheet"，表示被链接的文档是一个样式表文件
```



## 三种样式表总结

| 样式表     | 优点                     | 缺点                     | 使用情况       | 控制范围         |
| ---------- | ------------------------ | ------------------------ | -------------- | ---------------- |
| 行内样式表 | 书写方便,权重高          | 没有实现样式和结构相分离 | 较少           | 控制一个标签(少) |
| 内嵌样式表 | 部分结构和样式相分离     | 没有彻底分离             | 较多           | 控制一个页面(中) |
| 外部样式表 | 完全实现结构和样式相分离 | 需要引入                 | 最多，强烈推荐 | 控制整个站点(多) |



# 标签显示模式(display)

## 块级元素(block-level)

每个块元素通常都会独占据一整行或多整行,可以对其设置宽度、高度、对齐等属性,常用于网页布局和网页结构的搭建。

```reStructuredText
常见的块元素有<h1>~<h6>、<p>、<div>、<ul>、<ol>、<li>等,其中<div>标签是最典型的块元素
```

块级元素的特点:

1. 总是从新行开始
2. 高度,行高，外边距以及内边距都可以控制
3. 宽度默认是容器的100%
4. 可以容纳内联元素和其他块元素

## 行内元素(inline-level)

行内元素(内联元素)不占有独立的区域,仅仅靠自身的字体大小和图像尺寸来支撑结构,一般不可以设置宽度、高度、对齐等属性,常用于控制页面中文本的样式

```reStructuredText
常见的行内元素有<a>、<strong>、<b>、<em>、<i>、<del>、<s>、<ins>、<u>、<span>等,其中<span>标签最典型的行内元素
```

行内元素的特点:

1. 和相邻行内元素在一行上。
2. 高、宽无效,但水平方向的padding和margin可以设置,垂直方向的无效。
3. 默认宽度就是它本身内容的宽度。
4. 行内元素只能容纳文本或其他行内元素。(a特殊)

注意:

1. 只有文字才能组成段落,因此p里面不能放块级元素,同理还有这些标签h1,h2,h3,h4,h5,h6,dt,他们都是文字类块级标签,里面不能放其他块级元素
2. 链接里面不能再放链接

## 块级元素和行内元素的区别

```reStructuredText
块级元素特点:
	1. 总是从新行开始
	2. 高度,行高,外边距以及内边距都可以控制
	3. 宽度默认是容器的100%
	4. 可以容纳内联元素和其他块元素
```



```reStructuredText
行内元素特点:
	1. 和相邻行内元素在一行上
	2. 高、宽无效,但水平方向的padding和margin可以设置,垂直方向的无效
	3. 默认宽度就是它本身内容的宽度。
```



## 行内块元素(inline-block)

```reStructuredText
在行内元素中有几个特殊的标签--<img />、<input />、<td>，可以对他们设置宽度和对齐属性,有些资料可能会称它们为行内块元素。

行内块元素的特点:
	1. 和相邻行内元素(行内块)在一行上,但是之间会有空白缝隙
	2. 默认宽度就是它本身内容的宽度
	3. 高度，行高，外边距以及内边距都可以控制
```



## 标签显示模式转换display

块转行内: display:inline

行内转块: display:block

块、行内元素转换为行内块: display: inline-block

此阶段,我们只关心这三个,其他的是我们后面的工作

# css复合选择器

复合选择器是两个或多个基础选择器,通过不同的方法组合而成的,目的是为了可以选择更准确更精细的目标元素标签

## 交集选择器

交集选择器由两个选择器构成,其中第一个为标签选择器,第二个为class选择器,两个选择器之间不能有空格,例如h3.special

记忆技巧:

交集选择器是并且的意思。即...又...的意思

```css
比如:  p.one  选择的是: 类名为.one的段落标签
```

用的相对来说比较少,不太建议使用

## 并集选择器

并集选择器(CSS选择器分组)是各个选择器通过<strong style="color:#f00">逗号</strong>连接而成的,任何形式的选择器(包括标签选择器、class类选择器、id选择器等),都可以作为并集选择器的一部分。如果某些选择器定义的样子完全相同,或部分相同,就可以利用并集选择器为它们定义相同CSS样式。

记忆技巧:

并集选择器和的意思,就是说,只要逗号隔开的,所选择器都会执行后面的样式。

```css
比如 .one, p, #test {color: #F00;}  表示 .one和p 和 #test这三个选择器都会执行颜色为红色。通常用于集体声明。 
```



## 后代选择器

后代选择器又称为包含选择器,用来选择元素或元素组的后代,其写法就是外层标签写在前面,内存标签写在后面,中间用<strong style="color:#f00">空格</strong>分隔。当标签发生嵌套时,内层标签就成为外层标签的后代

子孙后代都可以这么选择。或者说,它能选择任何包含在内的标签



## 子元素选择器

子元素选择器只能选择作为某元素子元素的元素。其写法就是把父类标签写在前面,子级标签写在后面,中间跟一个<strong style="color:#f00" >></strong> 进行连接，注意,符号左右两侧各保留一个空格。

白话: 这里的子 指的是亲儿子 不包括孙子 重孙子之类的。

```css
比如  .demo > h3 {color:red;} 说明 h3一定是demo亲儿子。demo元素包含着h3。
```



## 测试题

```html
<div class="nav">
    <ul>
        <li><a href="#">公司首页</a></li>
        <li><a href="#">公司简介</a></li>
        <li><a href="#">公司产品</a></li>
        <li>
            <a href="#">联系我们</a>
            <ul>
                <li><a href="#">公司邮箱</a></li>
                <li><a href="#">公司电话</a></li>
            </ul>
        </li>
    </ul>
</div>
<div class="sitenav">
    <div class="site-l">左侧侧导航栏</div>
    <div class="site-r"><a href="#">登陆</a></div>
</div>
```

在不修改以上代码的前提下,完成一下任务:

1. 链接 登陆 的颜色为红色,同时主导航栏里面的所有的链接改为蓝色(简单)
2. 主导航栏和侧导航栏里面文字都是14像素并且是微软雅黑(中等)
3. 主导航栏里面的一级菜单链接文字颜色为绿色

```css
.site-r a {
    color: red;
}
.nav ul li a {
    color: skyblue;
}
.nav, .sitenav {
    font-size: 14px;
    font-family: "microsoft yahei";
}
.nav > ul > li > a {
    color: green;
}
```



## 属性选择器

选取标签带有某些特殊属性的选择器 我们称为属性选择器

| 选择器       | 示例 | 含义                             |
| ------------ | ---- | -------------------------------- |
| E[attr]      |      | 存在attr属性即可                 |
| E[attr=val]  |      | 属性值完全等于val                |
| E[attr*=val] |      | 属性值里包含字符并且在"任意"位置 |
| E[attr^=val] |      | 属性值里包含字符并且在"开始"位置 |
| E[attr$=val] |      | 属性值里包含字符并且在"结束"位置 |

```html
<div class="font12">属性选择器</div>
<div class="12font12">属性选择器</div>
<div class="12font">属性选择器</div>
<div class="font">属性选择器</div>
```



```css
div[class=font] {
    color: pick;
}
div[class=font] {
    color: skyblue;
}
div[class=font] {
    color: red;
}
```



## 伪元素选择器(CSS3)

1. E::first-letter文本的第一个单词或字(如中文、日文、韩文)

2. E::first-line文本第一行

3. E::selection可改变选中文本的样式

   ```css
   p::first-letter { /*选择第一个字*/
       color: red;
       font-size: 50px;
   }
   p::first-line { /*选择第1行*/
       color: green;
   }
   p::selection { /*当我们选中文字的时候,可以变化的样式*/
       color: pink;
   }
   ```

   

4. E::before和E::after

   在E元素内部的开始位置和结束位置创建一个元素,该元素为行内元素,且必须结合content属性使用

   ```css
   div::before { /*before和after在盒子div的内部的前面插入或者内部的后面插入*/
       content: "俺"
   }
   div::after {
       content: "18岁"
   }
   ```

   E:after、E:before在旧版本里面是伪元素,CSS3的规范里":"用来表示伪类,"::"用来表示伪元素,但是在高版本浏览器下E:after、E:before会被自动识别为E::after、E::before,这样做的目的是用来做兼容处理。

   E:after、E::before后面的练习中会反复用到,目前只需要有个大致了解

   ":"与"::"区别在于区分伪类和伪元素

# CSS书写规范

开始就形成良好的书写规范,是你专业化的开始

## 空格规范

【强制】选择器 {之间必须包含空格。

示例:	.select {}

【强制】属性名与之后的:之间不允许包含空格, :与属性之间必须包含空格

示例:

font-size: 12px;

## 选择器规范

【强制】当一个rule包含多个selector时,每个选择器声明必须独占一行

示例:

```css
/*good*/
.post,
.page,
.comment {
	line-height: 1.5;
}

/*bad*/
.post, .page, .comment {
    line-height: 1.5;
}
```

【建议】选择器的嵌套层级不大于3级,位置靠后的限定条件应尽可能精确。

示例:

```css
/* good */
#username input {}
.comment .avatar {}

/* bad */
.page .header .login #username input {}
.comment div * {}
```



## 属性规范

【强制】属性定义必须另起一行

示例:

```css
/* good */
.selector {
    margin: 0;
    padding: 0;
}
/* bad */

```

【强制】属性定义必须以分号结尾

示例:

```css
.selector{
    margin:0;
}
```



# CSS背景(background)

CSS可以添加背景颜色和背景图片,以及来进行图片设置。

| background-color                                            | 背景颜色         |
| ----------------------------------------------------------- | ---------------- |
| background-image                                            | 背景图片地址     |
| background-repeat                                           | 是否平铺         |
| background-position                                         | 背景位置         |
| background-attachment                                       | 背景固定还是滚动 |
| 背景的和写(复合属性)                                        |                  |
| background:背景颜色 背景图片地址 背景平铺 背景滚动 背景位置 |                  |

示例:

```css
background-color: pink;
background-image: url(images/jpg);
background-repeat: no-repeat;
background-position: left top; /*默认左上角*/
background-position: bottom right; /*方位名词没有顺序,谁在前都可以*/
background-position: center center; 
background-position: left; /*方位名词只写一个,另外一个默认为center*/
background-position: 10px 10px; /*精确单位第一值一定是x坐标,第二个值一定是y坐标*/
background-position: 10px center;/*方位名词和精确单位是可以混搭的*/
```



## 背景附着

语法:

```css
background-attachment: scroll|fixed
```

参数:

scroll: 背景图像是随对象内容滚动

fixed: 背景图像固定

说明:

设置或检索背景图像是随对象内容滚动还是固定的



## 背景简写

background属性的值的书写顺序官方并没有强制标准的。为了可读性,建议大家如下写:

background: 背景颜色 背景图片地址 背景平铺 背景滚动 背景位置

```css
background: #000 url(images/ms.jpg) repeat-y scroll center -15px;
```



## 背景透明(CSS3)

CSS3支持背景半透明的写法语法格式是:

```css
background: rgba(0,0,0,0,3)
```

最后一个参数是alpha透明度 取值范围0~1之间

注意: 背景半透明是指盒子背景半透明,盒子里面的内容不收影响

同样,可以给文字和边框透明 都是rgba的格式来写



## 背景缩放(CSS3)

通过background-size设置背景图片的尺寸,就像我们设置img的尺寸一样,在移动web开发中做屏幕适配应用广泛。

其参数设置如下:

a)可以设置长度单位(px)或百分比(设置百分比时,参照盒子的宽度)

b)设置cover时,会自动调整缩放比例,保证图片始终填充满背景区域,如有溢出部分则会被隐藏

c)设置contain会自动调整缩放比例,保证图片完整显示在背景区域

```css
backgroud-image: url('images/gyt.jpg')
background-size: 300px 100px;
/* background-size: contain; */
/* background-size: cover; */
```

我们插入的图片img直接通过width和height设置即可

背景图片设置大小我们尽量只改一个值,防止缩放失真扭曲



## 多背景(CSS3)

以逗号分割可以设置多背景,可用于自适应布局做法就是用逗号隔开就好了

- 一个元素可以设置多重背景图像
- 每组属性间使用逗号分割
- 如果设置的多重背景图之间存在着交集(即存在重叠关系),前面的背景图会覆盖在后面的背景图之上
- 为了避免背景色将图像盖住,背景色通常都定义在最后一组上

```css
background: url(test1.jpg) no-repeat scroll 10px 20px/50px 60px,
			url(test2.jpg) no-repeat scroll 10px 20px/70px 90px,
			url(test2.jpg) no-repeat scroll 10px 20px/110px 130px c #aaa;
```



## 凹凸文字

```html
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <style>
            body {
                background-color
            }
            div {
                font: 700 80px "微软雅黑";
                color: #ccc;
            }
            div:first-child {
                text-shadow: 1px 1px 1px #000,
                    		 -1px -1px 1px #fff;
            }
            div:last-child {
                text-shadow: -1px -1px 1px #000,
                    		 1px 1px 1px #fff;
            }
        </style>
    </head>
    <body>
        <div>我是凸起的文字</div>
        <div>我是凹下的文字</div>
    </body>
</html>
```

## 导航栏案例



文本的装饰

text-decoration 通常我们用于给链接修改装饰效果

| 值           | 描述                   |
| ------------ | ---------------------- |
| none         | 默认 定义标准的文本    |
| underline    | 定义文本下的一条线     |
| overline     | 定义文本上的一条线     |
| line-through | 定义穿过文本下的一条线 |

**使用技巧**:  在一行内的盒子内,我们设定行高等于盒子的高度,就可以使用文字垂直居中

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-color: #000;
        }
        a {
            width: 200px;
            height: 50px;
            /* background-color: orange; */
            display: inline-block;
            text-align: center;
            line-height: 50px;
            color: #fff;
            font-size: 22px;
            text-decoration: none;
        }
        a:hover {
            background: url(images/1123.gif) no-repeat;
        }
    </style>
</head>
<body>
    <a href="#">专区说明</a>
    <a href="#">申请资格</a>
    <a href="#">兑换奖励</a>
    <a href="#">下载游戏</a>
</body>
</html>
```




# CSS三大特性

## CSS层叠性

## CSS继承性

## CSS优先级

## CSS特殊性(Specificity)

# 盒模型(CSS重点)

看透网页布局的本质

盒子模型

