<x-layout>

    <div class="flex lg:flex-row flex-col flex-wrap justify-start content-start align-top">
        <div class="w-full lg:w-2/3">
            <x-html.image src="{{$auction->product->image_url}}" alt="{{$auction->name}}"></x-html.image>
        </div>

        <div class="w-full lg:w-1/3">
            <div class="auction flex align-middle flex-col p-4 text-left h-full auction_{{$auction->getState()}}"
                 data-auction_id="{{$auction->id}}"
                 data-auction_status="{{$auction->getState()}}">

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

                    <div class="flex justify-start content-start align-middle flex-wrap flex-col mb-3"
                         data-auction_countdown="{{$auction->end_date->getTimestamp()}}"
                         data-auction_end_date="{{$auction->end_date}}"
                         data-auction_start_date="{{$auction->start_date}}"></div>
                </div>


            </div>
        </div>
    </div>

</x-layout>
