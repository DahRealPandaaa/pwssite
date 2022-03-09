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
                    <h1 class="text-xl">Teams</h1>
                    <p>You can see your team members below. If you aren't part of a team yet you can join a team or create one.</p>
                </div>
                @if (!$teamid)
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('teams.join') }}" method="POST" class="w-full">
                        @csrf
                        <div class="w-full flex">
                            <label class="text-2xl w-10/12" for="id">Enter team code:</label>

                            <a href="{{route('teams.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full w-2/12 text-center" type="submit" value="Create team">Create team</a>
                        </div>
                        <input type="text" class="w-full mt-2 py-2 px-4 rounded-full" id="id" name="id" required>
                        <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mt-4" type="submit" value="Join team">
                    </form>
                </div>
                @else
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="w-full flex">
                        <h1 class="text-2xl w-10/12 font-black">{{ $teamdata->first()->name }}</h1>
                        <form action="{{ route('teams.leave') }}" method="POST" class="w-2/12">
                            @csrf
                            <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full w-full text-center" type="submit" value="Leave team">
                        </form>
                    </div>
                    <div class="flex flex-col mt-2">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Name
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Description
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Total worktime
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Account created 
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ( $teammembers as $member)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $member->name }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                {{ $member->email }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">Leerling Zandvliet</div>
                                                    <div class="text-sm text-gray-500">mens</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Click here
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ date('d/m/Y',strtotime($member->created_at)) }}
                                                </td>
                                            </tr>
                                            @endforeach
                                            <!-- More people... -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>