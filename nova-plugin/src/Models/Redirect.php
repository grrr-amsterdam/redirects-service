<?php

namespace Grrr\Redirects\Nova\Models;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $casts = [
        'permanently' => 'boolean'
    ];

    public function __construct(array $attributes = [])
    {
        $this->setTable(config('nova-redirects.table_name'));

        parent::__construct($attributes);
    }
}
