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
<<<<<<< HEAD
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
=======

    <link rel="stylesheet" href="<?php echo e(url('/plugins/bootstrap/css/bootstrap.min.css')); ?>"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo e(url('/css/fontcairo2.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('/css/styles.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('/css/styles-responsive.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('/css/plugins.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('/css/themes/theme-default.css')); ?>" type="text/css" id="skin_color">
    <link rel="stylesheet" href="<?php echo e(url('/plugins/nvd3/nv.d3.min.css')); ?>">

>>>>>>> d97956581783ff05e196c461f012ba29e1659cfa

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
<<<<<<< HEAD
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
=======

<!--    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>-->
    <!--    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <![endif]-->
</head>
<body style="background: whitesmoke">
>>>>>>> d97956581783ff05e196c461f012ba29e1659cfa
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div style="text-align:center;font-size: 30px;background-color: #8E9AA2;color: white;">
                <hl class="center"><?php echo e($search_date); ?>&nbsp; <?php echo e(trans('site_lang.reports_print_daily_1')); ?></hl>
            </div>
            <br>
<<<<<<< HEAD
            <table class="table table-striped table-bordered table-hover table-full-width"
                   style="font-family: 'Cairo';font-size: 10px;text-align: center;" id="PrintdailyTable">
                <thead>
                <tr>
                    <th style="text-align: center;"><?php echo e(trans('site_lang.mohdar_notes')); ?></th>
                    <th style="text-align: center;"><?php echo e(trans('site_lang.home_session_date')); ?></th>
                    <th style="text-align: center;"><?php echo e(trans('site_lang.add_case_court')); ?></th>
                    <th style="text-align: center;"><?php echo e(trans('site_lang.add_case_inventation_type')); ?></th>
                    <th style="text-align: center;"><?php echo e(trans('site_lang.add_case_circle_num')); ?></th>
                    <th style="text-align: center;"><?php echo e(trans('site_lang.home_session_case_number')); ?></th>
                    <th style="text-align: center;"><?php echo e(trans('site_lang.clients_client_type_khesm')); ?></th>
                    <th style="text-align: center;"><?php echo e(trans('site_lang.clients_client_type_client')); ?></th>
                    <th style="text-align: center;">#</th>
                </tr>
                </thead>

                <tbody>
                <?php
                    $i=1;
                ?>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php if($row->Printnotes ==null): ?>
                            <td style="text-align: center;">----</td>
                        <?php else: ?>
                            <td style="text-align: center;"><?php echo e($row->Printnotes->note); ?></td>
                        <?php endif; ?>
                        <td style="text-align: center;"><?php echo e($row->session_date); ?></td>
                        <td style="text-align: center;"><?php echo e($row->cases->court); ?></td>
                        <td style="text-align: center;"><?php echo e($row->cases->inventation_type); ?></td>
                        <td style="text-align: center;"><?php echo e($row->cases->circle_num); ?></td>
                        <td style="text-align: center;"><?php echo e($row->cases->invetation_num); ?></td>
                        <td style="text-align: center;"><?php echo e($khesm->client_Name); ?></td>
                        <td style="text-align: center;"><?php echo e($clients->client_Name); ?></td>
                        <td style="text-align: center;">
                            <?php echo e($i); ?>

                        </td>
                    </tr>
                    <?php
                        $i=$i+1;
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                </tbody>
            </table>
=======
            <div class="panel panel-white">


                <div class="panel-body" >
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered   table-full-width"
                               id="PrintdailyTable">
                            <thead >
                            <tr>
                                <th class="center"><?php echo e(trans('site_lang.mohdar_notes')); ?></th>
                                <th class="center"><?php echo e(trans('site_lang.home_session_date')); ?></th>
                                <th class="center"><?php echo e(trans('site_lang.add_case_court')); ?></th>
                                <th class="center"><?php echo e(trans('site_lang.add_case_inventation_type')); ?></th>
                                <th class="center"><?php echo e(trans('site_lang.add_case_circle_num')); ?></th>
                                <th class="center"><?php echo e(trans('site_lang.home_session_case_number')); ?></th>
                                <th class="center"><?php echo e(trans('site_lang.clients_client_type_khesm')); ?></th>
                                <th class="center"><?php echo e(trans('site_lang.clients_client_type_client')); ?></th>
                                <th class="center">#</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                                $i=1;
                            ?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php if($row->Printnotes ==null): ?>
                                        <td class="center">----</td>
                                    <?php else: ?>
                                        <td class="center"><?php echo e($row->Printnotes->note); ?></td>
                                    <?php endif; ?>
                                    <td class="center"><?php echo e($row->session_date); ?></td>
                                    <td class="center"><?php echo e($row->cases->court); ?></td>
                                    <td class="center"><?php echo e($row->cases->inventation_type); ?></td>
                                    <td class="center"><?php echo e($row->cases->circle_num); ?></td>
                                    <td class="center"><?php echo e($row->cases->invetation_num); ?></td>
                                    <td class="center"><?php echo e($khesm->client_Name); ?></td>
                                    <td class="center"><?php echo e($clients->client_Name); ?></td>
                                    <td class="center">
                                        <?php echo e($i); ?>

                                    </td>
                                </tr>
                                <?php
                                    $i=$i+1;
                                ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
>>>>>>> d97956581783ff05e196c461f012ba29e1659cfa
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<<<<<<< HEAD
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
=======

<!-- Include all compiled plugins (below), or include individual files as needed -->


<script src="<?php echo e(url('/plugins/bootstrap/js/bootstrap.min.js')); ?>"></script>

<script src="<?php echo e(url('/js/index.js')); ?>"></script>

<script src="<?php echo e(url('/js/main.js')); ?>"></script>
<!-- end: CORE JAVASCRIPTS  -->
<script>
    jQuery(document).ready(function () {
        Main.init();
        Index.init();
        <?php echo $__env->yieldContent('scriptDocument'); ?>

    });
</script>
>>>>>>> d97956581783ff05e196c461f012ba29e1659cfa
</body>
</html>
<?php /**PATH C:\xampp\htdocs\temporary-E-solution-Lawyer-App-\resources\views/Reports/DailyPDF.blade.php ENDPATH**/ ?>