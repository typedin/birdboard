@extends("layouts.app")
@section("content")
    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <h1 class="text-2xl font-normal text-center">
            Let's start soemething new
        </h1>
        <form
            method="POST"
            action="/projects"
            class="mt-4"
        >
            @include("projects.form", [
                "project" => new \App\Project(),
                "buttonText" => "Create Project"
            ])
        </form>
    </div>
@endsection
