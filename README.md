# DentistClinic
PHP课程设计，基于某牙齿矫治器定制厂家的网站

# 使用说明
## 配置数据库
### 创建数据库
首先在本地创建一个数据库，库名`dentist_clinic`，字符集`utf8mb4`，排序规则`utf8mb4_unicode_ci`，可以使用navicat直接创建，也可以直接复制下面建库的语句：
```sql
CREATE DATABASE `dentist_clinic` CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci';
```
### 创建数据表
复制`sql`文件夹中`dentist_clinic.sql`里面的所有代码并执行，完成数据表的创建
### 修改账号密码
`php`文件夹下面有个`PDOO.php`，修改下面的代码：
```php
// 数据库用户，默认root用户
private $user   = 'root';
// 用户密码，这里修改成你本地数据库的密码
private $pass   = '你的密码';
```
## 配置虚拟映射
### 修改apache配置文件
找到apache目录下的`httpd-vhosts.conf`文件，一般位于`Apache\conf\extra`目录下，在文件最后新增下面的代码（建议修改前先拷贝文件副本）：
```apacheconfig
<VirtualHost dentist-clinic.com:80>
    DocumentRoot "D:\GitHub\DentistClinic"
    ServerName dentist-clinic.com
    ServerAlias www.dentist-clinic.com
</VirtualHost>
```
**代码说明**：
上面配置了一个`dentist-clinic.com`假的域名，其绝对路径为`D:\GitHub\DentistClinic`，这里的路径就是项目的路径 
### 添加host映射
打开host文件，目录在`C:\Windows\System32\drivers\etc`中，在文件最后一行添加下面的映射关系：
```text
127.0.0.1 dentist-clinic.com
```
### 重启Apache
重启phpstudy或者wamp，在浏览器输入`http://dentist-clinic.com/php/Test.php`，不出意外的话，会出现一下的内容：
```text
{"status":0,"result":"\u65e0\u53c2\u8bf7\u6c42\u6d4b\u8bd5\u6210\u529f"}
```
浏览器输入`http://dentist-clinic.com/web/index.html`，可以看到牙医主页，即表示配置成功。

## 接口说明
### 请求格式
统一使用POST请求，Test.php接口除外（Test.php可以使用get或者post）
### 接口格式
接口返回的都是json格式，如下是查询病例id为2返回的数据：
```json
{
    "status": 0,
    "result": [
        {
            "id": "2",
            "name": "何梓涛",
            "note": "PE：B4（牙合）面畸形中央尖，已完全磨损，露髓，探痛（++），冷痛（++），松动（-）。行全口常规检查发现E3E4滞留；A3弓外牙，腭侧完全萌出；A4未见，E4颊侧牙龈可见隆起明显，触之较硬，无压痛。 A3A4区牙片及全口CT示：E3牙根短小，E4牙根吸收至颈部，A4完全埋藏于骨内，根尖紧贴于上颌窦底。\n"
        }
    ]
}
```
### status值说明
 - 0：表示数据处理成功，如成功新增用户
 - 1：表示数据处理失败，失败信息请看result值
 - 2：表示能够正常执行，但是可能找不到返回值，如查找一个不存在的用户
### result值说明
result表示当前回调的结果，当status为0时，会返回预期的数据；status为1时会返回错误信息；status为2时，会对当前情况进行说明

## 牙医接口
### 牙医登录
 - url：http://dentist-clinic.com/php/Dentist.php
 - form：这里为form-data格式，具体参数如下
 ```text
operate:login     // operate是调接口必备的参数，这里表示要请求登录操作
username:1234     // 账户名参数
password:1234     // 用户密码参数
```
 
### 牙医注册
 - url：http://dentist-clinic.com/php/Dentist.php
 - form：这里为form-data格式，具体参数如下
 ```text
operate:register  // operate是调接口必备的参数，这里表示要请求注册操作
username:1234     // 账户名参数
password:1234     // 用户密码参数
sex:男            // 性别
name:何梓涛       // 牙医名字
location:xx诊所   // 所属诊所
```

### 牙医资料查询
 - url：http://dentist-clinic.com/php/Dentist.php
 - form：这里为form-data格式，具体参数如下
 ```text
operate:find      // operate是调接口必备的参数，这里表示要请求查询资料操作
username:1234     // 账户名参数
```
 
### 牙医信息更新
 - url：http://dentist-clinic.com/php/Dentist.php
 - form：这里为form-data格式，具体参数如下
 ```text
operate:update    // operate是调接口必备的参数，这里表示要请求更新操作
username:1234     // 账户名参数
password:1234     // 用户密码参数
sex:男            // 性别
name:何梓涛       // 牙医名字
location:xx诊所   // 所属诊所
profile:简介      // 简介信息
```

## 管理员接口
### 管理员注册
 - url：http://dentist-clinic.com/php/Admin.php
 - form：这里为form-data格式，具体参数如下
 ```text
operate:register  // operate是调接口必备的参数，这里表示要请求注册操作
username:1234     // 用户名参数
password:1234     // 用户密码参数
```
 
### 管理员登录
 - url：http://dentist-clinic.com/php/Admin.php
 - form：这里为form-data格式，具体参数如下
 ```text
operate:login     // operate是调接口必备的参数，这里表示要请求登录操作
username:1234     // 用户名参数
password:1234     // 用户密码参数
```

### 管理员删除
 - url：http://dentist-clinic.com/php/Admin.php
 - form：这里为form-data格式，具体参数如下
 ```text
operate:delete    // operate是调接口必备的参数，这里表示要请求删除操作
username:1234     // 用户名参数
password:1234     // 用户密码参数
```
 
### 管理员更新
 - url：http://dentist-clinic.com/php/Admin.php
 - form：这里为form-data格式，具体参数如下
 ```text
operate:update    // operate是调接口必备的参数，这里表示要请求更新操作
username:1234     // 用户名参数
password:1234     // 旧的用户密码参数
new_password:1235 // 新的用户密码参数
```
 
## 病例接口
### 查询所有病例
 - url：http://dentist-clinic.com/php/Case.php
 - form：这里为form-data格式，具体参数如下
 ```text
operate:query     // operate是调接口必备的参数，这里表示要请求查询所有病例操作
```
 
### 查询指定id的病例
 - url：http://dentist-clinic.com/php/Case.php
 - form：这里为form-data格式，具体参数如下
 ```text
operate:find      // operate是调接口必备的参数，这里表示要请求查询指定id病例操作
id:1              // 病例id
```

### 病例添加
 - url：http://dentist-clinic.com/php/Case.php
 - form：这里为form-data格式，具体参数如下
 ```text
operate:add       // operate是调接口必备的参数，这里表示要请求添加病例操作
name:何梓涛       // 患者姓名
sex:男            // 患者性别
born_year:1999    // 患者出生年
note:冷痛（++）   // 备注
status:已出院     // 状态
treatment_plan:xx // 治疗方案
```
 
### 病例删除
 - url：http://dentist-clinic.com/php/Case.php
 - form：这里为form-data格式，具体参数如下
 ```text
operate:delete    // operate是调接口必备的参数，这里表示要请求删除指定id病例操作
id:1              // 病例id
```
 
### 病例修改
 - url：http://dentist-clinic.com/php/Case.php
 - form：这里为form-data格式，具体参数如下
 ```text
operate:update    // operate是调接口必备的参数，这里表示要请求更新病例操作
name:何梓涛       // 患者姓名
sex:男            // 患者性别
born_year:1999    // 患者出生年
note:冷痛（++）   // 备注
status:已出院     // 状态
treatment_plan:xx // 治疗方案
id:1              // 病例id
```