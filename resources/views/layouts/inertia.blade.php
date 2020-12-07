<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>{{ $page['props']['appName'] }}</title>
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
        <script src="{{ mix('/js/inertia-app.js') }}" defer></script>
        @routes
    </head>
    <body class="bg-light">
        @inertia
    </body>
</html>
