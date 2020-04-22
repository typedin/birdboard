<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width" />
        <title></title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.2/css/bulma.min.css">
    </head>
    <body>
        <form method="POST" action="/projects" class="container" style="margin-top: 40px;">
            @csrf
        <h1 class="heading is-1">Create A Project</h1>
            <div class="field">
                <label class="label" for="title">Title</label>
                <div class="control">
                    <input class="input" type="text" name="title" placeholder="title">
                </div>
            </div>
            <div class="field">
                <label class="label" for="description">Description</label>
                <div class="control">
                    <textarea class="input" name="description"></textarea>
                </div>
            </div>
            <div class="control">
                <button type="submit" class="button">Create Project</button>
            </div>
        </form>
    </body>
</html>
