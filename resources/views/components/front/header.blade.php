@php
    $sns = $site->siteSnsSetting;
@endphp
<div class="w-full flex justify-center whitespace-nowrap px-4">
    <header id="pattern{{ $site->header_layout }}" class="">
        <div class="wraper">
            <div class="inner">
                <h1>{{ $page->title }}</h1>
                <div class="logo">
                    <a href="/">
                        <img src="{{ $headerFooterSetting->headerLogoUrl() }}" alt="">
                    </a>
                </div>
                <!-- バーガーメニュー -->
                <div class="burger">
                    <ul>
                        <li class="header_sns_sp">
                            <ul>
                                @if($sns->line_url && $sns->line_show_sp_header)
                                <li><a href="{{ $sns->line_url }}" target="_blank" class="header_sns_line sns_sp"></a></li>
                                @endif
                                @if($sns->instagram_url && $sns->instagram_show_sp_header)
                                <li class="on"><a href="{{ $sns->instagram_url }}" target="_blank" class="header_sns_instagram sns_sp"></a></li>
                                @endif
                                @if($sns->tiktok_url && $sns->tiktok_show_sp_header)
                                <li class="on"><a href="{{ $sns->tiktok_url }}" target="_blank" class="header_sns_tiktok sns_sp"></a></li>
                                @endif
                                @if($sns->youtube_url && $sns->youtube_show_sp_header)
                                <li class="on"><a href="{{ $sns->youtube_url }}" target="_blank" class="header_sns_youtube sns_sp"></a></li>
                                @endif
                                @if($sns->facebook_url && $sns->facebook_show_sp_header)
                                <li class="on"><a href="{{ $sns->facebook_url }}" target="_blank" class="header_sns_facebook sns_sp"></a></li>
                                @endif
                                @if($sns->twitter_url && $sns->twitter_show_sp_header)
                                <li class="on"><a href="{{ $sns->twitter_url }}" target="_blank" class="header_sns_twitter sns_sp"></a></li>
                                @endif
                                @if($sns->threads_url && $sns->threads_show_sp_header)
                                <li class="on"><a href="{{ $sns->threads_url }}" target="_blank" class="header_sns_threads sns_sp"></a></li>
                                @endif
                                @if($sns->ameblo_url && $sns->ameblo_show_sp_header)
                                <li class="on"><a href="{{ $sns->ameblo_url }}" target="_blank" class="header_sns_ameblo sns_sp"></a></li>
                                @endif
                                @if($sns->other1_url && $sns->other1_show_sp_header)
                                <li class="on"><a href="{{ $sns->other1_url }}" target="_blank" class="header_sns_other1 sns_sp"><img alt="#" width="" height="" src=""></a></li>
                                @endif
                                @if($sns->other2_url && $sns->other2_show_sp_header)
                                <li class="on"><a href="{{ $sns->other2_url }}" target="_blank" class="header_sns_other2 sns_sp"><img alt="#" width="" height="" src=""></a></li>
                                @endif
                                @if($sns->other3_url && $sns->other3_show_sp_header)
                                <li class="on"><a href="{{ $sns->other3_url }}" target="_blank" class="header_sns_other3 sns_sp"><img alt="#" width="" height="" src=""></a></li>
                                @endif
                            </ul>
                        </li>
                        @if($site->sitePaymentSetting?->show_payment_button)
                        <li class="sp_payment"><a href="#mypayment" class="no"><svg><use xlink:href="/img/icon.svg#icon-payment"></use></svg></a></li>
                        @endif
                        @if($headerFooterSetting->show_header_translation)
                        <li class="sp_translate"><a href="#"><svg><use xlink:href="/img/icon.svg#icon-translate"></use></svg></a></li>
                        @endif
                        <li class="sp_menu mm0"><a href="#" class="no"><div><span>Menu</span></div></a></li>
                    </ul>
                </div>
                <div class="header_contents">
                    <div class="inner">
                        <div class="header_col1">
                            <!-- 電話番号 -->
                            @if($headerFooterSetting->show_header_tel1)
                            <div class="tel" x-ms-format-detection="none">
                                <a href="tel:{{ $headerFooterSetting->tel1 }}" onClick="tel_conversion('{{ $headerFooterSetting->tel1 }}', 'header', '');">
                                    <i class="teli">{{ $headerFooterSetting->tel1_remarks_top }}</i>
                                    <svg><use xlink:href="/img/icon.svg#icon-tel"></use></svg>
                                    {{ $headerFooterSetting->tel1 }}
                                    <i class="teli">{{ $headerFooterSetting->tel1_remarks_bottom }}</i>
                                </a>
                            </div>
                            @endif
                            @if($headerFooterSetting->show_header_tel2)
                            <div class="tel" x-ms-format-detection="none">
                                <a href="tel:{{ $headerFooterSetting->tel2 }}" onClick="tel_conversion('{{ $headerFooterSetting->tel2 }}', 'header', '');">
                                    <i class="teli">{{ $headerFooterSetting->tel2_remarks_top }}</i>
                                    <svg><use xlink:href="/img/icon.svg#icon-tel"></use></svg>
                                    {{ $headerFooterSetting->tel2 }}
                                    <i class="teli">{{ $headerFooterSetting->tel2_remarks_bottom }}</i>
                                </a>
                            </div>
                            @endif
                            <!-- ボタン -->
                            @if($headerFooterSetting->show_header_button)
                            <div class="btn hastrans">
                                @if($headerFooterSetting->header_button1_alt)
                                <a href="{{ $headerFooterSetting->header_button1_link_url }}"
                                    @if($headerFooterSetting->header_button1_link_open_type == '2')
                                    target="_blank"
                                    @endif
                                >{{ $headerFooterSetting->header_button1_alt }}
                                </a>
                                @endif
                                @if($headerFooterSetting->header_button2_alt)
                                <a href="{{ $headerFooterSetting->header_button2_link_url }}"
                                    @if($headerFooterSetting->header_button2_link_open_type == '2')
                                    target="_blank"
                                    @endif
                                >{{ $headerFooterSetting->header_button2_alt }}</a>
                                @endif
                                <div class="header_sns new_sns on" style="height: auto; opacity: 1; padding-bottom: 0px;">
                                    <!-- SNSアイコン -->
                                    <ul>
                                        @if($sns->line_url && $sns->line_show_pc_header)
                                        <li class="on"><a href="{{ $sns->line_url }}" target="_blank" class="header_sns_line"></a></li>
                                        @endif
                                        @if($sns->instagram_url && $sns->instagram_show_pc_header)
                                        <li class="on"><a href="{{ $sns->instagram_url }}" target="_blank" class="header_sns_instagram"></a></li>
                                        @endif
                                        @if($sns->tiktok_url && $sns->tiktok_show_pc_header)
                                        <li class="on"><a href="{{ $sns->tiktok_url }}" target="_blank" class="header_sns_tiktok"></a></li>
                                        @endif
                                        @if($sns->youtube_url && $sns->youtube_show_pc_header)
                                        <li class="on"><a href="{{ $sns->youtube_url }}" target="_blank" class="header_sns_youtube"></a></li>
                                        @endif
                                        @if($sns->facebook_url && $sns->facebook_show_pc_header)
                                        <li class="on"><a href="{{ $sns->facebook_url }}" target="_blank" class="header_sns_facebook"></a></li>
                                        @endif
                                        @if($sns->twitter_url && $sns->twitter_show_pc_header)
                                        <li class="on"><a href="{{ $sns->twitter_url }}" target="_blank" class="header_sns_twitter"></a></li>
                                        @endif
                                        @if($sns->threads_url && $sns->threads_show_pc_header)
                                        <li class="on"><a href="{{ $sns->threads_url }}" target="_blank" class="header_sns_threads"></a></li>
                                        @endif
                                        @if($sns->ameblo_url && $sns->ameblo_show_pc_header)
                                        <li class="on"><a href="{{ $sns->ameblo_url }}" target="_blank" class="header_sns_ameblo"></a></li>
                                        @endif
                                        @if($sns->other1_url && $sns->other1_show_pc_header)
                                        <li class="on"><a href="{{ $sns->other1_url }}" target="_blank" class="header_sns_other1"></a></li>
                                        @endif
                                        @if($sns->other2_url && $sns->other2_show_pc_header)
                                        <li class="on"><a href="{{ $sns->other2_url }}" target="_blank" class="header_sns_other2"></a></li>
                                        @endif
                                        @if($sns->other3_url && $sns->other3_show_pc_header)
                                        <li class="on"><a href="{{ $sns->other3_url }}" target="_blank" class="header_sns_other3"></a></li>
                                        @endif
                                    </ul>
                                </div>
                                @if($headerFooterSetting->show_header_translation)
                                <div class="translate"><a href="#"><svg><use xlink:href="/img/icon.svg#icon-translate"></use></svg></a>
                                    <script type="text/javascript">function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage: 'ja', layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT}, 'google_translate_element');}</script>
                                    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                                    <div id="google_translate_element"></div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="header_col2">
                            <p class="add">
                            @if($headerFooterSetting->show_header_address)
                            {{ $headerFooterSetting->address }}<br>
                            @endif
                            @if($headerFooterSetting->show_header_business_hours)
                            {{ $headerFooterSetting->business_hours }}
                            @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav>
            <!-- メニュー -->
            <ul class="nav_1st">
                @foreach($menu as $page)
                    <li id="3gnav_3251407"><a href="/{{ $page->directory }}"><span>{{ $page->title }}</span></a></li>
                    @if($page->children->count())
                        <ul class="nav_2nd">
                        @foreach($page->children as $child)
                            <li id="gnav_3251418"><a href="/{{ $page->directory }}/{{ $child->directory }}"><span>{{ $child->title }}</span></a></li>
                        @endforeach
                        </ul>
                    @endif
                @endforeach
            </ul>
        </nav>
    </header>
</div>