<?php

namespace Concaveit\ModuleGenerator\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ModuleGenerator extends Model
{
    use HasFactory,LogsActivity;

    public function getTableColumns($table_name) {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($table_name);
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Model data has been {$eventName}";
    }
}
