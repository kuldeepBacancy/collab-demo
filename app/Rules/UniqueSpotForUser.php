<?php

namespace App\Rules;

use App\Models\Spot;
use App\Models\SpotUser;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueSpotForUser implements ValidationRule
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        dd('here');
        // Fetch existing spots for the user
        $existingSpots = SpotUser::with('spot')->where('user_id', $this->userId)->get();

        // Check vehicle types
        $carSpots = $existingSpots->filter(fn($spotUser) => $spotUser->spot->vehicle_type->value == 1)->count();
        $scooterSpots = $existingSpots->filter(fn($spotUser) => $spotUser->spot->vehicle_type->value == 0)->count();
        // Fetch the vehicle type of the new spot being selected
        $newSpotType = Spot::find($value)?->vehicle_type;
        // dd($newSpotType->value == 0);
// dd($newSpotType);
        if ($newSpotType == null) {
            $fail('The selected spot does not exist.'); // Spot does not exist
            return;
        }

        if ($carSpots == 1 && $newSpotType->value == 1) {
            // dd('if');
            $fail('User already has a Car spot.'); // User already has a Car spot
            return;
        }
// dd('out');
        if ($scooterSpots == 1 && $newSpotType->value == 0) {
            // dd('if');
            $fail('User already has a Scooter spot.'); // User already has a Scooter spot
            return;
        }
// dd('out');
        if ($carSpots == 1 && $scooterSpots == 1) {
            $fail('User has both types of spots.'); // User has both types
            return;
        }

        // Validation passes, no need to call $fail
    }

    public function message()
    {
        return 'The selected spot conflicts with existing spots for the user.';
    }
}
