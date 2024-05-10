@extends('layouts.app')

@section('title', 'General Error')

@section('content')

    <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
        <div
            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">
                <img class="size-5 sm:size-6" src="{{ asset('img/error.png') }}"/>
            </div>

            <div class="pt-3 sm:pt-5">
                <h2 class="text-xl font-semibold text-black dark:text-white">Something Went Wrong</h2>

                @if(!empty($message))
                    <p class="mt-4 text-sm/relaxed">{{ $message }}</p>
                @else
                    <p class="mt-4 text-sm/relaxed">We're sorry, an error has occurred.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
