<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(url('/plugins/jQuery-Tags-Input/jquery.tagsinput.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('/plugins/select2/select2.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('/plugins/bootstrap-select/bootstrap-select.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('/plugins/datepicker/css/datepicker.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('/plugins/DataTables/media/css/DT_bootstrap.css')); ?>">
    <link href="<?php echo e(url('/plugins/bootstrap-modal/css/bootstrap-modal.css')); ?>" rel="stylesheet" type="text/css"/>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="main-container inner">
        <!-- start: PAGE -->
        <div class="main-content">
            <div class="container">
                <!-- start: PAGE HEADER -->
                <!-- start: TOOLBAR -->
                <div class="toolbar row">
                    <div class="toolbar-tools pull-right">
                        <!-- start: TOP NAVIGATION MENU -->
                        <ul class="nav navbar-right">
                            <!-- start: TO-DO DROPDOWN -->
                            <li class="menu-search">
                                <a href="#">
                                    <i class="fa fa-search"></i> <?php echo e(trans('site_lang.search_case_search')); ?>

                                </a>
                                <!-- start: SEARCH POPOVER -->
                                <div class="popover bottom search-box transition-all">
                                    <div class="arrow"></div>
                                    <div class="popover-content">

                                    </div>
                                </div>
                                <!-- end: SEARCH POPOVER -->
                            </li>
                        </ul>
                        <!-- end: TOP NAVIGATION MENU -->
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
                                <?php echo e(trans('site_lang.side_search_case')); ?>

                            </li>
                        </ol>
                    </div>
                </div>

                <div id="panel_sessions" class="tab-pane fade">
                    <div class="panel panel">
                        <div class="panel-heading">

                            <a class="btn btn-primary" id="addSessionModal"><i
                                    class="fa
                                                fa-plus">&nbsp;&nbsp;</i> <?php echo e(trans('site_lang.search_case_case_add_session')); ?>

                            </a>

                        </div>
                        <div class="panel-body" id="session-div-table">
                            <div class="alert alert-warning" style="text-align: right;">
                                <?php echo trans('site_lang.public_warn_text'); ?>

                            </div>
                            <table
                                class="table table-striped table-bordered table-hover table-full-width"
                                id="subscribes_table">
                                <thead>
                                <tr>
                                    <th class="hidden-xs center">#</th>
                                    <th class="hidden-xs center"><?php echo e(trans('site_lang.home_session_date')); ?></th>
                                    <th class="hidden-xs center"><?php echo e(trans('site_lang.home_session_status')); ?></th>
                                    <th class="hidden-xs center"></th>
                                </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                    <div class="panel panel space20">
                        <div class="panel-heading">
                            <h4 class="text-bold"><?php echo e(trans('site_lang.mohdar_notes')); ?></h4>
                            <a class="btn btn-green" id="btnPrintNotes" target="_blank"><i

                                    class="fa
                                                    fa-print"></i>&nbsp;&nbsp;<?php echo e(trans('site_lang.search_case_case_print_notes')); ?>

                            </a>

                            <a class="btn btn-primary" id="addNotesModal"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo e(trans('site_lang.search_case_case_add_note')); ?>

                            </a>
                        </div>

                        <div class="panel-body">
                            <table
                                class="table table-striped table-bordered table-hover table-full-width"
                                id="subscribers-table">
                                <thead>
                                <tr>
                                    <th class="hidden-xs center">#</th>
                                    <th class="hidden-xs center"><?php echo e(trans('site_lang.home_session_status')); ?></th>
                                    <th class="hidden-xs center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                </tr>
                                </thead>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
    
    
    <script src="<?php echo e(url('/plugins/toastr/toastr.js')); ?>"></script>
    <script src="<?php echo e(url('/plugins/select2/select2.min.js')); ?>"></script>
    <script src="<?php echo e(url('/plugins/bootstrap-select/bootstrap-select.min.js')); ?>"></script>
    <script src="<?php echo e(url('/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')); ?>"></script>
    <script src="<?php echo e(url('/plugins/DataTables/media/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(url('/plugins/DataTables/media/js/DT_bootstrap.js')); ?>"></script>
    <script src="<?php echo e(url('/plugins/jQuery-Tags-Input/jquery.tagsinput.js')); ?>"></script>
    <script src="<?php echo e(url('/js/form-elements.js')); ?>"></script>

        // global app configuration object
        <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {

            $('#subscribes_table').DataTable({
                processing: true,
                serverSide: true,

                //

                ajax: {
                    url: "/subscribers" ,
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
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        className: 'center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        className: 'center'
                    }
                ],

            });

        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });






        //



        $('#createnote').click(function () {
            $('#createModal').modal('show');
        });
        $('#client_note').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                url: "/profile/store/" ,
                method: 'post',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",

                success: function (data) {
                    $('#createModal').modal('hide');
                    toastr.success(data.success);
                    $("#client_note").trigger('reset');
                    $('#clientnotes_tbl').DataTable().ajax.reload();
                }
            })
        });



        var note_id ;
        $(document).on('click', '#deletenote', function () {
            note_id = $(this).data('client-id');
            $('#confirmModal').modal('show');
        });
        $('#ok_button').click(function () {
            $.ajax({
                url: "/profile/deletenote/" + note_id,
                success: function (data) {
                    setTimeout(function () {
                        $('#confirmModal').modal('hide');
                        $('#clientnotes_tbl').DataTable().ajax.reload();
                    }, 100);
                }
            })
        });

        $(document).on('click', '#editnote', function () {
            note_id = $(this).data('client-id');
            $.ajax({
                url: "/profile/" + note_id + "/edit_note",
                dataType: "json",
                success: function (html) {
                    $('#note').val(html.data.notes);
                    $('#id').val(html.data.id);
                    $('#edit_note_model').modal('show');

                }
            })
        });
        $('#client_notes').on('submit', function (event) {
            //  note_ids = $(this).data('id');
            console.log(note_id);
            event.preventDefault();
            $.ajax({
                url:  "/profile/" + note_id + "/edit_notes" ,
                method: 'post',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",

                success: function (data) {
                    $('#edit_note_model').modal('hide');
                    toastr.success(data.success);
                    $("#client_notes").trigger('reset');
                    $('#clientnotes_tbl').DataTable().ajax.reload();
                }
            })
        });




    </script>

    
    <script src="<?php echo e(url('/js/ui-modals.js')); ?>" type="text/javascript"></script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scriptDocument'); ?>
    
    FormElements.init();
    UIModals.init();
    PagesUserProfile.init();
<?php $__env->stopSection(); ?>


<?php echo $__env->make('welcome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\temporary-E-solution-Lawyer-App-\resources\views/Subscribers/subscribers.blade.php ENDPATH**/ ?>