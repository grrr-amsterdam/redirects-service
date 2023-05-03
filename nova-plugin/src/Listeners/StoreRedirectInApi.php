<?php

namespace Grrr\Redirects\Nova\Listeners;

use Grrr\Redirects\Nova\Events\RedirectIsCreated;
use Grrr\Redirects\Nova\RedirectsApi;

final class StoreRedirectInApi
{
    public function __construct(private RedirectsApi $api)
    {
    }

    public function handle(RedirectIsCreated $event): void
    {
        $this->api->create($event->redirect);
    }
}
