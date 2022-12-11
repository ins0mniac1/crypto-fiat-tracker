<?php

namespace App\Http\Requests\API\Guest;

use App\Models\Users\NotifyUser;
use App\Rules\PairRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveUserForNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'pair' => ['required', new PairRule()],
            'price' => ['required', 'numeric', 'gt:0']
        ];
    }

    public function handle()
    {
        $data = $this->validated();
        try {
            NotifyUser::create($data);
            return response()->json('You are successfully subscribed for our trackable software');
        }  catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 422);
        }

    }
}
