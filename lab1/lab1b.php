<?php

enum Sector: string
{
    case TECHNOLOGY = "technology";
    case FINANCE = "finance";
    case HEALTHCARE = "healthcare";
    case ENERGY = "energy";
}

class StockPrice
{
    public string $date;
    public float $closed_price;
    public float $opened_price;
    public float $highest_price;
    public float $lowest_price;

    /**
     * @param string $date
     * @param float $closed_price
     * @param float $opened_price
     * @param float $highest_price
     * @param float $lowest_price
     */
    public function __construct(string $date, float $closed_price, float $opened_price, float $highest_price, float $lowest_price)
    {
        $this->date = $date;
        $this->closed_price = $closed_price;
        $this->opened_price = $opened_price;
        $this->highest_price = $highest_price;
        $this->lowest_price = $lowest_price;
    }

}

class Stock
{
    public string $ticker;
    public int $shares_outstanding;
    public Sector $sector;
    public array $stock_prices = [];

    /**
     * @param string $ticker
     * @param int $shares_outstanding
     * @param Sector $sector
     */
    public function __construct(string $ticker, int $shares_outstanding, Sector $sector)
    {
        $this->ticker = $ticker;
        $this->shares_outstanding = $shares_outstanding;
        $this->sector = $sector;
    }

    public function addStockPrice($stockPrice): void
    {
        if (isset($this->stock_prices[$stockPrice->date]))
            echo "There is already a historical price for this date for this stock";
        else
            $this->stock_prices[$stockPrice->date] = $stockPrice;
    }

    public function calculateMarketCapForDate($date): ?float
    {
        if (!isset($this->stock_prices[$date])) {
            echo "No historical price for this date for this stock";
            return null;
        } else {
             return $this->stock_prices[$date]->closed_price * $this->shares_outstanding;
        }
    }

    public function getLastClosedPrice(): ?float
    {
        $price = $this->stock_prices[count($this->stock_prices) - 1]->closed_price;
        if (!isset($price))
            return null;
        return $price;
    }

}

class StockExchange
{
    public string $exchange_name;
    public array $listed_stocks = [];

    /**
     * @param string $exchange_name
     */
    public function __construct(string $exchange_name)
    {
        $this->exchange_name = $exchange_name;
    }

    public function listStock($stock): void
    {
        $this->listed_stocks[] = $stock;
    }

    public function findStockByTicker($ticker): ?Stock
    {
        $var = $this->listed_stocks[$ticker];
        if (!isset($var)) {
            echo "Stock not found";
            return null;
        }
        else
            return $var;
    }
}

class Portfolio {
    public int $cash;
    public array $stockHoldings = [];

    /**
     * @param int $cash
     */
    public function __construct(int $cash)
    {
        $this->cash = $cash;
    }
    public function buyStock(string $ticker, int $numberOfShares, StockExchange $stockExchange): void {
        $stock = $stockExchange->findStockByTicker($ticker);
        if (!$stock) return;

        $price = $stock->getLastClosedPrice();
        if ($price === null) {
            echo "No price available for this stock\n";
            return;
        }

        $totalCost = $price * $numberOfShares;
        if ($totalCost > $this->cash) {
            echo "Insufficient cash to buy this stock\n";
            return;
        }

        // Deduct cash
        $this->cash -= $totalCost;

        // Add to holdings
        $found = false;
        foreach ($this->stockHoldings as $holding) {
            if ($holding['stock'] === $stock) {
                $holding['numberOfShares'] += $numberOfShares;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $this->stockHoldings[] = ['numberOfShares' => $numberOfShares, 'stock' => $stock];
        }

        echo "Bought $numberOfShares shares of $ticker for $totalCost USD on $stockExchange->exchange_name\n";
    }

    public function sellStock(string $ticker, int $numberOfShares, StockExchange $stockExchange): void {
        $stock = $stockExchange->findStockByTicker($ticker);
        if (!$stock) return;

        $price = $stock->getLastClosedPrice();
        if ($price === null) {
            echo "No price available for this stock\n";
            return;
        }

        // Find the holding
        foreach ($this->stockHoldings as $index => $holding) {
            if ($holding['stock'] === $stock) {
                if ($holding['numberOfShares'] < $numberOfShares) {
                    echo "Not enough shares to sell\n";
                    return;
                }

                $holding['numberOfShares'] -= $numberOfShares;
                if ($holding['numberOfShares'] === 0) {
                    unset($this->stockHoldings[$index]);
                    $this->stockHoldings = array_values($this->stockHoldings);
                }

                $totalValue = $price * $numberOfShares;
                $this->cash += $totalValue;
                echo "Sold $numberOfShares shares of $ticker for $totalValue USD on $stockExchange->exchange_name\n";
                return;
            }
        }

        echo "Not enough shares to sell\n";
    }
}
$applePrice1 = new StockPrice('01/01/2025', 100.0, 95.0, 102.0, 90.0);
$applePrice2 = new StockPrice('02/01/2025', 110.0, 100.0, 115.0, 98.0);
$applePrice3 = new StockPrice('03/01/2025', 120.0, 112.0, 125.0, 110.0);

$appleStock = new Stock('AAPL', 16000000000.0, Sector::TECHNOLOGY);
$appleStock->addStockPrice($applePrice1);
$appleStock->addStockPrice($applePrice2);
$appleStock->addStockPrice($applePrice3);

$microsoftStock = new Stock('MSFT', 7500000000.0, Sector::TECHNOLOGY);
$microsoftStock->addStockPrice(new StockPrice('01/01/2025', 300.0, 295.0, 310.0, 290.0));

$nasdaq = new StockExchange('NASDAQ');
$nasdaq->listStock($appleStock);
$nasdaq->listStock($microsoftStock);

echo "MarketCap 02/01/2025: ".($appleStock->calculateMarketCapForDate('02/01/2025') ?? 'null')." USD\n";

$portfolio = new Portfolio(10000.0);
$portfolio->buyStock('AAPL', 10, $nasdaq);
$portfolio->buyStock('MSFT', 5, $nasdaq);
$portfolio->buyStock('MSFT', 1000, $nasdaq);
$portfolio->sellStock('AAPL', 4, $nasdaq);
$portfolio->sellStock('MSFT', 50, $nasdaq);

echo "Cash: $portfolio->cash USD\n";
print_r($portfolio->stockHoldings);