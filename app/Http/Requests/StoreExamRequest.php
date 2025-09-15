<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
    public static function rules(): array
    {


        return [
            'title' => 'required|string|min:5|unique:exams,title',
            'start_at' => ['required','date',Rule::date()->after(now()->addMinute())],
            'end_at' => ['required', 'date', 'after:start_at'],
            'duration' => 'required|integer|min:30',
            'course_id' => 'required|integer|exists:courses,id',
        ];
    }
}
