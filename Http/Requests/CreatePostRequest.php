<?php namespace Modules\Blog\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreatePostRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
    }

    public function translationRules()
    {
        return [
            'title' => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function translationMessages()
    {
        return [
            'title.required' => trans('blog::messages.title is required'),
            'slug.required' => trans('blog::messages.slug is required'),
            'slug.unique' => trans('blog::messages.slug is unique'),
        ];
    }
}
