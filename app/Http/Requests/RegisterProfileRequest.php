<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class RegisterProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'about'              => 'required|string',
            'content_genre'      => 'required|string|in:education,news',
            'subscription_price' => 'required|integer|min:0|max:1000000',
        ];
    }
}