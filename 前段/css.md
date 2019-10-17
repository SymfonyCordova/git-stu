## 什么是css3
    在编写CSS3样式时，不同的浏览器可能需要不同的前缀。
    它表示该CSS属性或规则尚未成为W3C标准的一部分，是浏览器的私有属性，
    虽然目前较新版本的浏览器都是不需要前缀的，但为了更好的向前兼容前缀还是少不了的。
    前缀        浏览器
    -webkit chrome和safari
    -moz    firefox
    -ms     IE
    -o      opera

## CSS3边框 圆角效果 border-radius
    border-radius:10px; /* 所有角都使用半径为10px的圆角 */
    border-radius: 5px 4px 3px 2px; /* 四个半径值分别是左上角、右上角、右下角和左下角，顺时针 */ 
    不要以为border-radius的值只能用px单位，你还可以用百分比或者em，但兼容性目前还不太好.
    
    实心上半圆
    .semicircle{
    height:50px;/*是width的一半*/
    width:100px;
    background:#9da;
    border-radius:50px 50px 0 0;/*半径至少设置为height的值*/
    }

    实心圆
    .solidcircle{
        height:100px;/*与width设置一致*/
        width:100px;
        background:#9da;
        border-radius:50px;/*四个圆角值都设置为宽度或高度值的一半*/
    }

    实心左半圆形
    .leftcircle{
        height:100px;
        width:50px;
        background:#9da;
        border-radius:50px 0 0 50px;
    }

## CSS3边框 阴影 box-shadow
    
## 动画
    开始给div一个初始的属性值比如width
    给出一个动画结束时的属性
    动画属性可以给出就是告诉div再放生变化时的时间和以什么方式进行
    动画的属性定以在开始或者结束里面

    描述动画的运行属性(运行时间,次数等)
        transition(过渡)
        animations(动画)
    描述动画的执行属性(参与动画的属性、效果等)
        trsansform(变形)--translate 