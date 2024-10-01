<?php

use App\Enums\Common\Status;
use App\Enums\Vehicle\VehicleType;
use PHPUnit\Logging\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            if (!Schema::hasTable('companies')) {
                Schema::create('companies', function (Blueprint $table) {
                    $table->id();

                    $table->string('company_name', 100)->unique()->nullable()->index();
                    $table->boolean('status')->default(Status::Active->value)->comment(Status::Inactive->value . ' => Inactive, ' . Status::Active->value . ' => Active');

                    $table->softDeletes();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable('vehicle_models')) {
                Schema::create('vehicle_models', function (Blueprint $table) {
                    $table->id();

                    $table->unsignedBigInteger('company_id')->nullable();
                    $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

                    $table->string('model_name', 100)->unique()->nullable()->index();
                    $table->boolean('status')->default(Status::Active->value)->comment(Status::Inactive->value . ' => Inactive, ' . Status::Active->value . ' => Active');

                    $table->softDeletes();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable('vehicles')) {
                Schema::create('vehicles', function (Blueprint $table) {
                    $table->id();

                    $table->unsignedBigInteger('user_id')->nullable();
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

                    $table->unsignedBigInteger('company_id')->nullable();
                    $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

                    $table->unsignedBigInteger('vehicle_model_id')->nullable();
                    $table->foreign('vehicle_model_id')->references('id')->on('vehicle_models')->onDelete('cascade');

                    $table->boolean('vehicle_type')->default(VehicleType::Scooter->value)->comment(VehicleType::Scooter->value . ' => Scooter, ' . VehicleType::Car->value . ' => Car');
                    $table->string('vehicle_number', 20)->unique()->nullable()->index();
                    $table->boolean('status')->default(Status::Active->value)->comment(Status::Inactive->value . ' => Inactive, ' . Status::Active->value . ' => Active');

                    $table->softDeletes();
                    $table->timestamps();
                });
            }
        } catch (Exception $e) {
            echo "Something went wrong, check logs";
            Log::channel('migrationlogs')->error($e);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::dropIfExists('vehicles');
            Schema::dropIfExists('vehicle_models');
            Schema::dropIfExists('companies');
        } catch (Exception $e) {
            echo "Something went wrong, check logs";
            Log::channel('migrationlogs')->error($e);
        }
    }
};
