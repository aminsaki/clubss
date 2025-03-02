<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inovices', function (Blueprint $table) {
            $table->id();
            $table->string('softcode')->nullable();
            $table->string('newKits')->nullable();
            $table->string('billCode')->nullable();
            $table->string('siteId')->nullable();
            $table->string('partyName')->nullable();
            $table->string('partyFamily')->nullable();
            $table->string('partyAddress')->nullable();
            $table->string('partyTell')->nullable();
            $table->string('partyMobile')->nullable();
            $table->string('partyJobId')->default(0);
            $table->string('partyType')->default(0);
            $table->string('isRemote')->nullable();
            $table->string('seprateId')->default(22);
            $table->string('partyStateCode')->default(100);
            $table->string('postCode')->nullable();
            $table->string('serial')->nullable();
            $table->string('factor')->nullable();
            $table->string('tnc_order_type')->nullable();
            $table->string('tnc_uuid')->nullable();
            $table->string('response')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inovices');
    }
};
