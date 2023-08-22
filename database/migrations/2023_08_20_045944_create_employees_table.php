<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // database/migrations/xxxx_xx_xx_create_employees_table.php

    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('position_id')->constrained('positions');
            $table->date('hire_date');
            $table->string('phone_number');
            $table->string('email');
            $table->decimal('salary', 10, 2);
            $table->string('photo', 300)->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->foreign('manager_id')->references('id')->on('employees');
            $table->unsignedInteger('manager_level')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('admin_created_id')->nullable();
            $table->unsignedBigInteger('admin_updated_id')->nullable();

            $table->foreign('admin_created_id')->references('id')->on('users');
            $table->foreign('admin_updated_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
