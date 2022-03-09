<x-app-layout>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="flex justify-center items-center mt-2">
        <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-red-700 bg-red-100 border border-red-300 w-8/12">
            <div slot="avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon w-5 h-5 mx-2">
                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="text-xl font-normal  max-w-full flex-initial">
                {{ $error }}
            </div>
        </div>
    </div>
    @endforeach
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-xl">Create team</h1>
                    <p>You can create your own team below.</p>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('teams.createteam') }}" method="POST" class="w-full">
                        @csrf
                        <label class="text-2xl w-10/12" for="invitecode">Enter your custom invite code:</label>
                        <input type="text" class="w-full mt-2 mb-4 py-2 px-4 rounded-full" id="invitecode" name="invitecode" required>
                        <label class="text-2xl w-10/12" for="name">Enter your team name:</label>
                        <input type="text" class="w-full mt-2 py-2 px-4 rounded-full" id="name" name="name" required>
                        <p>You can't change this values later. Share the invite code with others to let them join your team.</p>
                        <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mt-4" type="submit" value="Create team">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>