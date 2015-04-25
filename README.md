Google Chart
============
A wraper for google chart

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require scott-hzl/yii2-google-chart "dev-master"
```

or add

```
"scott-hzl/yii2-google-chart": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
use scotthuangzl\googlechart\GoogleChart;
    echo GoogleChart::widget(array('visualization' => 'PieChart',
        'data' => array(
            array('Task', 'Hours per Day'),
            array('Work', 11),
            array('Eat', 2),
            array('Commute', 2),
            array('Watch TV', 2),
            array('Sleep', 7)
        ),
        'options' => array('title' => 'My Daily Activity')));

```