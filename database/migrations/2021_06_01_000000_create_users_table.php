<?php

use eDreams\Database\Utilities\AbstractMigration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateUsersTable.
 *
 * This class will create the Users table.
 */
class CreateUsersTable extends AbstractMigration
{
    /**
     * @var string TABLE_NAME - The name of the table that is going to be created.
     */
    const TABLE_NAME = 'users';

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
                $table->string('name')
                    ->comment('Name of the User.');
            });
        }

        echo "Users table created with success\n";
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

            echo "Players table dropped with success\n";
        }
    }
}