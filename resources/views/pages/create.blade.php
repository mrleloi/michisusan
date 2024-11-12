<x-manage-edit.container>
    <parts-edit-form></parts-edit-form>

    <parts-setting-dialog></parts-setting-dialog>

    <page-setting-dialog :pages='@json($pages)' new-page>
        @csrf
    </page-setting-dialog>

</x-manage-edit.container>
