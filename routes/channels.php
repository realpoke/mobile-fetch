<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('list.{id}.{password}', function () {});
