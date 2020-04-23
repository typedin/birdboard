@extends("layouts.app")
@section("content")
<form method="POST" action="/projects">
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
        <a href="/projects">Cancel</a>
    </div>
</form>
@endsection
