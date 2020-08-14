<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <p>Hello {{ $to }},</p>
                    {!! $content !!}
                    <p>Kind Regards,</p>
                    <p>{{ $fromName }}</p>
                </div>
            </div>
        </div>
    </body>
</html>
