<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Report</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->

    <link rel="stylesheet" href="{{url('/plugins/bootstrap/css/bootstrap.min.css') }}"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('/css/fontcairo2.css') }}">
    <link rel="stylesheet" href="{{url('/css/styles.css') }}">
    <link rel="stylesheet" href="{{url('/css/styles-responsive.css') }}">
    <link rel="stylesheet" href="{{url('/css/plugins.css') }}">
    <link rel="stylesheet" href="{{url('/css/themes/theme-default.css') }}" type="text/css" id="skin_color">
    <link rel="stylesheet" href="{{url('/plugins/nvd3/nv.d3.min.css') }}">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>

<!--    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>-->
    <!--    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <![endif]-->
</head>
<body style="background: whitesmoke">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div style="text-align:center;font-size: 30px;background-color: #8E9AA2;color: white;">
                <hl class="center">{{$search_date}}&nbsp; {{trans('site_lang.reports_print_daily_1')}}</hl>
            </div>
            <br>
            <div class="panel panel-white">


                <div class="panel-body" >
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered   table-full-width"
                               id="PrintdailyTable">
                            <thead >
                            <tr>
                                <th class="center">{{trans('site_lang.mohdar_notes')}}</th>
                                <th class="center">{{trans('site_lang.home_session_date')}}</th>
                                <th class="center">{{trans('site_lang.add_case_court')}}</th>
                                <th class="center">{{trans('site_lang.add_case_inventation_type')}}</th>
                                <th class="center">{{trans('site_lang.add_case_circle_num')}}</th>
                                <th class="center">{{trans('site_lang.home_session_case_number')}}</th>
                                <th class="center">{{trans('site_lang.clients_client_type_khesm')}}</th>
                                <th class="center">{{trans('site_lang.clients_client_type_client')}}</th>
                                <th class="center">#</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach($data as $row)
                                <tr>
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
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>--}}
<!-- Include all compiled plugins (below), or include individual files as needed -->
{{--<script src="js/bootstrap.min.js"></script>--}}

<script src="{{url('/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<script src="{{url('/js/index.js') }}"></script>

<script src="{{url('/js/main.js') }}"></script>
<!-- end: CORE JAVASCRIPTS  -->
<script>
    jQuery(document).ready(function () {
        Main.init();
        Index.init();
        @yield('scriptDocument')

    });
</script>
</body>
</html>
