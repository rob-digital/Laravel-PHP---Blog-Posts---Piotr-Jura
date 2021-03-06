<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleContentToBlogpostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogpost', function (Blueprint $table) {
            $table->string('title')->default('');

            if(env('DB_CONNECTION') === 'sqlite_testing'){
                $table->text('content')->default('');
            } else {
            $table->text('content');
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogpost', function (Blueprint $table) {
            $table->dropColumn(['title', 'content']);
        });
    }
}
