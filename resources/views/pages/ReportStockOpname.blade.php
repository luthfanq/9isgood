<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ public_path('css\bootstrap.css') }}" media="all" />
    <title>Document</title>
</head>
<body>
    <div class="text-center">
        <h2 class="text-capitalize" style="font-weight: bolder">Stock Opname</h2>
        <h3><strong>Periode 2021-2022</strong></h3>
    </div>
    <table class="table table-bordered" style="margin-top: 20px">
        <tr>
            <th class="text-center" width="15%">Gudang</th>
            <th class="text-center" width="10%">Kode</th>
            <th class="text-center" width="60%">Produk</th>
            <th class="text-center" width="15%">Stock</th>
        </tr>
        @foreach($dataStockOpname as $item)
            <tr>
                <td class="text-center">
                    {{ucwords($item->gudang->nama)}}
                    {{($item->jenis=='rusak') ? 'Rusak' : null}}
                </td>
                <td class="text-center">{{$item->produk->kode_lokal}}</td>
                <td>
                    {{$item->produk->nama}}
                    {{$item->produk->kategoriHarga->nama}} {{$item->produk->cover}}
                </td>
                <td class="text-center">{{$item->stock_opname}}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
