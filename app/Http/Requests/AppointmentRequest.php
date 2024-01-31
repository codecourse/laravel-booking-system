<?php

namespace App\Http\Requests;

use App\Models\Employee;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => ['required', Rule::exists(Employee::class, 'id')],
            'service_id' => ['required', Rule::exists(Service::class, 'id')],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i'],
            'name' => ['required'],
            'email' => ['required', 'email'],
        ];
    }
}
