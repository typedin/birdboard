<div class="card mt-4">
    <ul class="text-xs space-y-1">
        @foreach($project->activity as $activity)
            <li>
                @include("projects.activity.$activity->description")
                <span class="text-gray-600">
                    {{ $activity->created_at->diffForHumans(null, true) }}
                </span>
            </li>
        @endforeach
    </ul>
</div>
