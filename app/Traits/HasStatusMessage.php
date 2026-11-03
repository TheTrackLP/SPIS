<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;

trait HasStatusMessage
{
    public function StatusMessage(bool $status, string $message, ?string $route = null, array $error = []){
        $redirect = ($status && $route) ? redirect()->route($route) : back();

        if(!$status){
            $redirect = $redirect->withErrors($error)->withInput();
        }

        return $redirect->with($status ? 'success' : 'error', $message);
    }

    public function failedValidation(Validator $validator, string $message = "Error, Try Again!"){
        return $this->StatusMessage(false, $message, null, $validator->errors()->toArray());
    }
}
