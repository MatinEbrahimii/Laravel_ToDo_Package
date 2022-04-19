<?php


namespace MatinEbrahimii\ToDo\Traits;

use Imanghafoori\Helpers\Nullable;
use MatinEbrahimii\ToDo\Facades\ResponderFacade;

trait FindMethodTrait
{
    public static function findOr($id)
    {
        $model = self::find($id);

        return new Nullable($model);
    }

    public static function findOrNotFound($id)
    {
        return self::findOr($id)->getOrSend(function () {
            return ResponderFacade::notFound();
        });
    }
}
