<div class="container-fluid">
    <div class="flex flex-row">
        @foreach ($bids as $bid)
           <div>
               <span class="w-2/5">{{$bid->customer->full_name}}</span>
               <span class="w-1/5">{{$bid->amount}}</span>
               <span class="w-2/5">{{$bid->bid_placed}}</span>
           </div>
        @endforeach
    </div>
</div>
