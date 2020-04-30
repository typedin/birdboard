<div class="card flex flex-col mt-3">
    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-teal-400 pl-4">
        Invite a User
    </h3>
    <form class="mt-3" method="POST" action="{{ $project->path() . '/invitations'}}">
        @csrf
        <input class="form-input w-full" type="email" name="email" placeholder="Email address"/>
        <button class="button mt-4" type="submit">Invite</button>
    </form>
    @include("errors", ["bag" => "invitations"])
</div>
