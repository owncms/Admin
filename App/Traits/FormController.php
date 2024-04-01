<?php

namespace Modules\Admin\App\Traits;

trait FormController
{
    public function validateForm($request, $methodRequest, $itemId = null)
    {
        $newRequest = new $methodRequest;
        if ($itemId && method_exists($newRequest, 'setModelId')) {
            $newRequest->setModelId($itemId);
        }
        $rules = $newRequest->rules();
        $request->validate($rules);

        return $request;
    }
}
