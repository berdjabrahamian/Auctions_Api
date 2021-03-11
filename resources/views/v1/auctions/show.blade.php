<x-layout>
    <x-slot name="title">
        {{$auction->name}}
    </x-slot>


    <x-slot name="metaTags">
        <meta name="description" content="View all auctions"/>
        <link rel="canonical" href="{{route('auctions.show', $auction->slug)}}" />

        <meta property="og:title" content="{{$auction->name}}"/>
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{route('auctions.show', $auction->slug)}}"/>
        <meta property="og:image" content="{{$auction->product->image_url}}"/>
        <meta property="og:site_name" content="Berdj Abrahamian Auctions Platform"/>
        <meta property="og:description" content="{{$auction->product->description}}"/>

    </x-slot>

    <div class="flex lg:flex-row flex-col flex-wrap justify-start content-start align-top mb-10">
        <div class="w-full lg:w-2/3 lg:px-5">
            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3Z" data-src="{{$auction->product->image_url}}" alt="{{$auction->name}}" class="rounded-0"/>
        </div>

        <div class="w-full lg:w-1/3 lg:px-5">
            <div class="auction flex align-middle flex-col text-left h-full auction_{{$auction->getState()}}"
                 data-auction_id="{{$auction->id}}"
                 data-auction_type="{{$auction->type}}"
                 data-auction_status="{{$auction->getState()}}">


                <p class="capitalize text-2xl block">{{$auction->name}}</p>
                <p class="text-base text-gray-500 mt-3"><span>Item ID:</span>{{$auction->product->sku}}</p>

                <fieldset class="border border-1 border-auction-blue-600 py-3 px-5 bg-gray-100 mt-5">
                    <legend class="uppercase font-bold px-5 relative">{{$auction->type}} Auction <span class="text-xs cursor-pointer">learn more</span></legend>
                    <div class="auctionBlock bg-gray-100 px-5 my-5">
                        <div class="flex justify-start content-center align-middle my-3">

                            @if (!$auction->has_started)
                                <x-auction.status.started :auction="$auction"/>
                            @elseif($auction->has_started && !$auction->has_ended)
                                <x-auction.status.running :auction="$auction"/>
                            @else
                                <p class="font-bold text-3xl border-r pr-2 mr-2" data-auction_price>{{$auction->current_price}}</p>
                                <p class="font-bold text-3xl" data-auction_bid_count>{{$auction->bids_count}} <span class="text-xs">BIDS</span></p>

                            @endif
                        </div>


                        <div class="flex justify-start content-center align-middle flex-wrap flex-col mb-3"
                             data-auction_countdown="{{$auction->end_date->getTimestamp()}}"
                             data-auction_end_date="{{$auction->end_date}}"
                             data-auction_start_date="{{$auction->start_date}}">

                            <div class="countdown"></div>
                            <div class="auctionTimer"></div>
                        </div>
                    </div>
                </fieldset>


                <div class="auctionBlock bg-gray-100 px-5 my-5">
                    <div class="flex justify-start content-center align-middle my-3">

                        @if (!$auction->has_started)
                            <x-auction.status.started :auction="$auction"/>
                        @elseif($auction->has_started && !$auction->has_ended)
                            <x-auction.status.running :auction="$auction"/>
                        @else
                            <p class="font-bold text-3xl border-r pr-2 mr-2" data-auction_price>{{$auction->current_price}}</p>
                            <p class="font-bold text-3xl" data-auction_bid_count>{{$auction->bids_count}} <span class="text-xs">BIDS</span></p>

                        @endif
                    </div>


                    <div class="flex justify-start content-center align-middle flex-wrap flex-col mb-3"
                         data-auction_countdown="{{$auction->end_date->getTimestamp()}}"
                         data-auction_end_date="{{$auction->end_date}}"
                         data-auction_start_date="{{$auction->start_date}}">

                        <div class="countdown"></div>
                        <div class="auctionTimer"></div>
                    </div>
                </div>

                <a href="{{route('auctions.show', $auction->pub_id)}}"
                   class="w-full py-3 block text-center font-bold uppercase my-2 bottom-0" data-auction_button>BID NOW</a>

            </div>
        </div>
    </div>


    <div class="flex border p-10">
        <strong>DETAILS</strong>
        Auction ID: {{$auction->pub_id}}
    </div>

    <div class="flex flex-row flex-wrap border p-10">

        <p>{{$auction->product->description}}</p>
    </div>

</x-layout>
