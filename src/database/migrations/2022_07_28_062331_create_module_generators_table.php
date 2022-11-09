<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleGeneratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_generators', function (Blueprint $table) {
            $table->id();
            $table->string('module_title');
            $table->string('module_description')->nullable();
            $table->string('controller_name');
            $table->string('database_table_name');
            $table->string('grid_table_type');
            $table->longText('configuration');
            $table->text('selfdata')->nullable();
            $table->string('selfdata_field_name')->nullable();
            $table->string('permission_title');
            $table->integer('softdelete')->default(1);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_generators');
    }
}
