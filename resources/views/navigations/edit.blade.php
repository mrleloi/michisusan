<x-manage.container>
    <x-flash></x-flash>
    <navigations-edit
        :navigation="{{ json_encode($navigation) }}"
        :sub-sp-menus="{{ json_encode($subSpMenus) }}"
        :fonts="{{ json_encode($fonts) }}"
        :weights="{{ json_encode($fontWeights) }}"
        :animations="{{ json_encode($hoverAnimations) }}"
        :pages="{{ json_encode($startPages) }}"
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
        :back-path='{{ json_encode(route('navigations.index')) }}'
    />
</x-manage.container>
