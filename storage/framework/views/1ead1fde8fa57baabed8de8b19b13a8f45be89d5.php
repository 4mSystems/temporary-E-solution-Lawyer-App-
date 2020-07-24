<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $__env->yieldContent('title'); ?></title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .code {
                border-right: 2px solid;
                font-size: 26px;
                padding: 0 15px 0 15px;
                text-align: center;
            }

            .message {
                font-size: 18px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="code">
                <?php echo $__env->yieldContent('code'); ?>
            </div>

            <?php if(Session::has('errors')): ?>
                <div class="alert alert-danger">
                    <h1><?php echo e(Session('errors')); ?></h1>
                </div>
            <?php endif; ?>




            <?php if(session('success')): ?>
                <div class="alert alert-success" role='alert'>
                    <h1><?php echo e(session('success')); ?></h1>
                </div>
            <?php endif; ?>

            <div class="message" style="padding: 10px;">
                <?php echo $__env->yieldContent('message'); ?>
            </div>
        </div>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\temporary-E-solution-Lawyer-App-\resources\views/errors/minimal.blade.php ENDPATH**/ ?>