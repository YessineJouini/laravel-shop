<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
    
            // single FK definition with cascade:
            $table->foreignId('user_id')
                  ->constrained()         // references id on users
                  ->onDelete('cascade');  // drop addresses when user is deleted
    
            // enum for billing vs. shipping
            $table->enum('type', ['billing', 'shipping']);
            $table->string('line1');
            $table->string('line2')->nullable();
            $table->string('city');
            $table->string('zip');
            $table->string('country');
            $table->timestamps();
        });
    }
    
    

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};

