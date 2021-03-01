<div class="border rounded  shadow-dp0 hover:shadow-dp8 transform transition duration-200 flex align-middle flex-col p-4 text-left h-full bg-white">

    <a href="{{route('auctions.show', $auction->id)}}">
        <img src="{{$auction->product->image_url}}" alt="{{$auction->name}}" class="rounded-0"/>
    </a>

    <a href="{{route('auctions.show', $auction->id)}}" class="capitalize text-lg block h-12 mt-3">{{$auction->name}}</a>


    <div class="flex justify-start content-center align-middle my-3">
        <p class="font-bold text-3xl">${{$auction->current_price}}</p>
        <p class="mx-3 border-r border-gray-500"></p>
        <p class="font-bold text-3xl">{{$auction->bids_count}} <span class="text-xs font-normal">BIDS</span></p>
    </div>

    <div class="flex justify-start content-center align-middle">
        <p class="text-xs">{{$auction->end_date}}</p>
    </div>

    <x-html.button src="{{route('auctions.show', $auction->id)}}">View & Bid</x-html.button>

</div>
