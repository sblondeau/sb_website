<?php

namespace App\Entity;

use App\Enum\BlockOrientation;
use LogicException;

class SnakeBlock
{
    private string $position = 'H';

    public function __construct(private int $x, private int $y)
    {
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        if (!in_array(BlockOrientation::tryFrom($position), BlockOrientation::cases())) {
            throw new LogicException('Wrong block position');
        }

        $this->position = $position;

        return $this;
    }
}
