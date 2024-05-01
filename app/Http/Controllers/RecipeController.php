<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function topic()
    {
        $latest = Recipe::query()->latest()->take(15)->get();
        $popular = Recipe::query()->withCount('marks')->orderByDesc('marks_count')
            ->take(15)->get();
        return view('recipes.topic', compact('latest', 'popular'));
    }

    public function show(Recipe $recipe): View
    {
        $recipe->loadAvg('marks', 'mark');
        return view('recipes.show', compact('recipe'));
    }

    public function preview(Recipe $recipe)
    {
        $pdf = Pdf::loadView('recipes.document', compact('recipe'));
        return $pdf->download($recipe->slug_title . ".pdf");

    }
}
