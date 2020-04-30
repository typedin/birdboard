@if ($errors->{ $bag ?? "default" }->any())
    <div class="mt-6">
        <ul>
            @foreach($errors->{ $bag ?? "default" }->all() as $error)
                <li class="text-sm text-red-600">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
