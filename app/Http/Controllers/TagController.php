<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tags\StoreTagRequest;
use App\Http\Requests\Tags\TagIndexFilterRequest;
use App\Http\Requests\Tags\UpdateTagRequest;
use App\Http\Resources\Tags\TagsCollection;
use App\Http\Resources\Tags\TagUpdateResource;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(
        TagService $tagService
    ) {
        $this->tagService = $tagService;
    }

    public function index(TagIndexFilterRequest $request) {
        if ($request->isMethod('post')) {
            $request->session()->put('tag_filters', $request->except('_token'));
            return redirect()->route('tags.index');
        }
        $filters = $request->session()->get('tag_filters', []);
        $mergedRequest = $request->merge($filters);

        $items = $this->tagService->getAllTagsWithPaging($mergedRequest);

        $disableSortable = false;
        if ($mergedRequest->filled('tag_keyword')) {
            $disableSortable = true;
        }

        return view('tags.index', [
            'items' => new TagsCollection($items),
            'maxViewOptions' => config('views.tags.max_view_options'),
            'columns' => config('views.tags.columns'),
            'disableSortable' => $disableSortable,
        ]);
    }

    public function create(Request $request)
    {
        $tags = $this->tagService->getAllTags();
        return view('tags.create', [
            'path' => route('tags.store'),
            'tags' => $tags,
        ]);
    }

    public function store(StoreTagRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if (!Auth::check()) { // Temporary fake site_id
                $validatedData['site_id'] = 1;
            }

            $result = $this->tagService->createTag($validatedData);

            if ($result) {
                return redirect()->route('tags.index')->with('success', 'タグが正常に作成されました。');
            }
            return redirect()->route('news_categories.index')->with('error', 'タグの作成中にエラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', 'タグの作成中にエラーが発生しました。');
        }
    }

    public function edit(Tag $tag)
    {
        $tags = $this->tagService->getAllTags();
        return view('tags.edit', [
            'path' => route('tags.update', ['tag' => $tag['id']]),
            'tag' => new TagUpdateResource($tag),
            'tags' => $tags,
        ]);
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        try {
            $validatedData = $request->validated();

            if (!Auth::check()) { // Temporary fake site_id
                $validatedData['site_id'] = 1;
            }

            $result = $this->tagService->updateTag($tag, $validatedData);

            if ($result) {
                return redirect()->route('tags.index')->with('success', 'タグが正常に更新されました。');
            }
            return redirect()->route('tags.index')->with('error', 'タグの更新中にエラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', 'タグの更新中にエラーが発生しました。');
        }
    }

    public function delete(Request $request, Tag $tag)
    {
        try {
            $result = $this->tagService->deleteTag($tag);

            if ($result) {
                return redirect()->route('tags.index')->with('success', 'タグが正常に削除されました');
            }
            return redirect()->route('tags.index')->with('error', 'タグを削除できませんでした');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('tags.index')->with('error', 'タグを削除できませんでした');
        }
    }

    public function bulkDelete(Request $request)
    {
        $tagIds = $request->input('checks', []);

        if (empty($tagIds)) {
            return redirect()->route('tags.index')->with('error', '削除するタグが選択されていません');
        }

        try {
            $result = $this->tagService->bulkDeleteTags($tagIds);

            if ($result) {
                return redirect()->route('tags.index')->with('success', '選択したタグは正常に削除されました');
            }
            return redirect()->route('tags.index')->with('error', '選択したタグを削除できませんでした');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('tags.index')->with('error', '選択したタグを削除できませんでした');
        }
    }
}
