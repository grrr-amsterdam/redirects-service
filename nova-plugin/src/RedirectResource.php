<?php

namespace Grrr\Redirects\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;

class RedirectResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Grrr\Redirects\Nova\Models\Redirect::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = "from";

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ["from"];

    public static function label(): string
    {
        return strval(__("nova-redirects::nova-redirects.label"));
    }

    public static function singularLabel(): string
    {
        return strval(__("nova-redirects::nova-redirects.singularLabel"));
    }

    public static function uriKey()
    {
        return "grrr-redirect";
    }
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make(__("nova-redirects::nova-redirects.fields.from"), "from")
                ->rules(["required"])
                ->creationRules("unique:grrr_redirects,from")
                ->updateRules("unique:grrr_redirects,from,{{resourceId}}")
                ->fillUsing(function ($request, $model, $attribute) {
                    $value = $request->input($attribute);
                    if (!str_starts_with($value, "/")) {
                        $value = "/{$value}";
                    }
                    $model->{$attribute} = $value;
                }),
            Text::make(__("nova-redirects::nova-redirects.fields.to"), "to")
                ->rules(["required"])
                ->fillUsing(function ($request, $model, $attribute) {
                    $value = $request->input($attribute);
                    if (
                        !str_starts_with($value, "/") &&
                        !str_starts_with($value, "http")
                    ) {
                        $value = "/{$value}";
                    }
                    $model->{$attribute} = $value;
                }),
            Boolean::make(
                __("nova-redirects::nova-redirects.fields.permanently"),
                "permanently"
            )
                ->rules(["required"])
                ->help(
                    strval(
                        __(
                            "nova-redirects::nova-redirects.fields.permanent_help"
                        )
                    )
                )
                ->default(true),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
