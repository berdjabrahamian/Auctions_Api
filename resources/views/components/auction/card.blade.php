<?php /** @see \App\View\Components\Auction\Card */ ?>
<div class="xl:w-1/4 lg:w-1/3 md:w-1/2 w-full p-2 hover:z-10 text-gray-700 auctionCard">
    <div class="auction border rounded shadow-dp0 hover:shadow-dp8 transform transition duration-200 flex align-middle flex-col p-4 text-left h-full bg-white auction_{{$auction->getState()}}"
         data-auction_id="{{$auction->id}}"
         data-auction_type="{{$auction->type}}"
         data-auction_status="{{$auction->getState()}}">

        <a href="{{route('auctions.show', $url)}}">
            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="{{$auction->product->image_url}}" alt="{{$auction->name}}" class="max-h-80 w-full"/>
        </a>

        <a href="{{route('auctions.show', $url)}}" class="capitalize text-lg block h-12 my-3">{{$auction->name}}</a>

        <div class="auctionBlock">
            <div class="flex justify-start flex-wrap flex-col my-5 relative">

                @if (!$auction->has_started)
                    <x-auction.status.started :auction="$auction"/>
                @elseif($auction->has_started && !$auction->has_ended)
                    <x-auction.status.running :auction="$auction"/>
                @else
                    <x-auction.status.ended :auction="$auction"/>
                @endif
            </div>

            <x-auction.countdown  state="{{$auction->getState()}}" end_date="{{$auction->end_date->toIso8601String()}}" start_date="{{$auction->start_date->toIso8601String()}}" timestamp="{{$auction->end_date->getTimestamp()}}"/>

        </div>

        <a href="{{route('auctions.show', $url)}}" class="w-full py-3 block text-center font-bold uppercase my-2 bottom-0" data-auction_button>{{$button_text}}</a>

    </div>

</div>
