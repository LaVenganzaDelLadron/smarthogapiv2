<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IotDevicesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'type' => ['sometimes', 'required_without:name', 'string', 'max:255'],
            'name' => ['sometimes', 'required_without:type', 'string', 'max:255'],
            'hog_pen_id' => ['required', 'exists:hog_pens,id'],
            'api_provider' => ['sometimes', 'string', 'max:255'],
            'status' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'productId' => ['nullable', 'string', 'max:255'],
            'roomId' => ['nullable', 'string', 'max:255'],
            'macAddress' => ['nullable', 'string', 'max:255'],
            'lastConnectedSSID' => ['nullable', 'string', 'max:255'],
            'hwVersion' => ['nullable', 'string', 'max:255'],
            'swVersion' => ['nullable', 'string', 'max:255'],
            'serialNumber' => ['nullable', 'string', 'max:255'],
            'lastIpAddress' => ['nullable', 'string', 'max:255'],
            'customData' => ['nullable', 'string'],
            'accessKeyId' => ['nullable', 'string', 'max:255'],
            'alias' => ['nullable'],
            'attributes' => ['nullable', 'array'],
            'external_provider' => ['nullable', 'string', 'max:255'],
            'external_device_id' => ['nullable', 'string', 'max:255'],
            'external_metadata' => ['nullable', 'array'],
        ];

        return $this->isMethod('put') || $this->isMethod('patch')
            ? $this->partialRules($rules)
            : $rules;
    }

    public function messages(): array
    {
        return [
            'type.required' => 'The device type is required.',
            'type.required_without' => 'The device type is required when a Sinric device name is not provided.',
            'name.required_without' => 'The Sinric device name is required when a device type is not provided.',
            'hog_pen_id.required' => 'The hog pen ID is required.',
            'hog_pen_id.exists' => 'The selected hog pen does not exist.',
            'api_provider.required' => 'The API provider is required.',
            'status.required' => 'The device status is required.',
        ];
    }

    private function partialRules(array $rules): array
    {
        foreach ($rules as $field => $fieldRules) {
            array_unshift($fieldRules, 'sometimes');
            $rules[$field] = $fieldRules;
        }

        return $rules;
    }
}
