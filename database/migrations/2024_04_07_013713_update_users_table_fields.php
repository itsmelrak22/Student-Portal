<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after("name");
            $table->integer('department_id')->after("email")->default(0);
            $table->enum('role', ['Admin', 'Registrar', 'Professor', 'Student', 'Adviser'])->after("email")->nullable();
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_username_unique');
            $table->dropColumn('username');
            $table->dropColumn('department_id');
            $table->dropColumn('role');
            $table->dropColumn('deleted_at');
        });
    }
}
