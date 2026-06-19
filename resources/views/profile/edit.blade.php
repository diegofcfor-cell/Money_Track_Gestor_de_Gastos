<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <div class="card">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="card">
            @include('profile.partials.update-password-form')
        </div>
        <div class="card">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
