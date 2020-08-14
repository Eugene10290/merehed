<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'books', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('name');

            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')
                ->references('id')
                ->on('authors')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('pages_number');
            $table->text('annotation');
            $table->longText('image_path');

            $table->timestamps();
        }
        );
        /*$data = [];

        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'user_id' => 1,
                'name' => "Name $i",
                'author_id' => "$i",
                'pages_number' => rand(40, 700),
                'annotation' => "annotation $i"
            ];
        }

        DB::table('books')->insert($data);*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
