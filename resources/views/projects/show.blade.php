<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width" />
        <title>Show.blade</title>
    </head>
    <body>
        <h1>{{ $project->title }}</h1>
        <div>
            {{ $project->description }}
        </div>
    </body>
</html>
