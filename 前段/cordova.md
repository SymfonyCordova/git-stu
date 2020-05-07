# 环境搭建
```reStructuredText
http://tools.android-studio.org/index.php/sdk
安装java,android-sdk
vim /etc/profile
    export JAVA_HOME=/usr/java/jdk1.8.0_201
    export JRE_HOME=${JAVA_HOME}/jre
    export MAVEN_HOME=/usr/maven/apache-maven-3.6.1
    export CLASSPATH=.:${JAVA_HOME}/lib:${JRE_HOME}/lib:$CLASSPATH
    export JAVA_PATH=${JAVA_HOME}/bin:${JRE_HOME}/bin
    export ANDROID_HOME=/usr/android-sdk-linux/android-sdk-linux
    export PATH=${ANDROID_HOME}/tools:${ANDROID_HOME}/platform-tools:${JAVA_PATH}:$PATH:/usr/gradle/gradle-5.2.1/bin:${MAVEN_HOME}/bin
source /etc/profile 

android update sdk --no-ui
android list sdk --all
android update sdk -u --all --filter 1,2,3,5,11,12,22,23,24,25,26,27,28,29,88,89  

sudo npm install -g cordova
cordova com.zler
cd com.zler
cordova platform add ios
cordova platform add android
```



Onsen UI (官方推荐一款UI)

```reStructuredText
npm install onsenui --save
npm install onsenui react-onsenui --save
https://onsen.io/v2/api/react/Carousel.html
```



字体

```reStructuredText
https://fontawesome.com/

http://zavoloklom.github.io/material-design-iconic-font/icons.html
```

