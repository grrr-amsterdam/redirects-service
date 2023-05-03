<?php

namespace Grrr\Redirects\Nova\Models;

use Grrr\Redirects\Nova\Events\RedirectIsCreated;
use Grrr\Redirects\Nova\Events\RedirectIsDeleted;
use Grrr\Redirects\Nova\Events\RedirectIsUpdated;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $from
 * @property string $to
 * @property bool $permanently
 */
class Redirect extends Model
{
    protected $table = "grrr_redirects";

    protected $casts = [
        "permanently" => "boolean",
    ];

    protected $dispatchesEvents = [
        "created" => RedirectIsCreated::class,
        "updated" => RedirectIsUpdated::class,
        "deleted" => RedirectIsDeleted::class,
    ];
}
