<table>
    <thead>
    <tr>
        <th width="10" style="background-color: #00bfff">NO.</th>
        <th width="15" style="background-color: #00bfff">TANGGAL TRANSAKSI</th>
        <th width="20" style="background-color: #00bfff">KODE TRANSAKSI</th>
        <th width="20" style="background-color: #00bfff">PEMBELI</th>
        <th width="30" style="background-color: #00bfff">NAMA BARANG</th>
        <th width="15" style="background-color: #00bfff">HARGA BELI</th>
        <th width="15" style="background-color: #00bfff">QTY</th>
        <th width="17" style="background-color: #00bfff">HARGA JUAL</th>
        <th width="15" style="background-color: #00bfff">DISKON</th>
        <th width="15" style="background-color: #00bfff">TOTAL</th>

    </tr>
    </thead>
    <tbody>
        @php
         $i=0;   
         $subtotal=0;
        
        @endphp
    @foreach($detail_transaksi as $tr)
        @php
            $i++;
            $subtotal=$subtotal+$tr->total_harga;
        @endphp
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $tr->tanggal_transaksi}}</td>
            <td>{{ $tr->kode_transaksi}}</td>
            <td>{{ $tr->nama_pelanggan}}</td>
            <td>{{ @$tr->barang->nama_barang}}</td>
            <td>{{ $tr->harga_beli}}</td>
            <td>{{ $tr->qty}}</td>
            <td>{{ $tr->harga}}</td>
            <td>{{ $tr->diskon}}</td>
            <td>{{ $tr->total_harga}}</td>
        </tr>
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
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td  colspan="2">SUBTOTAL</td>
            <td><b>{{ $trans_subtotal}}</b></td>
        </tr>
        <tr>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td  colspan="2">TOTAL DISKON</td>
            <td><b>{{ $trans_diskon}}</b></td>
        </tr>
        <tr>
            <td ></td>
            <td ></td>
            <td ></td>
            <td >Transaksi Penjualan</td>
            <td >Bayar Hutang</td>
            <td ></td>
            <td ></td>
            <td  colspan="2">TOTAL PENJUALAN</td>
            <td><b>{{ $trans_grand_total}}</b></td>
        </tr>
        <tr>
             <td ></td>
            <td ></td>
            <td >TUNAI</td>
            <td>{{ $trans_totalCash}}</td>
            <td>{{ $bayar_utang_cash}}</td>
            <td ></td>
            <td ></td>
            <td  colspan="2">TOTAL PEMBAYARAN via TUNAI</td>
            <td><b>{{ $trans_totalCash+$bayar_utang_cash}}</b></td>
        </tr>
        <tr>
             <td ></td>
            <td ></td>
            <td >TRANSFER</td>
            <td>{{ $trans_totalTF}}</td>
            <td>{{ $bayar_utang_tf}}</td>
            <td ></td>
            <td ></td>
            <td  colspan="2">TOTAL PEMBAYARAN via TRANSFER</td>
            <td><b>{{ $trans_totalTF+$bayar_utang_tf}}</b></td>
        </tr>
        <tr>
             <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td  colspan="2">BON/HUTANG</td>
            <td><b>{{ $utang}}</b></td>
        </tr>
        <tr>
            <td ></td>
            <td ></td>
            <td >TOTAL PENJUALAN</td>
            <td >{{ $trans_grand_total}}</td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td></td>
        </tr>
        <tr>
            <td ></td>
            <td ></td>
            <td >MODAL BARANG</td>
            <td >{{ $modal}}</td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td></td>
        </tr>
        <tr>
            <td ></td>
            <td ></td>
            <td >LABA PENJUALAN</td>
            <td >{{ $laba}}</td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td></td>
        </tr>
    </tbody>
</table>