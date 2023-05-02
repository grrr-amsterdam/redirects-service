<?php

namespace Grrr\Redirects\Nova;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class RedirectsTool extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::resources([RedirectResource::class]);
    }

}
