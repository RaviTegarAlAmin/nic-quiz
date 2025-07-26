<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use function PHPUnit\Framework\isNull;

class StoreExamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !isNull(auth()->user()->teacher);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $startTime = now()->addMinutes(10);
        $endTime = $startTime->addMinutes(60);

        return [
            'title' => 'required|string|min:5|unique:exams,name',
            'start_at' => ['required','date','after:'.$startTime],
            'end_at' => ['required', 'date', 'after:.'.$endTime],
            'duration' => 'required|integer|min:30',
            'courses' => ['required', 'string', 'exists:courses,name']
        ];
    }
}
