<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        Schema::create('user_types', function($table) {
            $table->increments('id');
            $table->enum('type', ['admin', 'user']);
            $table->timestamps();
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('user_type_id')->constrained();
        });
        


        Schema::create('films', function($table) {
            $table->increments('id');
            $table->string('movie_duration');
            $table->string('categories'); //Action, Drama, Thriller
            $table->enum('available_screens', ['2D', '3D']);
            $table->enum('tickets_availability', ['yes', 'no']);
            $table->timestamps();
        });

        Schema::create('showrooms', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('location');
        });


        Schema::create('film_schedules', function($table) {
            $table->increments('id');
            $table->foreignId('film_id')->constrained();
            $table->foreignId('showroom_id')->constrained();
            $table->date('date');
            $table->time('time'); 
            $table->double('price');
            $table->timestamps();
        });

        Schema::create('seat_types', function($table) {
            $table->increments('id');
            $table->string('name'); //Vip, //Normal, Excutive etc...
            $table->integer('percentage')->default(0);
            $table->timestamps();
        });

        Schema::create('seats', function($table) {
            $table->increments('id');
            $table->foreignId('seat_type_id')->constrained();
            $table->string('row'); //A, B, C, D...
            $table->integer('number');
            $table->timestamps();
        });


        Schema::create('tickets', function($table) {
            $table->increments('id');
            $table->foreignId('film_schedule_id')->constrained();
            $table->integer('no_of_seats');
            $table->timestamps();
        });
        
        Schema::create('ticket_details', function($table) {
            $table->increments('id');
            $table->foreignId('ticket_id')->constrained();
            $table->foreignId('seat_id')->constrained();
            $table->timestamps();
        });



       // throw new \Exception('implement in coding task 4, you can ignore this exception if you are just running the initial migrations.');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
