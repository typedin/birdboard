@extends("layouts.app")
@section("content")
    <header class="flex items-center py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray-600">
                <a href="/projects">My projects</a> / {{ $project->title }}
            </p>
            <a class="button" href="/project/create">New Project</a>
        </div>
    </header>
    <main>
        <div class="lg:grid grid-cols-12 gap-4">
            <div class="col-start-1 col-span-10">
                <div>
                    <h2 class="text-lg text-gray-600">Tasks</h2>
                    {{-- tasks --}}
                    @foreach($project->tasks as $task)
                    <div class="card mt-3">
                        <form method="POST" action="{{ $task->path() }}">
                            @method("PATCH")
                            @csrf
                            <div class="flex">
                                <input name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-gray-300' : '' }}"/>
                                <input name="completed" type="checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}/>
                            </div>
                        </form>
                    </div>
                    @endforeach
                    <div class="card mt-3">
                        <form action="{{ $project->path() . "/tasks" }}" method="POST">
                            @csrf
                            <input class="w-full" placeholder="Adding a new task..." name="body" />
                        </form>
                    </div>
                </div>
                <div class="mt-8">
                    <h2 class="text-lg text-gray-600">General Notes</h2>
                    {{-- general notes --}}
                    <textarea class="card w-full mt-3" style="min-height: 200px;">
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </textarea>
                </div>

            </div>
            <div class="col-start-11 col-span-12 lg:mt-0 mt-6">
                @include("projects.card")
            </div>
        </div>
    </main>
@endsection
