<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Services\EmbedPartsService;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer', 'nullable'],
            'visible' => ['integer', 'nullable'],
            'keyword' => [],
        ]);

        $items = $this->favoriteService->list($validated);
        $columns = ['name' => 'お気に入り名'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;
        $listActions = ['delete', 'showpreview', 'selectable'];

        return view('embed_parts.favorite.index', compact(
            'items',
            'columns',
            'perPageOptions',
            'listActions',
        ));
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->favoriteService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', 'お気に入りを一括削除しました');
            } else {
                return redirect()->back()->withInput()->with('error', 'お気に入りを一括削除できませんでした');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favorite $favorite)
    {
        if ($favorite->delete()) {
            return redirect()->back()->withInput()->with('success', 'お気に入りを削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'お気に入りを削除できませんでした');
        }
    }
}
