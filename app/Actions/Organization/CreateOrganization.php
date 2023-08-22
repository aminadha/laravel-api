<?php

namespace App\Actions\Organization;

use App\Models\Organization;
use Illuminate\Support\Facades\DB;

class CreateOrganization
{

    public function execute($inputs, $model)
    {
        $trimmedInputs = $this->trimInputs($inputs);

        $model = new Organization();
        $model->fill($trimmedInputs);
        $model->save();

        return $model;
    }

    protected function trimInputs($inputs)
    {
        foreach ($inputs as $key => $value) {
            $inputs[$key] = trim($value);
        }

        return $inputs;
    }
}
