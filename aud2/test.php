<?php
$foo = "0\n";
echo $foo;
$foo += 2;
echo $foo . "\n";
var_dump($foo == 2);
var_dump($foo === "2");
$foo = null;
var_dump($foo);
$strings = "ana,banana,ananas";
$exploded = explode(",", $strings);
print_r($exploded);
print(substr("hello world", 6, 5));
$array = [1 => "value1", 2 => "value2", 3 => "value3"];
foreach ($array as $key => $val)
    print "$key => $val\n";

function getneso($array)
{
    return array_map(
        fn($p) => $p["name"],
        array_filter($array, fn($p) => $p["inStock"]));
}

function average(string | array $array) {
    $prices = array_map(fn($p) => $p["price"], $array);
    return array_sum($prices) / count($prices);
}

$products = [
    ["name" => "Keyboard", "price" => 30, "inStock" => true],
    ["name" => "Mouse", "price" => 15, "inStock" => false],
    ["name" => "Monitor", "price" => 120,"inStock" => true],
    ["name" => "USB Cable", "price" => 8, "inStock" => false],
];
array_multisort($products);
print_r($products);
usort($products, fn($a, $b) => $a["price"] <=> $b["price"]);
print_r($products);
$products = [
    ["name" => "Keyboard", "price" => 30],
    ["name" => "Mouse", "price" => 15],
    ["name" => "Monitor", "price" => 120],
    ["name" => "USB Cable", "price" => 8],
];
array_walk($products, function (&$p) {
    $p["price"] *= 2;
});
print_r($products);
$products = [
    "name4" => "Keyboard",
    "name2" => "Mouse",
    "name3" => "Monitor",
    "name1" => "USB Cable",
];
print_r(next($products));
print_r(reset($products));
print_r(end($products));
print_r(current($products));
sort($products);
print_r($products);
asort($products);
print_r($products);
ksort($products);
print_r($products);
krsort($products);
print_r($products);

echo "<h1>Hello</h1>";
phpinfo();