@extends('welcome')
@section('styles')
    <link href="{{url('/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('/plugins/bootstrap-modal/css/bootstrap-modal.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{url('/plugins/select2/select2.css') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection
@section('content')
    <div class="main-container inner">
        <!-- start: PAGE -->
        <div class="main-content">
            <div class="container">
                <!-- start: PAGE HEADER -->
                <!-- start: TOOLBAR -->
                <div class="toolbar row">
                    <div class="col-sm-12 hidden-xs">
                        <div class="page-header">
                            <h3 class="text-bold">{{trans('site_lang.side_Packages')}} </h3>
                        </div>
                    </div>
                </div>
                <!-- end: TOOLBAR -->
                <!-- end: PAGE HEADER -->
                <!-- start: BREADCRUMB -->
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{route('home')}}">
                                    {{trans('site_lang.side_home')}}
                                </a>
                            </li>
                            <li class="active">
                                {{trans('site_lang.side_Packages')}}
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- end: BREADCRUMB -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- start: DYNAMIC TABLE PANEL -->
                        <div class="panel panel-white">
                            <div class="panel-heading">

                                <a class="btn btn-primary" id="addClientModal"><i

                                        class="fa fa-plus"></i>{{trans('site_lang.Add_package')}} </a>
                            </div>
                            <div class="panel-body">

                                <table class="table table-striped table-bordered table-hover table-full-width"
                                       id="package_tbl">
                                    <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th class="center">{{trans('site_lang.packae_name')}}</th>
                                        <th class="center">{{trans('site_lang.package_cost')}}</th>
                                        <th class="center">{{trans('site_lang.package_duration')}}</th>
                                        <th class="center"></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- end: DYNAMIC TABLE PANEL -->
                    </div>
                </div>

            </div>
        </div>
        <!-- end: PAGE -->
        <div id="add_package_model" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
             class="modal bs-example-modal-basic fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title"></h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="packages" enctype="multipart/form-data">
                            <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="id" id="id">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group{{$errors->has('name')?' has-error':''}}">
                                        <input type="text" name="name" class="form-control" id="name"
                                               placeholder="{{trans('site_lang.packae_name')}}"
                                               value="{{ old('name') }}">
                                        <span class="text-danger" id="package_Name_error"></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group{{$errors->has('cost')?' has-error':''}}">

                                        <input name="cost" id="cost"
                                               placeholder="{{trans('site_lang.package_cost')}}"
                                               class="form-control"
                                               value="{{ old('cost') }}"/>
                                        <span class="text-danger" id="package_cost_error"></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group{{$errors->has('duration')?' has-error':''}}">

                                        <input type="text" name="duration" id="duration"
                                               class="form-control"
                                               placeholder="{{trans('site_lang.package_duration')}}"
                                               value="{{ old('duration') }}">
                                        <span class="text-danger" id="package_duration_error"></span>
                                    </div>
                                </div>



                            </div>
                            <div class="form-group right">
                                <button data-dismiss="modal" class="btn btn-default" type="button">
                                    {{trans('site_lang.public_close_btn_text')}}
                                </button>
                                <input type="hidden" name="hidden_id" id="hidden_id"/>
                                <input type="submit" class="btn btn-primary" id="add_client" name="add_client"
                                       value="{{trans('site_lang.public_add_btn_text')}}"/>
                            </div>
                        </form>

                    </div>

                </div>
                <!-- /.modal-content -->
            </div>


            <!-- /.modal-dialog -->
        </div>
        {{--confirm modal--}}
        <div id="confirmModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        <h4 align="center" style="margin:0;">{{trans('site_lang.public_delete_modal_text')}}</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" name="ok_button" id="ok_button"
                                class="btn btn-danger">{{trans('site_lang.public_accept_btn_text')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('site_lang.public_close_btn_text')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{url('/plugins/toastr/toastr.js') }}"></script>
    <script>
        var client_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {
            $('#package_tbl').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('packages.index') }}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        className: 'center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'center'
                    }, {
                        data: 'cost',
                        name: 'cost',
                        className: 'center'
                    }, {
                        data: 'duration',
                        name: 'duration',
                        className: 'center'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        className: 'center'
                    }
                ]
            });

            $('#addClientModal').click(function () {
                $('#modal_title').text("{{trans('site_lang.Add_new_package')}}");
                $('#add_client').val("{{trans('site_lang.public_add_btn_text')}}");
                $('#add_package_model').modal('show');
            });
            $('#packages').on('submit', function (event) {
                event.preventDefault();
                if ($('#add_client').val() == '{{trans('site_lang.public_add_btn_text')}}') {
                    $.ajax({
                        url: "{{route('packages.store')}}",
                        method: 'post',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        beforeSend: function () {
                            $('#package_Name_error').empty();
                            $('#packae_cost_error').empty();
                            $('#package_duration_error').empty();

                        },
                        success: function (data) {
                            $('#add_package_model').modal('hide');
                            toastr.success(data.success);
                            $("#packages").trigger('reset');
                            $('#package_tbl').DataTable().ajax.reload();
                        }, error: function (data_error, exception) {
                            if (exception == 'error') {
                                $('#package_Name_error').html(data_error.responseJSON.errors.name);
                                $('#packae_cost_error').html(data_error.responseJSON.errors.cost);
                                $('#package_duration_error').html(data_error.responseJSON.errors.duration);

                            }
                        }
                    });
                } else {
                    $.ajax({
                        url: "{{ route('packages.update') }}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        beforeSend: function () {
                            $('#package_Name_error').empty();
                            $('#packae_cost_error').empty();
                            $('#package_duration_error').empty();
                        }, success: function (data) {
                            $('#add_package_model').modal('hide');
                            toastr.success(data.success);
                            $("#packages").trigger('reset');
                            $('#package_tbl').DataTable().ajax.reload();
                        }, error: function (data_error, exception) {
                            if (exception == 'error') {
                                $('#package_Name_error').html(data_error.responseJSON.errors.name);
                                $('#packae_cost_error').html(data_error.responseJSON.errors.cost);
                                $('#package_duration_error').html(data_error.responseJSON.errors.duration);
                            }
                        }
                    });
                }
            });

            $(document).on('click', '#editPackage', function () {
                var id = $(this).data('package-id');

                $.ajax({
                    url: "/packages/" + id + "/edit",
                    dataType: "json",
                    success: function (html) {
                        $('#add_package_model').modal('show');
                        $('#name').val(html.data.name);
                        $('#cost').val(html.data.cost);
                        $('#duration').val(html.data.duration);
                        $('#id').val(html.data.id);
                        $('#modal_title').text("{{trans('site_lang.package_edit_client_text')}}");
                        $('#add_client').val("{{trans('site_lang.public_edit_btn_text')}}");


                    }
                })
            });


            var client_id;

            $(document).on('click', '.btn-lg', function () {
                var id = $(this).data('moh-Id');
                $.ajax({
                    url: "mohdareen/updateStatus/" + id,
                    dataType: "json",
                    success: function (html) {
                        $("#status" + html.result.moh_Id).html(html.result.status);
                        // var status = html.status;
                        if (html.status) {
                            $("#status" + html.result.moh_Id).removeClass("label label-danger");
                            $("#status" + html.result.moh_Id).addClass("label label-success");
                            toastr.success(html.msg);
                        } else {
                            $("#status" + html.result.moh_Id).removeClass("label label-success");
                            $("#status" + html.result.moh_Id).addClass("label label-danger");
                            toastr.error(html.msg);
                        }
                    }
                })
            });


            $(document).on('click', '#deletePackage', function () {
                Package_id = $(this).data('package-id');
                $('#confirmModal').modal('show');
            });
            $('#ok_button').click(function () {
                $.ajax({
                    url: "packages/destroy/" + Package_id,
                    beforeSend: function () {
                        $('#ok_button').text('{{trans('site_lang.public_continue_delete_modal_text')}}');
                    },
                    success: function (data) {
                        setTimeout(function () {
                            $('#confirmModal').modal('hide');
                            $('#package_tbl').DataTable().ajax.reload();
                        }, 100);
                    }
                })
            });
            $(document).ready(function () {
                $(".modal").on("hidden.bs.modal", function () {
                    $("#packages").trigger('reset');
                });
            });
        });

    </script>
    <script src="{{url('/plugins/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript"></script>
    <script src="{{url('/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}" type="text/javascript"></script>
    <script src="{{url('/js/ui-modals.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{url('/plugins/select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{url('/js/table-data.js') }}"></script>
    <script src="{{url('/plugins/DataTables/media/js/DT_bootstrap.js') }}"></script>
    <script src="{{url('/plugins/DataTables/media/js/jquery.dataTables.min.js') }}"></script>

@endsection
@section('scriptDocument')
    UIModals.init();
    TableData.init();

@endsection

