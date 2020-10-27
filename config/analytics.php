<?php

return [
  /*
  * When using the "HasViews" trait from this package, we need to know which
  * Eloquent model should be used to retrieve your views. Of course, it
  * is often just the "View" model but you may use whatever you like.
  *
  * The model you want to use as a Analytic model needs to implement the
  * `StarfolkSoftware\Analytics\Contracts\View` contract.
  */
  'view_class' => \App\Models\Analytics\View::class,

  /*
  * When using the "HasVisits" trait from this package, we need to know which
  * Eloquent model should be used to retrieve your visits. Of course, it
  * is often just the "Visits" model but you may use whatever you like.
  *
  * The model you want to use as a Analytic model needs to implement the
  * `StarfolkSoftware\Analytics\Contracts\Visit` contract.
  */
  'visit_class' => \App\Models\Analytics\Visit::class,

  /*
  * The user model that should be used when associating  with
  * . If null, the default user provider from your
  * Laravel authentication configuration will be used.
  */
  'user_model' => \App\Models\Auth\User::class,
];
