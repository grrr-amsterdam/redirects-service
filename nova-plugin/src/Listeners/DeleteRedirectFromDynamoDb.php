<?php

namespace Grrr\Redirects\Nova\Listeners;

use Grrr\Redirects\Nova\Events\RedirectIsDeleted;
use Grrr\Redirects\Nova\RedirectsApi;

final class DeleteRedirectFromDynamoDb
{
    public function __construct(private RedirectsApi $api)
    {
    }

    public function handle(RedirectIsDeleted $event): void
    {
        $this->api->delete($event->redirect);
    }
}
