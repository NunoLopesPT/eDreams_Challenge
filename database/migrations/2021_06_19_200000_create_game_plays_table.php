<?php

use eDreams\Database\Utilities\AbstractMigration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateGamePlaysTable.
 *
 * This class will create the Game Plays table.
 */
class CreateGamePlaysTable extends AbstractMigration
{
    /**
     * @var string TABLE_NAME - The name of the table that is going to be created.
     */
    const TABLE_NAME = 'game_plays';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only create table if it doesn't exist.
        if (!$this->schema->hasTable(self::TABLE_NAME)) {

            // Create table.
            $this->schema->create(self::TABLE_NAME, function (Blueprint $table) {

                $table->unsignedBigInteger('game_id')
                    ->nullable(false);
                $table->foreign('game_id')
                    ->references('id')
                    ->on('game')
                    ->cascadeOnDelete();

                $table->unsignedBigInteger('user_id')
                    ->nullable(false);
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->cascadeOnDelete();

                $table->tinyInteger('row', false, true)
                    ->nullable(false);
                $table->tinyInteger('column', false, true)
                    ->nullable(false);
            });
        }

        echo "Game Plays table created with success\n";
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ($this->schema->hasTable(self::TABLE_NAME)) {
            $this->schema->drop(self::TABLE_NAME);

            echo "Game Plays table dropped with success\n";
        }
    }
}