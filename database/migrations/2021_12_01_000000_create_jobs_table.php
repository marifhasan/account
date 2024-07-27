<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number')->nullable();
            $table->decimal('amount', 14, 2)->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('expected_date')->nullable();
            $table->timestamp('delivery_date')->nullable();

            $table->decimal('vat_rate', 4, 2)->nullable();
            $table->enum('vat_type', ['including', 'excluding'])->default('including');

            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
