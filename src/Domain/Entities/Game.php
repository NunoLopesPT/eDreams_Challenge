<?php

namespace eDreams\Domain\Entities;

use eDreams\Domain\ValueObjects\TicTacToe\Position;
use eDreams\Domain\ValueObjects\TicTacToe\Move;

class Game
{
    private ?int $id;

    private User $user1;
    private User $user2;

    /**
     * @var Move[] $moves
     */
    private array $moves;

    private ?User $winner;
    private bool $isFinished;

    public function __construct(
        User $user1,
        User $user2,
        ?User $winner,
        bool $isFinished,
        array $squares,
        int $id = null
    ) {
        $this->user1 = $user1;
        $this->user2 = $user2;
        $this->winner = $winner;
        $this->isFinished = $isFinished;
        $this->moves = $squares;
        $this->id = $id;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function user1(): User
    {
        return $this->user1;
    }

    public function user2(): User
    {
        return $this->user2;
    }

    public function winner(): User
    {
        return $this->winner;
    }

    public function winnerId(): ?int
    {
        if ($this->winner === null) {
            return null;
        }

        return $this->winner->id();
    }

    /**
     * Check if anyone already played a move on given position.
     *
     * @param Position $position
     *
     * @return bool
     */
    public function isFilled(Position $position): bool
    {
        foreach ($this->moves as $move) {
            if ($move->position()->isEquals($position)) {
                return true;
            }
        }

        return false;
    }

    public function isFinished(): bool
    {
        return $this->isFinished;
    }

    /**
     * Set game as finished, if no winner then it was a draw.
     *
     * @param User|null $winner
     */
    public function setFinished(User $winner = null): void
    {
        $this->winner = $winner;
        $this->isFinished = true;
    }

    public function makeMove(Move $square): void
    {
        $this->moves[] = $square;
    }

    public function moves(): array
    {
        return $this->moves;
    }
}