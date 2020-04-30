@extends("layouts.app")
@section("content")
    <header class="flex items-center py-4">
        <div class="flex justify-between items-end w-full">
            <ol itemscope itemtype="https://schema.org/BreadcrumbList" class="flex text-gray-600 space-x-1">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="/projects">
                        <span itemprop="name">
                            My Projects
                        </span>
                    </a>
                    <meta itemprop="position" content="1" />
                </li>
                <span>/</span>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name">
                        {{ $project->title }}
                    </span>
                    <meta itemprop="position" content="2" />
                </li>
            </ol>
            <div class="flex items-center">
                @foreach ($project->members as $member)
                    <img
                        class="rounded-full h-8 mr-2"
                        src="{{ gravatar_url($member->email) }}"
                        alt="{{ $member->name }}'s avatar"
                    >
                @endforeach
                <img
                    class="rounded-full h-8 mr-2"
                    src="{{ gravatar_url($project->owner->email) }}"
                    alt="{{ $project->owner->name }}'s avatar"
                >
                <a class="button ml-4" href="{{ $project->path(). '/edit' }}">Update Project</a>
            </div>
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
                                    <input name="body" value="{{ $task->body }}" class="form-input w-full {{ $task->completed ? 'text-gray-300' : '' }}"/>
                                    <input name="completed" type="checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}/>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div class="card mt-3">
                        <form action="{{ $project->path() . "/tasks" }}" method="POST">
                            @csrf
                            <input class="form-input w-full" placeholder="Adding a new task..." name="body" />
                        </form>
                    </div>
                </div>
                <div class="mt-8">
                    <h2 class="text-lg text-gray-600">General Notes</h2>
                    {{-- general notes --}}
                    <div class="card mt-3">
                        <form method="POST" action="{{ $project->path() }}">
                            @csrf
                            @method("PATCH")
                            <textarea
                                name="notes"
                                class="form-input w-full"
                                style="min-height: 200px;"
                                placeholder="Anything special that you want to make a note of?"
                                >{{ $project->notes }}</textarea>
                            <button class="button mt-4" type="submit">Save</button>
                        </form>
                        @if ($errors->any())
                            <div class="mt-6">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li class="text-sm text-red-600">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-start-11 col-span-12 lg:mt-0 mt-6">
                @include("projects.card")
                @include("projects.activity.card")
            </div>
        </div>
    </main>
@endsection
