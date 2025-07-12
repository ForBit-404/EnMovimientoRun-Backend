<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(){
        Schema::table('alumno', function (Blueprint $table) {
            if (Schema::hasColumn('alumno', 'edad')) {
                $table->dropColumn('edad');
            }
        });
    }

    public function down(){
        Schema::table('alumno', function (Blueprint $table) {
            $table->string('edad')->nullable(); // o el tipo que correspondía
        });
    }
};
