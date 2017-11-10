<h1>Тестовое задание для соискателей на позицию PHP-developer Yii 2</h1>
<h2>Регулярные выражения</h2>

<?php

$arr = ['55.100', '55.01', '50.001', '55.0010', '50.00'];

echo "<pre>";
print_r($arr);
echo "</pre>";

$res = [];

foreach($arr as $num){
    $res[] = preg_replace('/[\.]*[0]+$/', '', $num);
}

echo "<pre>";
print_r($res);
echo "</pre>";

echo "<h2>".yii\helpers\Html::a('Задача на знание и понимание Yii/Yii2', ['category/index'])."</h2>";
?>
