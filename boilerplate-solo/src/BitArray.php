<?php declare(strict_types=1);

class BitArrayIterator implements Iterator {
    private array $bits;
    private int $position = 0;

    public function __construct(array $bits) {
        $this->bits = $bits;
    }

    public function current(): int {
        return $this->bits[$this->position];
    }

    public function key(): int {
        return $this->position;
    }

    public function next(): void {
        $this->position++;
    }

    public function rewind(): void {
        $this->position = 0;
    }

    public function valid(): bool {
        return isset($this->bits[$this->position]);
    }
}

class BitArray implements ArrayAccess, Countable, IteratorAggregate, Stringable {
    private array $bits = [];  

    // Constructeur vide
    public function __construct() {}

    public static function fromString(string $from): self {
        $bitArray = new self();
        $from = ltrim($from, "0b");  
        $bitArray->bits = str_split($from);
        return $bitArray;
    }

    // Méthode statique fromInt : convertit un entier en BitArray
    public static function fromInt(int $from): self {
        return self::fromString(decbin($from));  
    }

    public function slice(int $start = 0, int $length = -1): self {
        $slice = array_slice($this->bits, $start, $length);
        $bitArray = new self();
        $bitArray->bits = $slice;
        return $bitArray;
    }

    public function set(array $bits, int $start = 0): void {
        foreach ($bits as $index => $bit) {
            $this->bits[$start + $index] = $bit;
        }
    }

    public function unset(int $start, int $length = -1): void {
        $length = $length === -1 ? count($this->bits) - $start : $length;
        for ($i = 0; $i < $length; $i++) {
            $this->bits[$start + $i] = 0;
        }
    }

    public function offsetExists(mixed $offset): bool {
        return isset($this->bits[$offset]);
    }

    public function offsetGet(mixed $offset): int {
        return $this->bits[$offset] ?? 0; 
    }

    public function offsetSet(mixed $offset, mixed $value): void {
        $this->bits[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void {
        unset($this->bits[$offset]);
    }

    public function count(): int {
        return count($this->bits);
    }

    public function getIterator(): BitArrayIterator {
        return new BitArrayIterator($this->bits);
    }

    public function __toString(): string {
        return implode('', $this->bits);  
    }
}

