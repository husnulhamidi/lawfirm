<!DOCTYPE html>
<html>
<head>
    <title>Barcode Labels</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .label-container {
            width: 103mm; /* Set width to match label paper width */
            margin: 10px auto; /* Set top and bottom margins, and center horizontally */
            overflow: hidden; /* Clear the float */
        }
        .label {
            height: auto;
            float: left;
            /* border: 1px solid black; Adjust border thickness */
            margin-right: 5px; /* Adjust spacing between labels */
            margin-bottom: 20px; /* Adjust spacing between rows */
            width: 121px;
        }
        img {
            width: 85%;
        }
        .barcode {
            text-align: center;
        }
        .item-details {
            margin-top: -5px; /* Adjust item details position */
            font-size: 9px; /* Adjust item details font size */
        }
        @page {
            margin-left: 2mm; /* Adjust page margins */
            margin-right: 2mm; /* Adjust page margins */
        }
    </style>
</head>
<body>
    @php
        $counter = 0;
    @endphp
    <div class="label-container">
        @foreach($barang as $item)
            @php
                $counter++;
            @endphp
            <div class="label">
                <div class="barcode">
                    <div class="item-details">
                        {{ $item['nama_barang'] }}
                    </div>
                    <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($item['barcode'], 'EAN13',1.2,50,array(1,1,1), true)}}" alt="barcode" />
                </div>
            </div>
            @if ($counter == 9)
                <!-- Create a new page -->
                <div style="page-break-before: always;"></div>
                @php
                    $counter = 0;
                @endphp
            @endif
        @endforeach
    </div>
</body>
</html>
