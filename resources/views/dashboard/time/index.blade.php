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
                    <h1 class="text-xl">Time log</h1>
                    <p>Below you can see your data log with entered data</p>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col mt-2">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Start time
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Total time
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Description
                                                </th>
                                                <th><a href="{{route('time.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full w-full text-center mb-1 " type="submit" value="Create team">Create</a></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ( $data as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ date('d/m/Y',strtotime($item->start)) }}</div>
                                                    <div class="text-sm text-gray-500">{{ date('h:i A',strtotime($item->start)) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        <?php
                                                        $date1 = new DateTime(date('Y-m-d H:i:s', strtotime($item->start)));
                                                        $date2 = new DateTime(date('Y-m-d H:i:s', strtotime($item->stop)));
                                                        echo secondsToTime($date1->getTimestamp() - $date2->getTimestamp());
                                                        ?>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-7/12 max-w-lg	">
                                                    <p class="truncate ">{{ $item->work }}</p>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-1/12">
                                                    <a href="/dashboard/time/{{$item->id}}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z" />
                                                        </svg></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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