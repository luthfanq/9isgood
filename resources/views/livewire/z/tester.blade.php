<div>
    <x-molecules.card>
        @php
            $saldo = $stockData->sum('stock_saldo');
            $data = [];
        @endphp
        @for($i = 200, $y=0; $y < $stockData->count(); $y++)
            @php
              if ($i < $stockData[$y]->stock_saldo){
                    echo $i.'<br>';
                    echo $y.'<br>';
                    $data[] = (object)[
                        'produk_id'=>$stockData[$y]->produk_id,
                        'jumlah'=>$i,
                        ];
                    break;
                } else {
                    if ($stockData[$y]->stock_saldo == 0 ){
                        continue;
                    }
                    if ($y == $stockData->count() -1){
                         $data[] = (object)[
                        'produk_id'=>$stockData[$y]->produk_id,
                        'jumlah'=>$i,
                        ];
                        break;
                    }
                        $i = $i - $stockData[$y]->stock_saldo;
                        echo $stockData[$y]->stock_saldo.'<br>';
                        echo $y.'<br>';
                        $data[] = (object)[
                        'produk_id'=>$stockData[$y]->produk_id,
                        'jumlah'=>$stockData[$y]->stock_saldo,
                        ];
                }
            @endphp

        @endfor
        @foreach($data as $item)
            Produk_id adalah {{$item->produk_id}} <br>
            Jumlah adalah {{$item->jumlah}} <br>
        @endforeach
    </x-molecules.card>
</div>
