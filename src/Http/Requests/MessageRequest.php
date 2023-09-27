<?php

namespace Mdeskorg\Chat\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class MessageRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'messageId' => ['nullable', 'string', 'between:1,4096'],
            'text' => ['nullable', 'string', 'between:1,4096'],
        ];
        // $limits = request()->chat->getLimits();

        // $this->countAttachments($limits->get('attachments'));

        // return match ($this->method()) {
        //   "POST" => [ //store
        //     'messageId' => ['nullable', 'string', 'between:1,4096'],
        //     'text' => ['nullable', 'string', 'between:1,4096'],

        //     /** Документы */
        //     'documents' => ['nullable', 'array'],
        //     'documents.*' => ['file', 'max:' . $limits->get('documents')],

        //     /** Изображения */
        //     'photos' => ['nullable', 'array'],
        //     'photos.*' => [
        //       'file', 'image', 'max:' . $limits->get('photos'),
        //       function ($attribute, $value, $fail) {
        //         [$width, $height] = getimagesize($value);
        //         if ($width + $height > 14000) {
        //           $fail('Общая сумма высоты и ширины изображения должна быть не более 14000px');
        //         }
        //       }
        //     ],
        //     /** Видео */
        //     'videos' => ['nullable', 'array'],
        //     'videos.*' => [
        //       'file',  File::types(['avi', 'mp4', '3gp', 'mpeg', 'mov', 'mp3', 'flv', 'wmv']),
        //       'max:' . $limits->get('videos')
        //     ],
        //   ],
        // };
    }

    // public function countAttachments($limit)
    // {
    //   $count = collect(request()->documents)->count() +
    //     collect(request()->photos)->count() + collect(request()->videos)->count();

    //   if ($count > $limit) {
    //     throw new Exception('Максимальное количество вложений - ' . $limit . ' шт.', 403);
    //   }
    // }
}
