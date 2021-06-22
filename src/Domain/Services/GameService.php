<?php

namespace eDreams\Domain\Services;

use eDreams\Domain\Contracts\Repositories\GameRepository;
use eDreams\Domain\Entities\Game;
use eDreams\Domain\Entities\User;
use eDreams\Domain\Exceptions\Game\ColumnOffLimitsNumberException;
use eDreams\Domain\Exceptions\Game\GameIsAlreadyFinishedException;
use eDreams\Domain\Exceptions\Game\PositionWithAMoveAlready;
use eDreams\Domain\Exceptions\Game\RowOffLimitsNumberException;
use eDreams\Domain\ValueObjects\TicTacToe\Move;
use eDreams\Domain\ValueObjects\TicTacToe\Position;

class GameService
{
    private GameRepository $gameRepository;

    /** @var int N */
    private const N = 3;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function getById(int $id): Game
    {
        return $this->gameRepository->getById($id);
    }

    public function startGame(User $user1, User $user2): Game
    {
        $game = new Game($user1, $user2, null, false, []);

        return $this->gameRepository->create($game);
    }

    public function makePlay(Game $game, Position $position): void
    {
        if ($game->isFinished()) {
            throw new GameIsAlreadyFinishedException();
        }

        if ($position->column() >= self::N) {
            throw new ColumnOffLimitsNumberException();
        }

        if ($position->row() >= self::N) {
            throw new RowOffLimitsNumberException();
        }

        if ($game->isFilled($position)) {
            throw new PositionWithAMoveAlready();
        }

        // Decide which player is to play
        if (count($game->moves()) % 2 === 0) {
            $user = $game->user1();
        } else {
            $user = $game->user2();
        }

        $move = new Move(
            $position,
            $user
        );

        // Mark the square in the game.
        $game->makeMove($move);

        // Check if with the last square the player.
        if ($this->isGameFinished($game, $move)) {
            $game->setFinished($user);
        }

        // If all squares are filled, then the game finished without a winner (draw).
        if (count($game->moves()) === self::N * self::N) {
            $game->setFinished();
        }

        $this->gameRepository->update($game);
    }

    /**
     * Given the last square filled in the game, we will calculate if it fills the
     * entire row, column, left or right diagonal.
     *
     * @param Game $game
     * @param Move $lastFilledSquare
     *
     * @return bool
     */
    public function isGameFinished(Game $game, Move $lastFilledSquare): bool
    {
        $row = 0;
        $column = 0;
        $leftDiagonal = 0;
        $rightDiagonal = 0;

        foreach ($game->moves() as $move) {

            // All the squares that this user filled.
            if ($move->user()->id() === $lastFilledSquare->user()->id()) {

                if ($move->position()->column() === $lastFilledSquare->position()->column()) {
                    $column++;
                }

                if ($move->position()->row() === $lastFilledSquare->position()->row()) {
                    $row++;
                }

                if ($move->position()->column() === $move->position()->row()) {
                    $leftDiagonal++;
                }

                if ($move->position()->column() + $move->position()->row() === self::N - 1) {
                    $rightDiagonal++;
                }
            }
        }

        return \in_array(self::N, [$row, $column, $leftDiagonal, $rightDiagonal]);
    }
}
