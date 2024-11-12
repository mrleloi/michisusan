<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShopItemRequest;
use App\Http\Requests\UpdateShopItemRequest;
use App\Models\ShopItem;
use App\Services\EmbedPartsService;
use App\Services\ShopItemService;
use Illuminate\Http\Request;

class ShopItemController extends Controller
{
    protected $siService;

    public function __construct(ShopItemService $siService)
    {
        $this->siService = $siService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer'],
            'keyword' => [],
        ]);

        $items = $this->siService->list($validated);
        $columns = ['name' => '企業・店舗名'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;

        return view('embed_parts.shop_item.index', compact('items', 'columns', 'perPageOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $addressTypes = $this->siService->getAddressTypes();
        $mapTypes = $this->siService->getMapTypes();
        $shopItemAdditions = array_fill(0, 5, []);
        return view('embed_parts.shop_item.create', compact(
            'addressTypes',
            'mapTypes',
            'shopItemAdditions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShopItemRequest $request)
    {
        $shopItem = $this->siService->store($request->all());
        if ($shopItem) {
            return redirect(route('shop_item.edit', ['shop_item' => $shopItem]))->with('success', '企業・店舗を追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', '企業・店舗を追加できませんでした');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShopItem $shopItem)
    {
        //
        //$shopItem = ShopItem::findOrFail($id);
        //
        $addressTypes = $this->siService->getAddressTypes();
        $mapTypes = $this->siService->getMapTypes();
        $shopItemAdditions = $shopItem->shopItemAdditions()->orderBy("sort_order")->get();
        if (count($shopItemAdditions) < 5) {
            $shopItemAdditions = $shopItemAdditions->concat(array_fill(0, 5 - count($shopItemAdditions), []));
        }
        return view('embed_parts.shop_item.edit', compact(
            'shopItem',
            'addressTypes',
            'mapTypes',
            'shopItemAdditions',
        ))->with('success', '編集を完了しました');;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShopItemRequest $request, ShopItem $shopItem)
    {

        //Log::debug('update',[$request->all()]);
        $validated = $request->validated();
        //Log::debug('shopItem validated',[$validated]);

        if (isset($validated['image_id_delete']) && $validated['image_id_delete'] == 1) {
            $request['image_id'] = null;
        }
        if (isset($validated['sign_logo_image_id_delete']) && $validated['sign_logo_image_id_delete'] == 1) {
            $request['sign_logo_image_id'] = null;
        }

        //Log::debug('shopItem request',[$request->all(),$shopItem]);
        if ($shopItem->update($request->all())) {
            $this->siService->syncShopItemAdditions($shopItem, $request->input("rows", []));
            return redirect(route('shop_item.edit', ['shop_item' => $shopItem]))->with('success', '企業・店舗を変更しました');
        } else {
            return redirect()->back()->withInput()->with('error', '企業・店舗を変更できませんでした');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShopItem $shopItem)
    {
        if ($shopItem->delete()) {
            return redirect()->back()->withInput()->with('success', '企業・店舗を削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', '企業・店舗を削除できませんでした');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->siService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', '企業・店舗を一括削除しました');
            } else {
                return redirect()->back()->withInput()->with('error', '企業・店舗を一括削除できませんでした');
            }
        }
    }
}
