<x-layout>
    <x-html.section>
        hello
    </x-html.section>


    <x-html.section>
        <div class="flex flex-row flex-wrap justify-start items-stretch">
            @foreach ($auctions as $auction)
                <div class="lg:w-1/4 md:w-1/2 w-full p-2 hover:z-10">

                    <x-auction.card :auction="$auction"/>

                </div>

            @endforeach
        </div>

    </x-html.section>

</x-layout>
