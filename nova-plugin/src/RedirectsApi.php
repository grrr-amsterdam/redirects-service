<?php

namespace Grrr\Redirects\Nova;

use Grrr\Redirects\Nova\Models\Redirect;
use Illuminate\Support\Facades\Http;

final class RedirectsApi
{
    public function __construct(private string $apiUrl)
    {
    }

    public function create(Redirect $redirect): void
    {
        Http::post($this->apiUrl, [
            "from" => $redirect->from,
            "to" => $redirect->to,
            "permanently" => $redirect->permanently,
        ]);
    }

    public function update(Redirect $redirect): void
    {
        Http::delete($this->apiUrl, [
            "from" => $redirect->getOriginal("from"),
        ]);

        Http::post($this->apiUrl, [
            "from" => $redirect->from,
            "to" => $redirect->to,
            "permanently" => $redirect->permanently,
        ]);
    }

    public function delete(Redirect $redirect): void
    {
        Http::delete($this->apiUrl, [
            "from" => $redirect->from,
        ]);
    }
}
