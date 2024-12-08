<?php declare(strict_types=1);

class FibonacciSequence implements Iterator {
    private array $sequence = [];
    private int $index = 0;
    private ?int $limit;

    public function __construct(?int $limit = null) {
        $this->limit = $limit;
    }

    public function current(): mixed {
        if (!isset($this->sequence[$this->index])) {
            $this->sequence[$this->index] = $this->fibonacci($this->index);
        }
        return $this->sequence[$this->index];
    }

    public function key(): mixed {
        return $this->index;
    }

    public function next(): void {
        $this->index++;
    }

    public function rewind(): void {
        $this->index = 0;
    }

    public function valid(): bool {
        return $this->limit === null || $this->index < $this->limit;
    }

    private function fibonacci(int $n): int {
        if (isset($this->sequence[$n])) {
            return $this->sequence[$n];
        }
        if ($n === 0) return 0;
        if ($n === 1) return 1;

        $this->sequence[$n] = $this->fibonacci($n - 1) + $this->fibonacci($n - 2);
        return $this->sequence[$n];
    }

    public static function first(int $n): self {
        return new self($n);
    }

    public static function range(int $start, int $length = -1): self {
        $iterator = new self();
        $iterator->index = $start;
        $iterator->limit = $length > 0 ? $start + $length : null;
        return $iterator;
    }
}

// Exemple 
$fibonacci = FibonacciSequence::first(10);
foreach ($fibonacci as $key => $value) {
    echo "Fibonacci[$key] = $value" . PHP_EOL;
}

$fibonacciRange = FibonacciSequence::range(5, 5);
foreach ($fibonacciRange as $key => $value) {
    echo "Fibonacci[$key] = $value" . PHP_EOL;
}
