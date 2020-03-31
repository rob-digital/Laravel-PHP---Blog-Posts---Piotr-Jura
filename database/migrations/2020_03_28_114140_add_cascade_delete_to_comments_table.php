<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeDeleteToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // deleting a model on DB level
        Schema::table('comments', function (Blueprint $table) {

            // Way2 - delete a BlogPost and related comments
            $table->dropForeign(['blog_post_id']);  // drop the foreign key

            $table->foreign('blog_post_id')  // recreating the foreign key
                ->references('id')
                ->on('blog_posts')
                ->onDelete('cascade');  // deletes BlogPost and all related comments
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['blog_post_id']);  // drop the foreign key

            $table->foreign('blog_post_id')  // recreating the foreign key
                ->references('id')
                ->on('blog_posts');
        });
    }
}
