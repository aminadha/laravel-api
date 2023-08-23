<?php

namespace App\Actions\Branch;

use App\Models\Branch;
use Illuminate\Support\Facades\DB;

class CreateBranch
{

    public function execute($inputs, $model)
    {
        $trimmedInputs = $this->trimInputs($inputs);

        $model = new Branch();
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
