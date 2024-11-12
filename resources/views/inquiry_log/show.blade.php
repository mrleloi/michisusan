<x-manage.container>
    <x-flash></x-flash>
    @push('styles')
        @vite('resources/css/table.css')
    @endpush
    <h1 class="text-3xl mb-3">お問い合わせ内容詳細</h1>
    <div class="border">
        <div class="bg-zinc-200 p-4">

        </div>
        <div class="p-4">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th>受信日時</th>
                        <td>{{ $inquiryLog->received_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>メールの内容</th>
                        <td>{{ $inquiryLog->mail_body }}
                        </td>
                    </tr>
                    <tr>
                        <th>ユーザーエージェント</th>
                        <td>{{ $inquiryLog->user_agent }}
                        </td>
                    </tr>
                    <tr>
                        <th>IPアドレス</th>
                        <td>{{ $inquiryLog->ip_address }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center my-8">
                <a href="{{ route('inquiry_log.index') }}">
                    <pv-button size="small" label="一覧に戻る" rounded class=""></pv-button>
                </a>
            </div>
        </div>
    </div>
</x-manage.container>
