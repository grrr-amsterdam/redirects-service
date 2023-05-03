<?php

namespace Grrr\Redirects\Nova\Events;

use Grrr\Redirects\Nova\Models\Redirect;

final class RedirectIsCreated
{
    public function __construct(public Redirect $redirect)
    {
    }
}
