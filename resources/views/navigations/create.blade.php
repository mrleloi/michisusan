<x-manage.container>
    <x-flash></x-flash>
    <navigations-add
        :fonts="{{ json_encode($fonts) }}"
        :weights="{{ json_encode($fontWeights) }}"
        :animations="{{ json_encode($hoverAnimations) }}"
        :pages="{{ json_encode($startPages) }}"
        :path='{{json_encode(route('navigations.store'))}}'
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
        :back-path='{{ json_encode(route('navigations.index')) }}'
    />
</x-manage.container>
