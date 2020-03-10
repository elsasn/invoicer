<?php
namespace App\Traits;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\ModelNotFoundException;
trait UuidModel
{
    public static function bootUuidModel()
    {
        static::creating(function ($model) {
            $model->uuid = Uuid::generate(4);
        });
        static::saving(function ($model) {
            // What's that, trying to change the UUID huh? Nope, not gonna happen.
            $original_uuid = $model->getOriginal('uuid');
            if ($original_uuid !== $model->uuid) {
                $model->uuid = $original_uuid;
            }
        });
    }
    public function scopeUuid($query, $uuid, $first = true)
    {
        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
            throw (new ModelNotFoundException)->setModel(get_class($this));
        }
        $search = $query->where('uuid', $uuid);
        return $first ? $search->firstOrFail() : $search;
    }
    public function scopeIdOrUuId($query, $id_or_uuid, $first = true)
    {
        if (!is_string($id_or_uuid) && !is_numeric($id_or_uuid)) {
            throw (new ModelNotFoundException)->setModel(get_class($this));
        }
        if (preg_match('/^([0-9]+|[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12})$/', $id_or_uuid) !== 1) {
            throw (new ModelNotFoundException)->setModel(get_class($this));
        }
        $search = $query->where(function ($query) use ($id_or_uuid) {
            $query->where('id', $id_or_uuid)
                ->orWhere('uuid', $id_or_uuid);
        });
        return $first ? $search->firstOrFail() : $search;
    }
};