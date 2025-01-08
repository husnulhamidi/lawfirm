<table>
    <thead>
    <tr>
        <th width="10" style="background-color: #00bfff">NO.</th>
        <th width="15" style="background-color: #00bfff">TANGGAL SERVICE</th>
        <th width="20" style="background-color: #00bfff">KODE SERVICE</th>
        <th width="20" style="background-color: #00bfff">PELANGGAN</th>
        <th width="30" style="background-color: #00bfff">SERVICE</th>
        <th width="15" style="background-color: #00bfff">BIAYA SERVICE</th>
        <th width="16" style="background-color: #00bfff">BIAYA SPAREPART</th>
        <th width="15" style="background-color: #00bfff">TOTAL</th>

        <th width="25" style="background-color: #9BD3DD">NAMA BARANG</th>
        <th width="15" style="background-color: #9BD3DD">HARGA BELI</th>
        <th width="15" style="background-color: #9BD3DD">QTY</th>
        <th width="15" style="background-color: #9BD3DD">HARGA JUAL</th>
        <th width="17" style="background-color: #9BD3DD">DISKON</th>
        <th width="15" style="background-color: #9BD3DD">TOTAL</th>
    </tr>
    </thead>
    <tbody>
        @php
         $i=0;   
         $subtotal=0;
         $biaya_service=0;
        @endphp
    @foreach($service as $tr)
        @php
            $i++;
            $biaya_service=$biaya_service+$tr->biaya_service;
        @endphp
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $tr->tanggal}}</td>
            <td>{{ $tr->kode_transaksi}}</td>
            <td>{{ $tr->pelanggan->nama_pelanggan}}</td>
            <td>{{ $tr->service}}</td>
            <td>{{ $tr->biaya_service}}</td>
            <td>{{ $tr->grand_total-$tr->biaya_service}}</td>
            <td>{{ $tr->grand_total}}</td>
        </tr>
        @if(COUNT($tr->detail_list)>0)
            @foreach($tr->detail_list as $dt)
            <tr>
                <td colspan="7"></td>
                <td></td>
                <td >{{ @$dt->barang->nama_barang }}</td>
                <td >{{ @$dt->harga_beli }}</td>
                <td>{{ $dt->qty}}</td>
                <td>{{ $dt->harga}}</td>
                <td >{{ $dt->diskon }}</td>
                <td>{{ $dt->total_harga}}</td>
            </tr>
            @endforeach
        
        @endif
    @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td >TOTAL BIAYA SERVICE</td>
            <td >BAYAR HUTANG</td>
            <td ></td>
            <td  colspan="2">TOTAL BIAYA SERVICE</td>
            <td><b>{{ $trans_grand_total}}</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>SUBTOTAL </td>
            <td><b>{{$trans_grand_total-$biaya_service}}</b></td>
        </tr>
        <tr>
            <td></td>
            <td >TUNAI</td>
            <td>{{ $trans_totalCash}}</td>
            <td>{{ $bayar_utang_cash}}</td>
            <td ></td>
            <td  colspan="2">TOTAL PEMBAYARAN via TUNAI</td>
            <td><b>{{ $trans_totalCash+$bayar_utang_cash}}</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>TOTAL MODAL BRG </td>
            <td><b>{{$modal_beli}}</b></td>
        </tr>
        <tr>
            <td></td>
            <td >TRANSFER</td>
            <td>{{ $trans_totalTF}}</td>
            <td>{{ $bayar_utang_tf}}</td>
            <td ></td>
            <td  colspan="2">TOTAL PEMBAYARAN via TRANSFER</td>
            <td><b>{{ $trans_totalTF+$bayar_utang_tf}}</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>LABA </td>
            <td><b>{{$trans_grand_total-$biaya_service-$modal_beli}}</b></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td  colspan="2">BON/HUTANG</td>
            <td><b>{{ $utang}}</b></td>
        </tr>
    </tbody>
</table>