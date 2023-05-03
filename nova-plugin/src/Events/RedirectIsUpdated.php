<?php

namespace Grrr\Redirects\Nova\Events;

use Grrr\Redirects\Nova\Models\Redirect;

final class RedirectIsUpdated
{
    public function __construct(public Redirect $redirect)
    {
    }
}
