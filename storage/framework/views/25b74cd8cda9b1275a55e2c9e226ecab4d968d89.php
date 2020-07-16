<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(url('/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css')); ?>" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo e(url('/plugins/bootstrap-modal/css/bootstrap-modal.css')); ?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('/plugins/select2/select2.css')); ?>"/>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="main-container inner">
        <!-- start: PAGE -->
        <div class="main-content">
            <div class="container">
                <!-- start: PAGE HEADER -->
                <!-- start: TOOLBAR -->
                <div class="toolbar row">
                    <div class="col-sm-12 hidden-xs">
                        <div class="page-header">
                            <h3 class="text-bold"><?php echo e(trans('site_lang.side_clients')); ?> </h3>
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
                                <a href="<?php echo e(route('home')); ?>">
                                    <?php echo e(trans('site_lang.side_home')); ?>

                                </a>
                            </li>
                            <li class="active">
                                <?php echo e(trans('site_lang.side_clients')); ?>

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

                                <a class="btn btn-primary" id="addSubscribersModal"><i

                                        class="fa fa-plus"></i><?php echo e(trans('site_lang.clients_add_new_client_text')); ?> </a>
                            </div>
                            <div class="panel-body">

                                <table class="table table-striped table-bordered table-hover table-full-width"
                                       id="subscribers_tbl">
                                    <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th class="center"><?php echo e(trans('site_lang.subName')); ?></th>
                                        <th class="center"><?php echo e(trans('site_lang.subEmail')); ?></th>
                                        <th class="center"><?php echo e(trans('site_lang.subPhone')); ?></th>
                                        <th class="center"><?php echo e(trans('site_lang.subAddress')); ?></th>
                                        <th class="center"><?php echo e(trans('site_lang.subStatus')); ?></th>
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
        <div id="add_subscriber_model" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
             class="modal bs-example-modal-basic fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title"></h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="subscribers">
                            <input type="hidden" id="token" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <input type="hidden" name="id" id="id">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group<?php echo e($errors->has('name')?' has-error':''); ?>">
                                        <input type="text" name="name" class="form-control" id="name" required
                                               placeholder="<?php echo e(trans('site_lang.users_username')); ?>"
                                        >
                                        <span class="text-danger" id="name_error"></span>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group<?php echo e($errors->has('email')?' has-error':''); ?>">
                                        <input name="email" id="email" placeholder="<?php echo e(trans('site_lang.users_email')); ?>"
                                               required
                                               class="form-control"
                                        />
                                        <span class="text-danger" id="email_error"></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group<?php echo e($errors->has('password')?' has-error':''); ?>">
                                        <input type="password" name="password" id="password" class="form-control"
                                               required
                                               placeholder="<?php echo e(trans('site_lang.auth_password')); ?>"
                                        >
                                        <span class="text-danger" id="password_error"></span>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group<?php echo e($errors->has('phone')?' has-error':''); ?>">

                                        <input type="text" name="phone" id="phone"
                                               class="form-control"
                                               placeholder="<?php echo e(trans('site_lang.subPhone')); ?>"
                                        >
                                        <span class="text-danger" id="phone_error"></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group<?php echo e($errors->has('address')?' has-error':''); ?>">
                                        <input type="text" name="address" id="address" class="form-control"
                                               placeholder="<?php echo e(trans('site_lang.client_Address')); ?>"
                                               rows="10">
                                        <span class="text-danger" id="address_error"></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group<?php echo e($errors->has('cat_id')?' has-error':''); ?>">
                                        <select id="form-field-select-3" class="form-control select2-arrow"
                                                name="package_id">
                                            <option value="">
                                                &nbsp;<?php echo e(trans('site_lang.side_Packages')); ?></option>
                                            <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value='<?php echo e($package->id); ?>'><?php echo e($package->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <span class="text-danger" id="package_id_error"></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group<?php echo e($errors->has('password')?' has-error':''); ?>">
                                        <input type="text" name="cat_name" id="cat_name" class="form-control"
                                               required
                                               placeholder="<?php echo e(trans('site_lang.subCatname')); ?>"
                                        >
                                        <span class="text-danger" id="cat_name_error"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group right">
                                <button data-dismiss="modal" class="btn btn-default" type="button">
                                    <?php echo e(trans('site_lang.public_close_btn_text')); ?>

                                </button>
                                <input type="hidden" name="hidden_id" id="hidden_id"/>
                                <input type="submit" class="btn btn-primary" id="add_client" name="add_client"
                                       value="<?php echo e(trans('site_lang.public_add_btn_text')); ?>"/>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>


            <!-- /.modal-dialog -->
        </div>
        <div id="edit_subscriber_modal" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
             class="modal bs-example-modal-basic fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title"></h4>
                    </div>
                    <div class="modal-body">
                        <form method="put" id="edit_subscribe">
                            <input type="hidden" id="token" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <input type="hidden" name="id" id="edit_id">
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <select id="package_id_dialog" class="form-control select2-arrow"
                                                name="package_id">
                                            <option value="">
                                                &nbsp;<?php echo e(trans('site_lang.side_Packages')); ?></option>
                                            <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value='<?php echo e($package->id); ?>'><?php echo e($package->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <span class="text-danger" id="package_id_error"></span>
                                    </div>
                                </div>


                            </div>
                            <div class="form-group right">
                                <button data-dismiss="modal" class="btn btn-default" type="button">
                                    <?php echo e(trans('site_lang.public_close_btn_text')); ?>

                                </button>
                                <input type="hidden" name="hidden_id" id="hidden_id"/>
                                <input type="submit" class="btn btn-primary" id="edit_client" name="edit_client"
                                       value="<?php echo e(trans('site_lang.public_add_btn_text')); ?>"/>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>


            <!-- /.modal-dialog -->
        </div>
        
        <div id="confirmModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        <h4 align="center" style="margin:0;"><?php echo e(trans('site_lang.public_delete_modal_text')); ?></h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" name="ok_button" id="ok_button"
                                class="btn btn-danger"><?php echo e(trans('site_lang.public_accept_btn_text')); ?></button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo e(trans('site_lang.public_close_btn_text')); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(url('/plugins/toastr/toastr.js')); ?>"></script>
    <script>
        var client_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {
            $('#subscribers_tbl').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?php echo e(url('subscribers')); ?>",
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
                        data: 'email',
                        name: 'email',
                        className: 'center'

                    }, {
                        data: 'phone',
                        name: 'phone',
                        className: 'center'

                    }, {
                        data: 'address',
                        name: 'address',
                        className: 'center'

                    }, {
                        data: 'status',
                        name: 'status',
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

            $('#addSubscribersModal').click(function () {
                $('#modal_title').text("<?php echo e(trans('site_lang.clients_add_new_client_text')); ?>");
                $('#add_client').val("<?php echo e(trans('site_lang.public_add_btn_text')); ?>");
                $('#add_subscriber_model').modal('show');
            });
            $('#subscribers').on('submit', function (event) {
                event.preventDefault();
                if ($('#add_client').val() == '<?php echo e(trans('site_lang.public_add_btn_text')); ?>') {
                    $.ajax({
                        url: "<?php echo e(route('subscribers.store')); ?>",
                        method: 'post',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        beforeSend: function () {
                            $('#cat_name_error').empty();
                            $('#address_error').empty();
                            $('#phone_error').empty();
                            $('#password_error').empty();
                            $('#email_error').empty();
                            $('#name_error').empty();
                            $('#package_id_error').empty();
                        },
                        success: function (data) {
                            $('#add_subscriber_model').modal('hide');
                            toastr.success(data.success);
                            $("#subscribers").trigger('reset');
                            $('#subscribers_tbl').DataTable().ajax.reload();
                        }, error: function (data_error, exception) {
                            if (exception == 'error') {
                                $('#cat_name_error').html(data_error.responseJSON.errors.cat_name);
                                $('#address_error').html(data_error.responseJSON.errors.address);
                                $('#phone_error').html(data_error.responseJSON.errors.phone);
                                $('#password_error').html(data_error.responseJSON.errors.password);
                                $('#email_error').html(data_error.responseJSON.errors.email);
                                $('#name_error').html(data_error.responseJSON.errors.name);
                                $('#package_id_error').html(data_error.responseJSON.errors.package_id);
                            }
                        }
                    });
                }


            }); $('#edit_subscribe').on('submit', function (event) {
                event.preventDefault();

                    $.ajax({
                        url: "<?php echo e(route('subscribers.update')); ?>",
                        method: "post",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            $('#edit_subscriber_model').modal('hide');
                            toastr.success(data.success);
                            $("#edit_subscribe").trigger('reset');

                            $('#subscribers_tbl').DataTable().ajax.reload();
                        }, error: function (data_error, exception) {
                            if (exception == 'error') {
                               $('#package_id_error').html(data_error.responseJSON.errors.package_id);
                            }
                        }
                    });


            });

            $(document).on('click', '#editClient', function () {
                var id = $(this).data('client-id');
                $.ajax({
                    url: "/subscribers/" + id + "/edit",
                    dataType: "json",
                    success: function (html) {
                        console.log(html.data.id);
                        $('#package_id_dialog').val(html.data.package_id);
                        $('#edit_id').val(html.data.id);
                        $('#modal_title').text("<?php echo e(trans('site_lang.clients_edit_client_text')); ?>");
                        $('#edit_client').val("<?php echo e(trans('site_lang.public_edit_btn_text')); ?>");
                        $('#edit_subscriber_modal').modal('show');

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
            $(document).on('click', '#change-user-status', function () {
                var id = $(this).data('user-id');
                $.ajax({
                    url: "subscribers/updateStatus/" + id,
                    dataType: "json",
                    success: function (html) {
                        $('#subscribers_tbl').DataTable().ajax.reload();
                        if (html.status) {
                            toastr.success(html.msg);
                        } else {
                            toastr.error(html.msg);
                        }
                    }
                })
            });

            $(document).on('click', '#deleteClient', function () {
                client_id = $(this).data('client-id');
                $('#confirmModal').modal('show');
            });
            $('#ok_button').click(function () {
                $.ajax({
                    url: "clients/destroy/" + client_id,
                    beforeSend: function () {
                        $('#ok_button').text('<?php echo e(trans('site_lang.public_continue_delete_modal_text')); ?>');
                    },
                    success: function (data) {
                        setTimeout(function () {
                            $('#confirmModal').modal('hide');
                            $('#subscribers_tbl').DataTable().ajax.reload();
                        }, 100);
                    }
                })
            });
            $(document).ready(function () {
                $(".modal").on("hidden.bs.modal", function () {
                    $("#subscribers").trigger('reset');
                });
            });
        });

    </script>
    <script src="<?php echo e(url('/plugins/bootstrap-modal/js/bootstrap-modal.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('/plugins/bootstrap-modal/js/bootstrap-modalmanager.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('/js/ui-modals.js')); ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo e(url('/plugins/select2/select2.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(url('/js/table-data.js')); ?>"></script>
    <script src="<?php echo e(url('/plugins/DataTables/media/js/DT_bootstrap.js')); ?>"></script>
    <script src="<?php echo e(url('/plugins/DataTables/media/js/jquery.dataTables.min.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scriptDocument'); ?>
    UIModals.init();
    TableData.init();

<?php $__env->stopSection(); ?>


<?php echo $__env->make('welcome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\temporary-E-solution-Lawyer-App-\resources\views/Subscribers/subscribers.blade.php ENDPATH**/ ?>