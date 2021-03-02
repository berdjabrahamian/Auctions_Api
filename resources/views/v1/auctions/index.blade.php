<x-layout>
    <x-html.section>
        hello
    </x-html.section>


    <x-html.section>
        <div class="flex flex-row flex-wrap justify-start items-stretch">
            @foreach ($auctions as $auction)
                <x-auction.card :auction="$auction"></x-auction.card>

            @endforeach
        </div>

    </x-html.section>

</x-layout>
