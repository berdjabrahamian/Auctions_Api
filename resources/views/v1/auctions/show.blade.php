<x-layout>

    <div class="flex lg:flex-row flex-col flex-wrap justify-start content-start align-top">
        <div class="w-full lg:w-2/3">
            <x-html.image src="{{$auction->product->image_url}}" alt="{{$auction->name}}"></x-html.image>
        </div>

        <div class="w-full lg:w-1/3">
            <h1>{{$auction->name}}</h1>
            <p class="text-sm font-bold">{{$auction->product->sku}}</p>



            <p>Current_Price:{{$auction->current_price}}</p>
            <p>Bids Count: {{$auction->bids_count}}</p>
            <p>End Date:{{$auction->end_date}}</p>
            <p>Start Date:{{$auction->start_date}}</p>

            <p>{{$auction->product->description}}</p>

        </div>
    </div>

</x-layout>
