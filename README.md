# yii2-dbtable-iterate

iterate rows from table, specially for big tables that will cause php memory limit error.

遍历数据库表，尤其是会导致php内存错误的大表

Installation安装步骤：
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).推荐使用composer

Either run命令行输入并运行

```
php composer.phar require "postor/yii2-dbtable-iterate" "*"
```

or add或者在配置文件composer.json中添加

```
"postor/yii2-dbtable-iterate": "*"
```

to the require section of your `composer.json` file.

Usage使用方法:
------


```php

// commands/HelloController.php
namespace app\commands;
use app\models\Article;
use postor\dbtableiterate\DbTableIterate;
use yii\console\Controller;

class HelloController extends Controller
{
    public function actionIndex()
    {
        new DbTableIterate(Article::find()->offset(3)->limit(5),function($row){
        	echo $row->id.',';
        },3);
    }
}

```
