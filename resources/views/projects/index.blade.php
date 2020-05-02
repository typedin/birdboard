@extends("layouts.app")
@section("content")
    <header class="flex items-center py-4">
        <div class="flex justify-between items-end w-full">
            <h2 class="text-gray-600">My projects</h2>
            {{--<a class="button" href="/projects/create">New Project</a>--}}
            <button class="button" @click.prevent="$modal.show('new-project')">New Project</button>
        </div>
    </header>
    <main class="lg:flex lg:flex-wrap mt-3 -mx-3">
        @forelse($projects as $project)
            <div class="w-1/3 px-3 pb-6">
                @include("projects.card")
            </div>
        @empty
            <div>No projects yet</div>
        @endforelse
    </main>
    <new-project-modal></new-project-model>
@endsection
