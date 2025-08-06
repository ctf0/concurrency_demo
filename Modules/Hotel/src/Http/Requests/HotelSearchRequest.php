<?php

declare(strict_types=1);

namespace Modules\Hotel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Hotel\Enum\HotelSearchSorting;

final class HotelSearchRequest extends FormRequest
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
            'location' => ['required', 'string', 'max:255'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['integer', 'numeric', 'gte:0'],
            'min_price' => ['integer', 'numeric', 'gte:0'],
            'max_price' => ['integer', 'numeric', 'gte:min_price'],
            'sort_by' => [Rule::enum(HotelSearchSorting::class)],
        ];
    }
}
