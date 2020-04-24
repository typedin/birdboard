@csrf
<div class="field">
    <label class="label" for="title">Title</label>
    <div class="control">
        <input
            class="input bg-transparent border border-gray-400 rounded p-2 text-xs w-full"
            type="text"
            name="title"
            placeholder="title"
            required
            value="{{ $project->title }}"
        >
    </div>
</div>
<div class="field mt-6">
    <label class="label" for="description">Description</label>
    <div class="control">
        <textarea
            name="description"
            rows="10"
            class="input bg-transparent border border-gray-400 rounded p-2 text-xs w-full"
            required
            placeholder="I should start learning the piano"
            >{{ $project->description}}</textarea>
    </div>
</div>
<div class="control mt-6">
    <button type="submit" class="button">
        {{ $buttonText }}
    </button>
    <a href="{{ $project->path() }}">Cancel</a>
</div>

@if ($errors->any())
    <div class="mt-6">
        <ul>
        @foreach($errors->all() as $error)
            <li class="text-sm text-red-600">{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
