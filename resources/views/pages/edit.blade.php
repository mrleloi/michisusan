<x-manage-edit.container>
    <parts-edit-form :page='@json($page)'></parts-edit-form>

    <parts-setting-dialog :page='@json($page)'></parts-setting-dialog>

    <page-setting-dialog :pages='@json($pages)' :page='@json($page)'>
        @csrf
    </page-setting-dialog>

</x-manage-edit.container>
