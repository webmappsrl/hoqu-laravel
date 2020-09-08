<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldProcessStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('queues', function (Blueprint $table) {
            DB::statement("ALTER TABLE queues MODIFY COLUMN process_status ENUM('new','duplicate', 'processing', 'done','error') NOT NULL DEFAULT 'new'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('queues', function (Blueprint $table) {
            DB::statement("ALTER TABLE queues MODIFY COLUMN process_status ENUM('new', 'processing', 'done','error') NOT NULL DEFAULT previous_default_column");
        });
    }
}
