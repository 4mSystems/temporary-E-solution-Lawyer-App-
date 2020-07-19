<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{$id}}&nbsp; {{trans('site_lang.reports_print_daily_1')}}</title>

    <style>
        body {
            font-family: 'XBRiyaz', sans-serif;
        }
        @media print {
            body {-webkit-print-color-adjust: exact;}
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            font-size: 16px;
            line-height: 24px;
            font-family: 'XBRiyaz', sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: center;

        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: center;

        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            text-align: center;
        }

        table thead {
            background-color: #8E9AA2 !important;
            color: white;
            padding-top: 10px;
            padding-bottom: 10px;

        }
        table, th, td {
            border: 1px solid #eee;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: 'XBRiyaz', sans-serif;
        }

        .rtl table {
            text-align: center;

        }

        .rtl table tr td:nth-child(2) {
            text-align: center;

        }
    </style>
</head>

<body>
<div class="invoice-box">
    <div class="title">
        <img src="{{url('/images/print_logo.png') }}" style="width:100%; max-width:50px;">
    </div>
    <div
        style="text-align:center;font-size: 30px;background-color: #8E9AA2;color: white; padding-top: 15px; padding-bottom: 15px;">
        <hl class="center">{{$id}}&nbsp; {{trans('site_lang.reports_print_daily_1')}}</hl>
    </div>
    <br>
    <table cellpadding="0" cellspacing="0">
        <thead>
        <th>{{trans('site_lang.mohdar_notes')}}</th>
        <th>{{trans('site_lang.home_session_date')}}</th>
        <th>{{trans('site_lang.add_case_court')}}</th>
        <th>{{trans('site_lang.add_case_inventation_type')}}</th>
        <th>{{trans('site_lang.add_case_circle_num')}}</th>
        <th>{{trans('site_lang.home_session_case_number')}}</th>
        <th>{{trans('site_lang.clients_client_type_khesm')}}</th>
        <th>{{trans('site_lang.clients_client_type_client')}}</th>
        <th>#</th>
        </thead>
        <tbody style="border: 1px solid black;">
        @php
            $i=1;
        @endphp
        @foreach($data as $row)
            <tr class="item">
                @if ($row->Printnotes ==null)
                    <td class="center">----</td>
                @else
                    <td class="center">{{$row->Printnotes->note}}</td>
                @endif
                <td class="center">{{$row->session_date}}</td>
                <td class="center">{{$row->cases->court}}</td>
                <td class="center">{{$row->cases->inventation_type}}</td>
                <td class="center">{{$row->cases->circle_num}}</td>
                <td class="center">{{$row->cases->invetation_num}}</td>
                <td class="center">{{$khesm->client_Name}}</td>
                <td class="center">{{$clients->client_Name}}</td>
                <td class="center">
                    {{$i}}
                </td>
            </tr>
            @php
                $i=$i+1;
            @endphp
        @endforeach
        </tbody>
    </table>
</div>
<script>
    window.print();
</script>
</body>
</html>
