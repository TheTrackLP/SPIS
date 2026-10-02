<?php

namespace App\Traits;

use App\Models\LogActivity;

trait ActivityLog
{
    public static function bootActivityLog()
    {
        static::created(fn ($m) => $m->logActivity('created', 'record_created'));

        static::updated(function ($m) {
            foreach ($m->getChanges() as $field => $new) {
                if($field === 'updated_at') continue;

                $m->logActivity(
                    'updated',
                    $m->eventTypes()[$field] ?? $field . '_modified',
                    $field,
                    $m->getOriginal($field),
                    $new
                );
            }
        });
    }

    protected function logActivity($action, $event, $field = null, $old = null, $new = null)
    {
        LogActivity::create([
            'user_id'       => auth()->id(),
            'action'        => $action,
            'event_type'    => $event,
            'module'        => $this->getTable(),
            'subject_type'  => static::class,
            'subject_id'    => $this->getKey(),
            'subject_label' => $this->logLabel(),
            'field_name'    => $field,
            'old_value'     => $old,
            'new_value'     => $new,
        ]);
    }
}
