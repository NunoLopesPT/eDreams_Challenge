<?php

use eDreams\Database\Utilities\AbstractMigration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateGameTable.
 *
 * This class will create the Game table.
 */
class CreateGameTable extends AbstractMigration
{
    /**
     * @var string TABLE_NAME - The name of the table that is going to be created.
     */
    const TABLE_NAME = 'game';

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
                // Add table columns.
                $table->bigIncrements('id');

                $table->unsignedBigInteger('user1_id')
                    ->nullable(false);
                $table->foreign('user1_id')
                    ->references('id')
                    ->on('users')
                    ->cascadeOnDelete();

                $table->unsignedBigInteger('user2_id')
                    ->nullable(false);
                $table->foreign('user2_id')
                    ->references('id')
                    ->on('users')
                    ->cascadeOnDelete();

                $table->unsignedBigInteger('winner_id')
                    ->default(null)
                    ->nullable(true);

                $table->foreign('winner_id')
                    ->references('id')
                    ->on('users')
                    ->cascadeOnDelete();

                $table->boolean('is_finished')
                    ->nullable(false)
                    ->default(0);
            });
        }

        echo "Game table created with success\n";
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

            echo "Game table dropped with success\n";
        }
    }
}