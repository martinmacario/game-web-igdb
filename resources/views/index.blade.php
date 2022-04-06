@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Popular Games</h2>
    <livewire:popular-games>
    <div class="flex flex-col lg:flex-row mb-12">
        <div class="recently-view w-full lg:w-3/4 lg:mr-32 mt-8">
            <h2 class="text-blue-500 tracking-wide uppercase">Recently Review</h2>
            <livewire:recently-review-games>
        </div>
        <div class="game-anticipated lg:w-1/4">
            <div class="most-anticipated mt-8 mb-12">
                <h2 class="text-blue-500 tracking-wide uppercase font-semibold mb-6">Most anticipated</h2>
                <livewire:most-anticipated-games>
            </div> <!-- end most anticipated-->
            <div class="comming-soon mt-8 mb-12">
                <h2 class="text-blue-500 tracking-wide uppercase font-semibold mb-6">Comming soon</h2>
                <livewire:comming-soon-games>
            </div> <!-- end comming soon-->
        </div>
    </div>
</div> <!-- end container -->

@endsection
