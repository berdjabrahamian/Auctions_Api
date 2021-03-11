<x-layout>
    <x-slot name="title">
       All Auctions
    </x-slot>


    <x-slot name="metaTags">
        <meta name="description" content="View all auctions"/>
        <link rel="canonical" href="{{route('auctions.index')}}" />

        <meta property="og:title" content="All Auctions"/>
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{route('auctions.index')}}"/>
        <meta property="og:image" content=""/>
        <meta property="og:site_name" content="Berdj Abrahamian Auctions Platform"/>
        <meta property="og:description" content="View all auctions"/>
    </x-slot>


    <x-html.section>
        <div class="flex flex-row flex-wrap justify-start items-stretch" id="scrollArea">
            @foreach ($auctions as $auction)
                <x-auction.card :auction="$auction"></x-auction.card>
            @endforeach
        </div>

    </x-html.section>

</x-layout>
