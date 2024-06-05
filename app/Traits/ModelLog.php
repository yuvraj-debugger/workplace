<?php
namespace App\Traits;

use App\Models\SystemLogs;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait ModelLog
{
  

    /**
     * Handle model event
     */
    public static function bootModelLog()
    {
        /**
         * Data creating and updating event
         */
        static::saved(function ($model) {
            // create or update?
            if ($model->wasRecentlyCreated) {
                static::storeLog($model, static::class, 'CREATED');
            } else {
                if (! $model->getChanges()) {
                    return;
                }
                static::storeLog($model, static::class, 'UPDATED');
            }
        });

        /**
         * Data deleting event
         */
        static::deleted(function (Model $model) {
            static::storeLog($model, static::class, 'DELETED');
        });
    }

    /**
     * Generate the model name
     *
     * @param Model $model
     * @return string
     */
    public static function getTagName(Model $model)
    {
        return ! empty($model->tagName) ? $model->tagName : Str::title(Str::snake(class_basename($model), ' '));
    }

    /**
     * Retrieve the current login user id
     *
     * @return int|string|null
     */
    public static function activeUserId()
    {
        return Auth::guard(static::activeUserGuard())->id();
    }

    /**
     * Retrieve the current login user guard name
     *
     * @return mixed|null
     */
    public static function activeUserGuard()
    {
        foreach (array_keys(config('auth.guards')) as $guard) {

            if (auth()->guard($guard)->check()) {
                return $guard;
            }
        }
        return null;
    }

    /**
     * Store model logs
     *
     * @param
     *            $model
     * @param
     *            $modelPath
     * @param
     *            $action
     */
    public static function storeLog($model, $modelPath, $action)
    {
        $newValues = null;
        $oldValues = null;
        if ($action === 'CREATED') {
            $newValues = $model->getAttributes();
        } elseif ($action === 'UPDATED') {
            $newValues = $model->getChanges();
        }

        if ($action !== 'CREATED') {
            $oldValues = $model->getOriginal();
        }
       SystemLogs::create([
        'system_logable_id' => $model->id,
        'system_logable_type' => $modelPath,
        'user_id' => static::activeUserId(),
        'guard_name' => static::activeUserGuard(),
        'module_name' => static::getTagName($model),
        'action' => $action,
        'old_value' => ! empty($oldValues) ? json_encode($oldValues) : null,
        'new_value' => ! empty($newValues) ? json_encode($newValues) : null,
        'ip_address' => request()->ip(),
        ]);
    }
}