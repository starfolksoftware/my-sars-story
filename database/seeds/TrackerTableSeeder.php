<?php

use Illuminate\Database\Seeder;
use App\Models\Tracker\Tracker;

class TrackerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Missing Person Tracker
        $tracker = new Tracker();
        $tracker->bot_name = '';
        $tracker->description = '';
        $tracker->errors = [];
        $tracker->fields = [
            [
                
            ]
        ];
        $tracker->hasSuccess = false;
        $tracker->has_bot = "0";
        $tracker->has_location = "1";
        $tracker->has_user_reporting = "1";
        $tracker->id = NULL;
        $tracker->isSaving = TRUE;
        $tracker->name = "Missing Person";
        $tracker->user_id = 1;
        $tracker->save();


        // Create Dead Person Tracker
        $tracker = new Tracker();
        $tracker->bot_name = '';
        $tracker->description = '';
        $tracker->errors = [];
        $tracker->fields = [
            [

            ]
        ];
        $tracker->hasSuccess = false;
        $tracker->has_bot = "0";
        $tracker->has_location = "1";
        $tracker->has_user_reporting = "1";
        $tracker->id = NULL;
        $tracker->isSaving = TRUE;
        $tracker->name = "Dead Person";
        $tracker->user_id = 1;
        $tracker->save();

        // Create Police Brutality Tracker
        $tracker = new Tracker();
        $tracker->bot_name = '';
        $tracker->description = '';
        $tracker->errors = [];
        $tracker->fields = [
            [

            ]
        ];
        $tracker->hasSuccess = false;
        $tracker->has_bot = "0";
        $tracker->has_location = "1";
        $tracker->has_user_reporting = "1";
        $tracker->id = NULL;
        $tracker->isSaving = TRUE;
        $tracker->name = "Police Brutality";
        $tracker->user_id = 1;
        $tracker->save();


        // Create Vandalism Tracker
        $tracker = new Tracker();
        $tracker->bot_name = '';
        $tracker->description = '';
        $tracker->errors = [];
        $tracker->fields = [
            [

            ]
        ];
        $tracker->hasSuccess = false;
        $tracker->has_bot = "0";
        $tracker->has_location = "1";
        $tracker->has_user_reporting = "1";
        $tracker->id = NULL;
        $tracker->isSaving = TRUE;
        $tracker->name = "Vandalism";
        $tracker->user_id = 1;
        $tracker->save();

        // Create Lootings Tracker
        $tracker = new Tracker();
        $tracker->bot_name = '';
        $tracker->description = '';
        $tracker->errors = [];
        $tracker->fields = [
            [

            ]
        ];
        $tracker->hasSuccess = false;
        $tracker->has_bot = "0";
        $tracker->has_location = "1";
        $tracker->has_user_reporting = "1";
        $tracker->id = NULL;
        $tracker->isSaving = TRUE;
        $tracker->name = "Lootings";
        $tracker->user_id = 1;
        $tracker->save();
    }
}
