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
                    <h1 class="text-xl">Time edit</h1>
                    <p>Below you can edit the selected data entery.</p>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col mt-2">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <form action="{{ route('time.editupdate', [$data->first()->id]) }}" method="POST" class="w-full">
                                    @csrf
                                    <label class="text-xl" for="work">Worked on:</label>
                                    <textarea rows="10" class="w-full mt-2 py-2 px-4" id="work" name="work" required>{{ $data->first()->work }}</textarea>
                                    <div class="w-full mt-4 flex">
                                        <div class="w-1/2">
                                            <label class="text-xl" for="start">Start time:</label>
                                            <input required type="datetime-local" id="start" name="start" value="{{date('Y-m-d\TH:i:s',strtotime($data->first()->start))}}">
                                        </div>
                                        <div class="w-1/2">
                                        <label class="text-xl" for="stop">Stop time:</label>
                                            <input required type="datetime-local" id="stop" name="stop" value="{{date('Y-m-d\TH:i:s',strtotime($data->first()->stop))}}">
                                        </div>
                                    </div>
                                    <div class="flex justify-center">
                                    <input class="bg-blue-500 hover:bg-blue-700 text-xl text-white font-bold py-2 px-4 rounded-full mt-4 w-4/12" type="submit" value="Edit">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>

<?php
function secondsToTime($seconds)
{
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%h hours, %i minutes and %s seconds');
}
?>