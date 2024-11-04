<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();

        // Проверяем, что пользователь авторизован
        if (!$user) {
            return false;
        }
        // Разрешаем, если пользователь админ
        if ($user->isAdmin()) {
            return true;
        }
        // Если это обновление существующей задачи, проверяем, что пользователь — владелец
        $taskId = $this->route('task');

        $task = Task::find($taskId);
        
        return $task && $task->user_id == $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'string:255',
            'user_id' => 'required|numeric|exists:users,id'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->id()
        ]);
    }
}
