<?php

namespace Database\Seeders;

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
        // Create Dead Person Tracker
        $tracker = new Tracker();
        $tracker->bot_name = '';
        $tracker->description = 'A tracker for dead or missing people';
        $tracker->fields = [
            [
                "component" => "h1",
                "id" => "id-1",
                "children" => "Report dead or missing people",
            ],
            [
                "component" => "p",
                "id" => "id-2",
                "children" => "Report a case of dead or missing persons",
                "class" => "lead",
            ],
            [
                "type" => "checkbox",
                "name" => "is_anonymous",
                "v-model" => "is_anonymous",
                "label" => "Anonymous Submission",
            ],
            [
                "type" => "text",
                "name" => "name",
                "label" => "Full Name",
                "placeholder" => "What is the person's name?",
                "help" => "Provide the full name of the person",
                "validation" => "required",
                "error-behavior" => "live"
            ],
            [
                "type" => "number",
                "name" => "age",
                "label" => "Age(In Years)",
                "placeholder" => "What is the person's age?",
                // "help" => "The number of said property destroyed",
                "validation" => "required|number",
                "min" => "1",
                "error-behavior" => "live",
            ],
            [
                "type" => "date",
                "name" => "occurred_at",
                "label" => "Date Of Occurrence",
                "placeholder" => "When did it happen?",
                "help" => "Tell us when this happened, to the best of your knowledge",
                "validation" => "required|after:2020-09-01",
                "min" => "2020-09-01",
                "error-behavior" => "live",
            ],
            [
                "type" => "textarea",
                "name" => "description",
                "v-model" => "description",
                "label" => "Description",
                "placeholder" => "Describe what happend",
                "help" => "Tell us what happend",
                "validation" => "required|max:255,length",
                "validation-name" => "description",
                "error-behavior" => "live",
                "help" => "Keep it under 255 characters.",
            ],
            [
                "type" => "text",
                "name" => "nationality",
                "label" => "Nationality",
                "placeholder" => "What is the person's nationality?",
                "help" => "If left blank, Nigerian will be assumed.",
                "error-behavior" => "live"
            ],
            [
                "name" => "status",
                "v-model" => "status",
                "options" => [
                    [
                        "value" => "missing",
                        "label" => "Missing",
                    ],
                    [
                        "value" => "dead",
                        "label" => "Dead",
                    ],
                ],
                "type" => "select",
                "placeholder" => "Select an option",
                "label" => "What is their status?",
            ],
            [
                "type" => "url",
                "name" => "external_reference",
                "label" => "External Reference",
                "placeholder" => "Do you have a link to a media resource that validates this?",
                "help" => "A link to a media resource that provides further clarity",
                // "validation" => "required"
            ],
            [
                "type" => "text",
                "name" => "reference_title",
                "label" => "Reference Title",
                "placeholder" => "Reference title",
                "help" => "Give your external reference a short title",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => "text",
                "name" => "latitude",
                "label" => "Latitude",
                "placeholder" => "Latitude",
                "help" => "The approximate latitude of where it happened",
                "inputmode" => "numeric",
                "pattern" => "^[0-9](\.[0-9]+)?$",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => "text",
                "name" => "longitude",
                "label" => "Longitude",
                "placeholder" => "Longitude",
                "help" => "The approximate longitude of where it happened",
                "inputmode" => "numeric",
                "pattern" => "^[0-9](\.[0-9]+)?$",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => 'submit',
                "label" => 'Report'
            ]
        ];
        $tracker->has_bot = "0";
        $tracker->has_location = "1";
        $tracker->has_user_reporting = "1";
        $tracker->id = NULL;
        $tracker->name = "Dead/Missing Persons";
        $tracker->user_id = 1;
        $tracker->save();

        // Create Police Brutality Tracker
        $tracker = new Tracker();
        $tracker->bot_name = '';
        $tracker->description = 'A tracker for police brutality';
        $tracker->fields = [
            [
                "component" => "h3",
                "id" => "id-1",
                "children" => "Report police brutality",
                "class" => "text-center",
            ],
            [
                "component" => "p",
                "id" => "id-2",
                "children" => "Report an incident of police brutality",
                "class" => "lead",
            ],
            [
                "type" => "checkbox",
                "name" => "is_anonymous",
                "v-model" => "is_anonymous",
                "label" => "Anonymous Submission",
            ],
            [
                "type" => "text",
                "name" => "name",
                "label" => "Full Name",
                "placeholder" => "What is the victims name?",
                "help" => "Provide the full name of the victim",
                "validation" => "required",
                "error-behavior" => "live"
            ],
            [
                "type" => "number",
                "name" => "age",
                "label" => "age",
                "placeholder" => "What is the victim's age?",
                // "help" => "The number of said property destroyed",
                "validation" => "required|number",
                "min" => "1",
                "error-behavior" => "live",
            ],
            [
                "type" => "text",
                "name" => "nationality",
                "label" => "Nationality",
                "placeholder" => "What is the person's nationality?",
                "help" => "If left blank, 'Nigerian' will be assumed.",
                "error-behavior" => "live"
            ],
            [
                "type" => "date",
                "name" => "occurred_at",
                "label" => "Date Of Occurrence",
                "placeholder" => "When did it happen?",
                "help" => "Tell us when this happened, to the best of your knowledge",
                "validation" => "required|after:2020-09-01",
                "min" => "2020-09-01",
                "error-behavior" => "live",
            ],
            [
                "type" => "textarea",
                "name" => "description",
                "v-model" => "description",
                "label" => "Description",
                "placeholder" => "Describe what happend",
                "help" => "Tell us what happend",
                "validation" => "required|max:255,length",
                "validation-name" => "description",
                "error-behavior" => "live",
                "help" => "Keep it under 255 characters.",
            ],
            [
                "type" => "url",
                "name" => "external_reference",
                "label" => "External Reference",
                "placeholder" => "Do you have a link to a media resource that validates this?",
                "help" => "A link to a media resource that provides further clarity",
                // "validation" => "required"
            ],
            [
                "type" => "text",
                "name" => "reference_title",
                "label" => "Reference Title",
                "placeholder" => "Reference title",
                "help" => "Give your external reference a short title",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => "text",
                "name" => "latitude",
                "label" => "Latitude",
                "placeholder" => "Latitude",
                "help" => "The approximate latitude of where it happened",
                "inputmode" => "numeric",
                "pattern" => "^[0-9](\.[0-9]+)?$",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => "text",
                "name" => "longitude",
                "label" => "Longitude",
                "placeholder" => "Longitude",
                "help" => "The approximate longitude of where it happened",
                "inputmode" => "numeric",
                "pattern" => "^[0-9](\.[0-9]+)?$",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => 'submit',
                "label" => 'Report'
            ]
        ];
        $tracker->has_bot = "0";
        $tracker->has_location = "1";
        $tracker->has_user_reporting = "1";
        $tracker->id = NULL;
        $tracker->name = "Police Brutality";
        $tracker->user_id = 1;
        $tracker->save();


        // Create Vandalism Tracker
        $tracker = new Tracker();
        $tracker->bot_name = '';
        $tracker->description = 'A tracker for incidents of vandalism';
        $tracker->fields = [
            [
                "component" => "h3",
                "id" => "id-1",
                "children" => "Report a Vandalism",
                "class" => "text-center",
            ],
            [
                "component" => "p",
                "id" => "id-2",
                "children" => "Report a case of vandalism",
                "class" => "lead",
            ],
            [
                "type" => "checkbox",
                "name" => "is_anonymous",
                "v-model" => "is_anonymous",
                "label" => "Anonymous Submission",
            ],
            [
                "type" => "text",
                "name" => "property",
                "label" => "Property",
                "placeholder" => "What property was vandalized?",
                "help" => "Provide the name of the property vandalized e.g Public buses, Police Station etc",
                "validation" => "required",
                "error-behavior" => "live"
            ],
            [
                "type" => "number",
                "name" => "property_count",
                "label" => "Property Count",
                "placeholder" => "What is the count of the property destroyed?",
                "help" => "The number of said property destroyed",
                "validation" => "required|number",
                "min" => "1",
                "error-behavior" => "live",
            ],
            [
                "type" => "date",
                "name" => "occurred_at",
                "label" => "Date Of Occurrence",
                "placeholder" => "When did it happen?",
                "help" => "Tell us when this happened, to the best of your knowledge",
                "validation" => "required|after:2020-09-01",
                "min" => "2020-09-01",
                "error-behavior" => "live",
            ],
            [
                "type" => "text",
                "name" => "vandal",
                "label" => "Vandal",
                "placeholder" => "What group did the vandalism?",
                "help" => "This could be an individual or a group",
                "validation" => "required",
                "error-behavior" => "live"
            ],
            [
                "type" => "url",
                "name" => "external_reference",
                "label" => "External Reference",
                "placeholder" => "Do you have a link to a media resource that validates this?",
                "help" => "A link to a media resource that provides further clarity",
                // "validation" => "required"
            ],
            [
                "type" => "text",
                "name" => "reference_title",
                "label" => "Reference Title",
                "placeholder" => "Reference title",
                "help" => "Give your external reference a short title",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => "text",
                "name" => "latitude",
                "label" => "Latitude",
                "placeholder" => "Latitude",
                "help" => "The approximate latitude of where it happened",
                "inputmode" => "numeric",
                "pattern" => "^[0-9](\.[0-9]+)?$",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => "text",
                "name" => "longitude",
                "label" => "Longitude",
                "placeholder" => "Longitude",
                "help" => "The approximate longitude of where it happened",
                "inputmode" => "numeric",
                "pattern" => "^[0-9](\.[0-9]+)?$",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => 'submit',
                "label" => 'Report'
            ]
        ];
        $tracker->has_bot = "0";
        $tracker->has_location = "1";
        $tracker->has_user_reporting = "0";
        $tracker->id = NULL;
        $tracker->name = "Vandalism";
        $tracker->user_id = 1;
        $tracker->save();

        // Create Lootings Tracker
        $tracker = new Tracker();
        $tracker->bot_name = '';
        $tracker->description = 'A tracker for incidents of looting';
        $tracker->fields = [
            [
                "component" => "h3",
                "id" => "id-1",
                "children" => "Report Looting",
                "class" => "text-center",
            ],
            [
                "component" => "p",
                "id" => "id-2",
                "children" => "Report a case of looting",
                "class" => "lead",
            ],
            [
                "type" => "checkbox",
                "name" => "is_anonymous",
                "v-model" => "is_anonymous",
                "label" => "Anonymous Submission",
            ],
            [
                "type" => "textarea",
                "name" => "description",
                "v-model" => "description",
                "label" => "Description",
                "validation" => "required|max:255,length",
                "validation-name" => "description",
                "error-behavior" => "live",
                "help" => "Keep it under 255 characters.",
            ],
            [
                "type" => "number",
                "name" => "losses_in_naira",
                "label" => "Losses In Naira",
                "placeholder" => "Quantify the losses in naira",
                "help" => "Approximately, how much was lost?",
                "validation" => "required|number",
                "min" => "0",
                "error-behavior" => "live",
            ],
            [
                "type" => "date",
                "name" => "occurred_at",
                "label" => "Date Of Occurrence",
                "placeholder" => "When did it happen?",
                "help" => "Tell us when this happened, to the best of your knowledge",
                "validation" => "required|after:2020-09-01",
                "min" => "2020-09-01",
                "error-behavior" => "live",
            ],
            [
                "type" => "text",
                "name" => "looter",
                "label" => "Looter",
                "placeholder" => "What group did the looting?",
                "help" => "This could be an individual or a group",
                "validation" => "required",
                "error-behavior" => "live"
            ],
            [
                "type" => "url",
                "name" => "external_reference",
                "label" => "External Reference",
                "placeholder" => "Do you have a link to a media resource that validates this?",
                "help" => "A link to a media resource that provides further clarity",
                // "validation" => "required"
            ],
            [
                "type" => "text",
                "name" => "reference_title",
                "label" => "Reference Title",
                "placeholder" => "Reference title",
                "help" => "Give your external reference a short title",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => "text",
                "name" => "latitude",
                "label" => "Latitude",
                "placeholder" => "Latitude",
                "help" => "The approximate latitude of where it happened",
                "inputmode" => "numeric",
                "pattern" => "^[0-9](\.[0-9]+)?$",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => "text",
                "name" => "longitude",
                "label" => "Longitude",
                "placeholder" => "Longitude",
                "help" => "The approximate longitude of where it happened",
                "inputmode" => "numeric",
                "pattern" => "^[0-9](\.[0-9]+)?$",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => 'submit',
                "label" => 'Report'
            ]
        ];
        $tracker->has_bot = "0";
        $tracker->has_location = "1";
        $tracker->has_user_reporting = "0";
        $tracker->id = NULL;
        $tracker->name = "Lootings";
        $tracker->user_id = 1;
        $tracker->save();

        // Create Judicial Inquiry Tracker
        $tracker = new Tracker();
        $tracker->bot_name = '';
        $tracker->description = 'A tracker for Judicial Inquiry into police brutality';
        $tracker->fields = [
            [
                "component" => "h3",
                "id" => "id-1",
                "children" => "Judicial Inquiry",
                "class" => "text-center",
            ],
            [
                "component" => "p",
                "id" => "id-2",
                "children" => "Report a Judicial Inquiry into police brutality",
                "class" => "lead",
            ],
            [
                "type" => "checkbox",
                "name" => "is_anonymous",
                "v-model" => "is_anonymous",
                "label" => "Anonymous Submission",
            ],
            [
                "type" => "number",
                "name" => "members_count",
                "label" => "Number of Members",
                "placeholder" => "How many members?",
                // "help" => "",
                "validation" => "required|number",
                "min" => "1",
                "error-behavior" => "live",
            ],
            [
                "type" => "date",
                "name" => "started_at",
                "label" => "Started On",
                "placeholder" => "When did it start?",
                "help" => "Tell us when the inquiry started",
                "validation" => "required",
                "error-behavior" => "live",
            ],
            [
                "type" => "url",
                "name" => "external_reference",
                "label" => "External Reference",
                "placeholder" => "Do you have a link to a media resource that validates this?",
                "help" => "A link to a media resource that provides further clarity",
                // "validation" => "required"
            ],
            [
                "type" => "text",
                "name" => "reference_title",
                "label" => "Reference Title",
                "placeholder" => "Reference title",
                "help" => "Give your external reference a short title",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => "text",
                "name" => "latitude",
                "label" => "Latitude",
                "placeholder" => "Latitude",
                "help" => "The approximate latitude of where it happened",
                "inputmode" => "numeric",
                "pattern" => "^[0-9](\.[0-9]+)?$",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => "text",
                "name" => "longitude",
                "label" => "Longitude",
                "placeholder" => "Longitude",
                "help" => "The approximate longitude of where it happened",
                "inputmode" => "numeric",
                "pattern" => "^[0-9](\.[0-9]+)?$",
                // "validation" => "required",
                // "error-behavior" => "live"
            ],
            [
                "type" => 'submit',
                "label" => 'Report'
            ]
        ];
        $tracker->has_bot = "0";
        $tracker->has_location = "1";
        $tracker->has_user_reporting = "0";
        $tracker->id = NULL;
        $tracker->name = "Judicial Inquiry";
        $tracker->user_id = 1;
        $tracker->save();
    }
}
