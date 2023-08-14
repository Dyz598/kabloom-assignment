<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class CreatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'public'  => 'required|boolean',
        ];
    }
}