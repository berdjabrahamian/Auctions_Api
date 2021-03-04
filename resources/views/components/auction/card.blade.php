<?php /** @see \App\View\Components\Auction\Card */ ?>
<div class="lg:w-1/4 md:w-1/2 w-full p-2 hover:z-10 text-auction-blue auctionCard">
    <div class="auction border rounded shadow-dp0 hover:shadow-dp8 transform transition duration-200 flex align-middle flex-col p-4 text-left h-full bg-white auction_{{$status}}"
         data-auction_id="{{$auction->id}}"
         data-auction_status="{{$status}}">
        <a href="{{route('auctions.show', $auction->pub_id)}}">
            <img src="" data-src="{{$auction->product->image_url}}" alt="{{$auction->name}}" class="rounded-0"/>
        </a>

        <a href="{{route('auctions.show', $auction->id)}}"
           class="capitalize text-lg block h-12 mt-3">{{$auction->name}}</a>

        <div class="auctionBlock">
            <div class="flex justify-start content-center align-middle my-3">

                @if (!$auction->has_started)
                    <x-auction.status.started :auction="$auction"/>
                @elseif($auction->has_started && !$auction->has_ended)
                    <x-auction.status.running :auction="$auction"/>
                @else
                    <x-auction.status.ended :auction="$auction"/>
                @endif
            </div>

            <div class="flex justify-start content-center align-middle flex-wrap flex-col mb-3"
                 data-auction_countdown="{{$countdown}}"
                 data-auction_end_date="{{$auction->end_date}}"
                 data-auction_start_date="{{$auction->start_date}}"></div>
        </div>

        <a href="{{route('auctions.show', $auction->pub_id)}}"
           class="w-full py-3 block text-center font-bold uppercase my-2 bottom-0 " data-auction_button>{{$button_text}}</a>

    </div>

</div>
