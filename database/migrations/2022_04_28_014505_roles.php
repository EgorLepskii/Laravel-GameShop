<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Roles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles',function (Blueprint $table){
            $table->id();
            $table->integer('type');
            $table->string('name');
            $table->timestamps();
        });

        foreach (Role::ROLES as $key => $role) {
            DB::table('roles')->insert(
                ['name' => $key, 'type' => $role]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
