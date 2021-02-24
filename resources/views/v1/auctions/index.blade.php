<x-layout>
    <x-html.section>
        hello
    </x-html.section>


    <x-html.section>
        <div class="flex flex-row flex-wrap justify-start items-stretch">
            @foreach ($auctions as $auction)
                <div class="lg:w-1/4 md:w-1/2 w-full p-2 hover:z-10">
                    <div class="border rounded  shadow-dp0 hover:shadow-dp8 transform transition duration-200 flex align-middle flex-col p-4 text-left h-full bg-white">
                        <x-html.image src="{{$auction->product->image_url}}" alt="{{$auction->name}}" url="{{route('auctions.show', $auction->id)}}"></x-html.image>

                        <div class="mt-4">
                            <a href="{{route('auctions.show', $auction->id)}}" class="capitalize text-base block h-12">{{$auction->name}}</a>

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

                    </div>


                </div>

            @endforeach
        </div>

    </x-html.section>

</x-layout>
