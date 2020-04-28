<div class="card" style="height: 200px">
    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-teal-400 pl-4">
        <a href="{{ $project->path() }}" class="transition ease-in-out duration-100 text-gray-900 hover:text-gray-500">
            {{ $project->title }}
        </a>
    </h3>
    <div class="text-gray-600 mt-4">
        {{ \Illuminate\Support\Str::limit( $project->description, 100) }}
    </div>
    <footer class="mt-4 flex justify-end">
        <form action="{{ $project->path() }}" method="POST">
            @method("DELETE")
            @csrf
            <button type="submit">Delete</button>
        </form>
    </footer>
</div>
