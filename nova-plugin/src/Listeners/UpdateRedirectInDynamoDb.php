<?php

namespace Grrr\Redirects\Nova\Listeners;

use Grrr\Redirects\Nova\Events\RedirectIsUpdated;
use Grrr\Redirects\Nova\RedirectsApi;

final class UpdateRedirectInDynamoDb
{
    public function __construct(private RedirectsApi $api)
    {
    }

    public function handle(RedirectIsUpdated $event): void
    {
        $this->api->update($event->redirect);
    }
}
