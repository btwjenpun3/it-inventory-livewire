<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tabel Fullwidth Dompdf</title>
    <style>

    </style>
</head>

<body>
    <div class="container" style="margin-bottom:120px;">
        <div class="table-wrapper" style="float: left;">
            <table>
                <tbody>
                    <tr>
                        <td>Article / Style</td>
                        <td>:</td>
                        <td>{{ $orderBuyer->article }}</td>
                    </tr>
                    <tr>
                        <td>KP</td>
                        <td>:</td>
                        <td>{{ $kpData->kp }}</td>
                    </tr>
                    <tr>
                        <td>No. Picklist</td>
                        <td>:</td>
                        <td>{{ $requestData->no_trans }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-wrapper" style="float:right;">
            <table>
                <tbody>
                    <tr>
                        <td>Request Date</td>
                        <td>:</td>
                        <td>{{ $requestData->pick_date }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <table style="width:100%;border:1px solid black;margin-bottom:40px;">
        <thead>
            <tr>
                <th style="border:1px solid black;">ID</th>
                <th style="border:1px solid black;">Item</th>
                <th style="border:1px solid black;">Description</th>
                <th style="border:1px solid black;">Color</th>
                <th style="border:1px solid black;">Size</th>
                <th style="border:1px solid black;">Unit</th>
                <th style="border:1px solid black;">Qty</th>
                <th style="border:1px solid black;">UOM</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border:1px solid black;text-align:center;">{{ $requestData->id_req }}</td>
                <td style="border:1px solid black;text-align:center;">{{ $kpData->item }}</td>
                <td style="border:1px solid black;text-align:center;">{{ $kpData->desc }}</td>
                <td style="border:1px solid black;text-align:center;">{{ $kpData->color }}</td>
                <td style="border:1px solid black;text-align:center;">{{ $kpData->size }}</td>
                <td style="border:1px solid black;text-align:center;">{{ $kpData->uom }}</td>
                <td style="border:1px solid black;text-align:center;">{{ $kpData->qty }}</td>
                <td style="border:1px solid black;text-align:center;">{{ $kpData->uom1 }}</td>
            </tr>
        </tbody>
    </table>

    <table style="width:100%;">
        <thead>
            <tr>
                <th>Di Buat Oleh,</th>
                <th>Mengetahui,</th>
                <th>Di Periksa,</th>
                <th>Diterima,</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td style="padding-top:60px;text-align:center;">(Supervisor)</td>
                <td style="padding-top:60px;text-align:center;">(Warehouse)</td>
                <td style="padding-top:60px;text-align:center;">
                    (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
