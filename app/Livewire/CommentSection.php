<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class CommentSection extends Component
{
    use Toast;
    use WithFileUploads;

    public Recipe $recipe;
    #[Validate('nullable|image|max:1024', message: ['max' => 'Размер изображения не должен превышать 1024 кб'])]
    public $photo;
    #[Validate(['required','string','min:10'], as: 'Комментарий')]
    public string $text;

    public function updatingPhoto()
    {

    }

    public function addComment():void
    {
        $this->validate();
        $commentData = [
            'user_id' => auth()->user()->id,
            'recipe_id' => $this->recipe->id,
            'description' => $this->text,
        ];

        if ($this->photo) {
            $imagePath = $this->photo->store('public/comments');
            $commentData['photo_url'] = Str::after($imagePath, 'public/');
        }
        Comment::query()->create($commentData);
        $this->reset('text', 'photo');
        $this->success('Ваш комментарий успешно добавлен');
    }

    public function removeComment(Comment $comment): void
    {
        if($comment->user->login === auth()->user()->login){
            $comment->delete();
            $this->success('Ваш комментарий успешно удален');
        }
        else{
            $this->error('Нет прав доступа');
        }
    }

    public function clearPhoto()
    {
        $this->reset('photo');
    }

    public function render()
    {
        return view('livewire.comment-section', [
            'comments'=>$this->recipe->comments
        ]);
    }
}
