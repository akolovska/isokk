<?php

enum CoffeeType: string
{
    case ESPRESSO = "espresso";
    case LATTE = "latte";
    case AMERICANO = "americano";
}

enum TeaType: string
{
    case BLACK = "black";
    case GREEN = "green";
}

trait Discountable
{
    public function applyDiscount(float $amount): void
    {
        $this->price -= $amount;
    }
}

abstract class Beverage
{
    private string $name;
    private float $price;

    /**
     * @param string $name
     * @param float $price
     */
    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    abstract function calculateTotalPrice(int $quantity): float;
}

class Coffee extends Beverage
{
    use Discountable;

    private CoffeeType $coffeeType;

    /**
     * @param CoffeeType $coffeeType
     */
    public function __construct(string $name, float $price, CoffeeType $coffeeType)
    {
        parent::__construct($name, $price);
        $this->coffeeType = $coffeeType;
    }


    function calculateTotalPrice(int $quantity): float
    {
        return $this->price * $quantity;
    }
}

class Tea extends Beverage
{
    use Discountable;

    private TeaType $teaType;

    public function __construct(string $name, float $price, TeaType $teaType)
    {
        parent::__construct($name, $price);
        $this->teaType = $teaType;
    }


    function calculateTotalPrice(int $quantity): float
    {
        return $this->price * $quantity;
    }
}

class Order
{
    private array $items = [];

    function addItem(Beverage $beverage, int $quantity): void
    {
        $this->items[] = ['beverage' => $beverage, 'quantity' => $quantity];
    }

    function calculateOrderTotal(): float
    {
        $sum = 0;
        foreach ($this->items as $item)
            $sum += $item['beverage']->calculateTotalPrice($item['quantity']);
        return $sum;
    }
}

$coffee = new Coffee("Espresso", 140.0, CoffeeType::ESPRESSO);

$tea = new Tea("Green Tea", 100.0, TeaType::GREEN);

$coffee->applyDiscount(20.0);  // Apply a discount

$order = new Order();

$order->addItem($coffee, 2);  // 2 espresso

$order->addItem($tea, 1);     // 1 green tea

echo "Total order amount: " . $order->calculateOrderTotal() . " MKD";