@extends('layouts.app')
@section('title', $article['title'])

@section('content')

<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="font-[Playfair_Display] text-[26px] md:text-[32px] font-bold text-[#2d1a0e]">{{ $article['title'] }}</h1>
        <p class="text-sm text-gray-500 mt-1">Detailed guidance for this help topic.</p>
    </div>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('help-center') }}" class="inline-flex items-center gap-2 border border-[#e5e7eb] text-gray-500 text-[12px] md:text-[13px] font-medium px-4 py-2.5 rounded-lg hover:border-[#7c3a1e] hover:text-[#7c3a1e] transition-colors">
            ← Back to Help Center
        </a>
        <a href="{{ route('settings.index') }}" class="inline-flex items-center gap-2 border border-[#e5e7eb] text-gray-500 text-[12px] md:text-[13px] font-medium px-4 py-2.5 rounded-lg hover:border-[#7c3a1e] hover:text-[#7c3a1e] transition-colors">
            Back to Settings
        </a>
    </div>
</div>

<div class="bg-white rounded-xl border border-[#ede7df] p-6">
    @foreach($article['content'] as $paragraph)
        <p class="text-[14px] text-gray-700 leading-7 mb-4">{{ $paragraph }}</p>
    @endforeach
</div>

@endsection
