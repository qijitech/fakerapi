## composer install

执行该命令后：

1. 项目根目录下会新建一个 vendor 文件夹
2. 命令会将 composer.json 写的一些 lib 下载到 vendor 文件夹下

## composer dump-autoload

- 加载 app/helpers.php；
- 见 composer.json 的 autoload。

## cp .env.example .env

复制 .env.example 并新建一个 .env 文件

## php artisan jwt:secret

- 该命令会输出一个 jwt key
- 然后写入 .env 文件，即更改 JWT_SECRET 的值
- 更改文件速度有可能会迟钝，不会立即生效，耐心等待时间即可

## php artisan key:generate

- 执行该命令会输出：Application key [XXXXXX] set successfully.
- 复制中括号里面的字符串，粘贴到 .env 文件的 APP_KEY 等于号后面

## 修改 .env 文件的 APP_KEY

- 值为上一个命令得到了 key

## 修改 .env 数据库配置

- DB_CONNECTION 为你所使用的数据库类别，该项目使用 mysql，无需更改
- DB_HOST 为数据库访问的 IP，对于开发者，设置为 localhost 即可，无需更改
- DB_PORT 为数据库的访问端口，mysql 一般为 3306，无需更改
- DB_DATABASE 为该项目使用的数据库名称，我们定义为 tiku，如果本地数据无则新建一个 tiku 数据库
- DB_USERNAME 为数据库访问用户名，设置为你本地的数据库访问用户名即可
- DB_PASSWORD 为数据库用户的访问密码，设置为你本地的数据库访问用户密码即可

注意：

- 新建数据库的编码请使用 utf8mb4

## 新建 storage/logs/sql 文件夹

- Mac / Linux 命令：mkdir storage/logs/sql
- Windows：自己右键新建即可

如存在就不用新建了

## php artisan migrate

- 该命令会执行项目根目录 database/migrations 下文件代码，根据你本地数据库表情况执行对应的 migration
- 如果觉得创建出问题了，可以使用 php artisan migrate:rollback
- 更多命令，请看文档：https://laravel.com/docs/5.2/migrations
- 命令执行成后，你可以通过 mysql 命令行或 mysql gui 看到 tiku 数据库新添加了表格
- mysql gui，mac 推荐使用 Sequel Pro

## php artisan db:seed

- 如果提示：Class XxxSeeder does not exist，请使用命令 composer dump-atuoload
- 再查看 tiku 数据库，你会发现数据被添加到一些表中
- 具体代码请阅读 database/seeds 下面的 Seeds 代码文件

## 配置 nginx 的 conf

我的本地配置文件如下：

	server {
		listen       2001;
		server_name  localhost;
		root        /var/www/fakerapi/public/;

		access_log  /usr/local/etc/nginx/logs/fakerapi.access.log  main;

		include   /usr/local/etc/nginx/conf.d/php-fpm;

		location / {
				try_files $uri $uri/ /index.php?$query_string;
		}

		error_page  404    /var/www/404.html;
		error_page  403    /var/www/403.html;
	}

附: windows下WNMP配置: http://blog.qiji.tech/archives/5228

## tails -f storage/logs/sql/xxx-log.sql

- 执行这句若出现错误,可忽略
- 每个请求的 sql log 写入项目根目录 storage/logs/sql 下面
- Mac 电脑打开 Terminal，cd 到 log 的目录，使用该命令，就能看到你写的代码使用了什么 sql 语句
- 每次 sql 语句都会重新连接 mysql，尽量减少 sql 的查询

## 验证项目是否运行成功]
- 使用 postman 或者 chrome 发送 get 请求到:你的网址（fakerapi.qijitech.app）
- 若运行成功,则返回消息,"Lumen (5.2.7) (Laravel Components 5.2.*)"

