<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('create');

    }
    public function index()
    {
        return view('recipes.index', [
            'title'=> 'Все рецепты'
        ]);
    }
    public function topic()
    {
        $latest = Recipe::query()
            ->where('is_publish', true)
            ->where('is_visible', true)
            ->latest()->take(15)->get();
        $popular = Recipe::query()->where('is_publish', true)
            ->where('is_visible', true)
            ->withSum('marks', 'mark')
            ->orderByDesc('marks_sum_mark')
            ->take(15)
            ->get();
        return view('recipes.topic', compact('latest', 'popular'));
    }

    public function show(Recipe $recipe): View
    {
        if($recipe->is_publish || auth()->user()?->id === $recipe->user->id){
            $recipe->loadAvg('marks', 'mark');
            $recipe->increment('views');
            return view('recipes.show', compact('recipe'));
        }
        abort(404);
    }

    public function preview(Recipe $recipe)
    {
        $pdf = Pdf::loadView('recipes.document', compact('recipe'));
        return $pdf->download($recipe->slug_title . ".pdf");
    }

    public function create()
    {
        return view('recipes.create', [
            'title'=> 'Создание рецепта'
        ]);
    }

    public function edit(Recipe $recipe)
    {
        if($recipe->user->id === auth()->user()->id){
            return view('recipes.update', [
                'title'=> 'Редактирование рецепта',
                'recipe' => $recipe
            ]);
        }
       else{
           return redirect()->back();
       }
    }

    public function random(): RedirectResponse
    {
        $recipe = Recipe::query()->where('is_publish', true)
            ->where('is_visible', true)
            ->inRandomOrder()->first('slug_title');
        if($recipe){
            return redirect()->route('recipes.show', $recipe);
        }
        return redirect()->back();
    }
}
