@php
    $sns = $site->siteSnsSetting;
@endphp
<footer class="width_fixed">
	<div id="fixbtn" class="DEVELOP778 scrolled">
		<div class="fixbtnwrap">
			<div id="fixsns">
				<ul class="sns">
					<li class="snstgl"><a href=""><svg><use xlink:href="/img/icon.svg#icon-share"></use></svg></a></li>
					@if($sns->facebook_url && $sns->facebook_show_pc_header)
					<li class="sns_1"><a href="{{ $sns->facebook_url }}" target="_blank"><span></span></a></li>
					@endif
					@if($sns->twitter_url && $sns->twitter_show_pc_header)
					<li class="sns_9"><a href="{{ $sns->twitter_url }}" target="_blank"><span></span></a></li>
					@endif
					@if($sns->line_url && $sns->line_show_pc_header)
					<li class="sns_3"><a href="{{ $sns->line_url }}" target="_blank"><span></span></a></li>
					@endif
					@if($sns->instagram_url && $sns->instagram_show_pc_header)
					<li class="sns_4"><a href="{{ $sns->instagram_url }}" target="_blank"><span></span></a></li>
					@endif
					@if($sns->youtube_url && $sns->youtube_show_pc_header)
					<li class="sns_5"><a href="{{ $sns->youtube_url }}" target="_blank"><span></span></a></li>
					@endif
					@if($sns->tiktok_url && $sns->tiktok_show_pc_header)
					<li class="sns_6"><a href="{{ $sns->tiktok_url }}" target="_blank"><span></span></a></li>
					@endif
					@if($sns->ameblo_url && $sns->ameblo_show_pc_header)
					<li class="sns_7"><a href="{{ $sns->ameblo_url }}" target="_blank"><span></span></a></li>
					@endif
					@if($sns->threads_url && $sns->threads_show_pc_header)
					<li class="sns_8"><a href="{{ $sns->threads_url }}" target="_blank"><span></span></a></li>
					@endif
					@if($sns->other1_url && $sns->other1_show_pc_header)
					<li class="sns_add"><a href="{{ $sns->other1_url }}" target="_blank"><img alt="#" width="" height="" src=""></a></li>
					@endif
					@if($sns->other2_url && $sns->other2_show_pc_header)
					<li class="sns_add"><a href="{{ $sns->other2_url }}" target="_blank"><img alt="#" width="" height="" src=""></a></li>
					@endif
					@if($sns->other3_url && $sns->other3_show_pc_header)
					<li class="sns_add"><a href="{{ $sns->other3_url }}" target="_blank"><img alt="#" width="" height="" src=""></a></li>
					@endif
		</ul>
			</div>
		   <div class="inner">
			 <div class="fixbtntel">
                 @if($headerFooterSetting->show_sticky_footer_tel1)
				 <a href="tel:{{ $headerFooterSetting->tel1 }}" onClick="tel_conversion('tel:{{ $headerFooterSetting->tel1 }}', 'footer', '');">
                    <i class="teli">{{ $headerFooterSetting->tel1_remarks_top }}</i>
                    <svg><use xlink:href="/img/icon.svg#icon-tel"></use></svg>
                    {{ $headerFooterSetting->tel1 }}
                    <i class="teli">{{ $headerFooterSetting->tel1_remarks_bottom }}</i>
                </a>
                 @endif
                @if($headerFooterSetting->show_sticky_footer_business_hours)
                <p>{{ $headerFooterSetting->business_hours }}</p>
                @endif
			</div>
            @if($headerFooterSetting->sticky_footer_button1_alt)
			<div class="contents_btn01">
            <a href="{{ $headerFooterSetting->sticky_footer_button1_link_url }}"
                @if($headerFooterSetting->sticky_footer_button1_link_open_type == '2')
                target="_blank"
                @endif
            >
                <span>{{ $headerFooterSetting->sticky_footer_button1_alt }}</span>
            </a>
			</div>
            @endif
            @if($headerFooterSetting->sticky_footer_button2_alt)
			<div class="contents_btn01">
            <a href="{{ $headerFooterSetting->sticky_footer_button2_link_url }}"
                @if($headerFooterSetting->sticky_footer_button2_link_open_type == '2')
                target="_blank"
                @endif
            >
                <span>{{ $headerFooterSetting->sticky_footer_button2_alt }}</span>
            </a>
			</div>
            @endif
			 <div id="scrolltop"><a href="#top"></a></div>
		   </div>
		</div>
	</div>
	<div class="content_wrapper">
		<nav>
			<ul>
				@foreach($menu as $page)
				<li><a href="{{ $page->directory }}"><span>{{ $page->title }}</span></a></li>
				@endforeach
			</ul>
		</nav>
		<div class="logo">
				<a href="/">
				<img src="{{ $headerFooterSetting->footerLogoUrl() }}" alt="">
			</a>
		</div>
	</div>
	<div id="cp">&copy; {{ \Carbon\Carbon::now()->format('Y') }} {{ $site->copyright }} ALL RIGHTS RESERVED.</div>
</footer>