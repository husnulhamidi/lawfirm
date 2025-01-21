<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
    <style type="text/css">
        @page {
            margin-top: 30spx;
            margin-bottom: 25px;
            margin-left: 40px;
            margin-right: 25px;
        }
        @media print {
                
                
                .page-break  { display: block; page-break-before: always; }
                .page-break-after { display: block; page-break-after: always; }
                .page-break  {page-break-after: always;}
                .page {
                    margin: ;
                    border: none;
                    border-radius: none;
                    width: initial;
                    min-height: initial;
                    box-shadow: none;
                    background: initial;
                    /*page-break-after: always;*/
                }
                .page_landscape {
                    margin: 0;
                    border: initial;
                    border-radius: initial;
                    width: initial;
                    min-height: initial;
                    box-shadow: initial;
                    background: initial;
                    page-break-after: always;
                }
                
                thead {display: table-header-group;}
                
                .page {
                    -webkit-box-shadow: none;
                    -moz-box-shadow:    none;
                    box-shadow:         none; 
                }
                .footer { position: fixed; left: 0px; bottom: -145px; right: 0px; height: 150px; }

        }
        .footer { position: fixed; left: 0px; bottom: -145px; right: 0px; height: 150px; }

        .table-utama{
            width:100%;
            border:1px;
        }
        .table-utama thead tr td{
            text-align: center;

        }
        .table-utama tbody tr td{
            padding-left:10px;
            border:1px;

        }
        .table-utama tbody tr td .textalamat{
            padding-left:18px;
        }
        .textsambutan{
            text-align: justify;
            padding-right:10px;
        }
        .border-div{
            border:1px solid black;
            width:100%;
            margin:2px;
            height: 26.4cm;
        }
        hr{
            border-top:2px solid black;
            border-bottom:3px solid black;
        }
        .text-center{
            text-align:center;
        }
        .text-justify{
            text-align:justify;
        }
        .table-isi tbody tr td{
            padding-left:0px;

        }
        .dlist{
            padding-left:8px;
        }
        .table-print-header {
                padding: 0px;
                margin: 0px;
                border-top: 1px solid #333333;
                border-left: 1px solid #333333;
                border-collapse: collapse;
                font-family: Times New Roman;
            }

            .table-print-header th {
                text-align: center;
                /*font-weight: bold;*/
                border-right: 1px solid #333333;
                border-bottom: 1px solid #333333;
               
               padding: 3px;
                margin:0px;
                font-family: 'Times New Roman';
            }

            .table-print-header td {
                
                border-right: 1px solid #333333;
                border-bottom: 1px solid #333333;
                
                padding: 2px 2px 2px 4px;
                margin:0px;
                font-size: 10;
            }

            .table-print {
                padding: 0px;
                margin: 0px;
                border-top: 1px solid #333333;
                border-left: 1px solid #333333;
                border-collapse: collapse;
                font-family: Times New Roman;
            }

            .table-print th {
                text-align: center;
                /*font-weight: bold;*/
                border-right: 1px solid #333333;
                border-bottom: 1px solid #333333;
               
               padding: 3px;
                margin:0px;
                font-family: 'Times New Roman';
            }

            .table-print td {
                
                border-right: 1px solid #333333;
                border-bottom: 1px solid #333333;
                
                padding:2px;
                margin:0px;
                font-size: 9;
            }
            .border-btm{
                border-bottom: 1px solid #ccc
            }
            main{
                margin-top:0px;
            }
            header {
                position: fixed;
                top: 10px;
                left: 0px;
                right: 0px;
                height: 30px;
            }
            footer {
                position: fixed; 
                bottom: -10px; 
                left: 0px; 
                right: 0px;
                height: 15px; 
                font-size: 12px !important;
            }
            .page-number:before {
                content: "Page " counter(page);
            }

    </style>
</head>
<body style="font-size:10">
   
    <footer>
        <table width="100%">
            <tr>
                <td> {{ date("Y") }} © LAW FIRM R.I</td>
                <td><span style="font-size:9px">Dicetak oleh : {{ucwords(strtolower(auth()->user()->name))}}, pada : @php echo date('d F Y H:i:s'); @endphp<span></div></td>
                <td align="right"> <div class="page-number"></div></td>
            </tr>
        </table>
       </p>
    </footer>

   <h3> <center> RIWAYAT ORDER</center></h3>
    <table width="100%">
        <tr>
            <td width="180px" style="border-bottom:1px dotted #c2c2c2">NAMA NASABAH</td><td width="5px">:</td>
            <td style="border-bottom:1px dotted #c2c2c2">{{$order->nama_nasabah}}</td>
        </tr>
        <tr >
            <td style="border-bottom:1px dotted #c2c2c2">TANGGAL</td><td width="5px">:</td>
            <td style="border-bottom:1px dotted #c2c2c2">{{date('d F Y',strtotime($order->tanggal_order))}}</td>
        </tr>
        <tr >
            <td style="border-bottom:1px dotted #c2c2c2">JENIS ORDER</td><td width="5px">:</td>
            <td style="border-bottom:1px dotted #c2c2c2">{{$order->jenisOrder->name}}</td>
        </tr>
        <tr >
            <td style="border-bottom:1px dotted #c2c2c2">INVOICE</td><td width="5px">:</td>
            <td style="border-bottom:1px dotted #c2c2c2">Rp. {{number_format($order->invoice,0,',','.')}}</td>
        </tr>
        <tr>
            <td  style="border-bottom:1px dotted #c2c2c2">PENGELUARAN INVOICE</td><td width="5px">:</td>
            <td  style="border-bottom:1px dotted #c2c2c2">Rp. {{number_format($order->pengeluaran,0,',','.')}}</td>
        </tr>
       
        
    </table>
    <p><i>Riwayat</i></p>
    <table width='100%' class="table-print">
        <thead>
            <tr>
                <th class="text-center">NO.</th>
                <th class="text-center">TAHAPAN PROSES</th>
                <th class="text-center">PROGRES</th>
                <th class="text-center">KENDALA</th>
                <th class="text-center">KETERANGAN</th>
                <th class="text-center">TANGGAL</th>
            </tr>
        </thead>
        
        @php
        $i=0;   
        @endphp
        @foreach ($order->orderHistory as $key)
            @php
                $i++;
                
                if($key->end_date!=""){
                    $tgl = date("d M Y", strtotime($key->start_date)).' s/d '.date("d M Y", strtotime($key->end_date)); 
                }else{
                    $tgl = $key->start_date!=""? date("d M Y", strtotime($key->start_date)):"";
                }
                
            @endphp
            <tr>
                <td width='8px' align='center'>{{$i}}</td>
                <td >{{$key->tahapanProses->name}}</td>
                <td >{{$key->progres}}</td>
                <td >{{$key->kendala}}</td>
                <td >{{$key->keterangan}}</td>
                <td >{{$tgl}}</td>
                
            </tr>
        @endforeach

        </table>
        
</body>
</html>
