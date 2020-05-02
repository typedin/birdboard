@extends("layouts.app")
@section("content")
    <header class="flex items-center py-4">
        <div class="flex justify-between items-end w-full">
            <h2 class="text-gray-600">My projects</h2>
            <a class="button" href="/projects/create">New Project</a>
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
    <modal name="hello-world"
           classes="card p-10"
           height="auto"
    >
        <h1 class="text-center text-2xl">Let's Start Something New!</h1>
        <div class="mt-16 flex justify-between space-x-4">
            <div class="flex-1">
                <div>
                   <label class="block text-sm" for="title">Title</label>
                   <input class="form-input" type="text" name="title" placeholder="title"/>
                </div>
                <div class="mt-4">
                   <label class="block text-sm" for="description">Description</label>
                   <textarea class="form-input" name="description" placeholder="title" rows="7"></textarea>
                </div>
            </div>
            <div class="flex-1">
                <div>
                   <label class="block text-sm">Need Some Tasks?</label>
                   <input class="form-input" type="text" placeholder="task 1"/>
                </div>
                <button class="mt-4 inline-flex items-center text-xs">
                    <svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 9V12M12 12V15M12 12H15M12 12H9M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="ml-2">Add New Task Field</span>
                </button>
            </div>
        </div>
        <footer class="mt-4 flex justify-end space-x-4">
            <button class="button is-outline">Cancel</button>
            <button class="button">Create Project</button>
        </footer>
    </modal>
    <button @click.prevent="$modal.show('hello-world')">Modal</button>
@endsection
