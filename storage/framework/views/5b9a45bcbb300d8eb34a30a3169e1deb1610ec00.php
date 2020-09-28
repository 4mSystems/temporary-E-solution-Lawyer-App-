<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo e(trans('site_lang.side_reports_monthly')); ?></title>

    <style>
        body {
            font-family: 'XBRiyaz', sans-serif;
        }

        @media  print {
            body {
                -webkit-print-color-adjust: exact;
            }
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

        @media  only screen and (max-width: 600px) {
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
        <img src="<?php echo e(url('/images/print_logo.png')); ?>" style="width:100%; max-width:50px;">
    </div>

    <div style="text-align:center;font-size: 30px;background-color: #8E9AA2;color: white; padding-top: 15px; padding-bottom: 15px;">
        <hl class="center"><?php echo e($year); ?>&nbsp; <?php echo e(trans('site_lang.reports_print_month_1')); ?></hl>
        <hl class="center"><?php echo e($month); ?>&nbsp;<?php echo e(trans('site_lang.reports_print_month_2')); ?></hl>
    </div>
    <br>
    <table cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th ><?php echo e(trans('site_lang.mohdar_notes')); ?></th>
            <th ><?php echo e(trans('site_lang.home_session_date')); ?></th>
            <th ><?php echo e(trans('site_lang.add_case_court')); ?></th>
            <th ><?php echo e(trans('site_lang.add_case_inventation_type')); ?></th>
            <th ><?php echo e(trans('site_lang.add_case_circle_num')); ?></th>
            <th ><?php echo e(trans('site_lang.home_session_case_number')); ?></th>
            <th ><?php echo e(trans('site_lang.clients_client_type_khesm')); ?></th>
            <th ><?php echo e(trans('site_lang.clients_client_type_client')); ?></th>
            <th >#</th>
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


</div>>
<script>
    window.print();
</script>

</body>
</html>
<?php /**PATH /home/elnagar/php projects/temporary-E-solution-Lawyer-App-/resources/views/Reports/MonthlyPDF.blade.php ENDPATH**/ ?>