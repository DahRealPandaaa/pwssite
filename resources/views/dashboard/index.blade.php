<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-xl">Dashboard</h1>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex px-4 pb-8 items-start">
                        <div class="p-2 bg-white border-gray-200 flex-no-shrink  w-1/3">
                            <div class=" rounded bg-green-700 bg-opacity-50 p-2">
                                <div class="flex py-1">
                                    <h3 class="text-xl text-center w-full">Items to do</h3>
                                </div>
                                @foreach($todo as $item)
                                <div class="test bg-white p-2 rounded mt-1 border-b border-grey cursor-pointer hover:bg-grey-lighter" name="{{$item->id}}">
                                    <div class="flex justify-between py-1">
                                        <h4 class="font-black text-lg">{{$item->name}}</h4>
                                        @foreach($teammembers as $user)
                                        @if($user->id == $item->assigneduserid)
                                        <p>{{$user->name}}</p>
                                        @endif
                                        @endforeach
                                    </div>
                                    <p class="truncate ">{{ $item->content }}</p>
                                    <div class="h-3 relative max-w-xl rounded-full overflow-hidden mt-2">
                                        <div class="w-full h-full bg-gray-200 absolute"></div>
                                        <div class="h-full bg-green-500 absolute" style="width:{{$item->progres}}%"></div>
                                    </div>
                                </div>

                                <div class="modal{{$item->id}} opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
                                    <div class="modal-overlay{{$item->id}} absolute w-full h-full bg-gray-900 opacity-50"></div>
                                    <div class="modal-container bg-white w-9/12 rounded shadow-lg z-50 overflow-y-auto">

                                        <div class="modal-close{{$item->id}} absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                                            <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                                            </svg>
                                        </div>
                                        <div class="modal-content py-4 text-left px-6">
                                            <div class="flex justify-between items-center pb-3">
                                                <p class="text-3xl font-bold">{{$item->name}}</p>
                                                <div class="modal-close{{$item->id}} cursor-pointer z-50">
                                                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <form action="{{ route('todo.edit', [$item->id]) }}" method="POST" class="w-full">
                                                @csrf
                                                <div class="flex justify-between gap-2.5 py-1 w-full">
                                                    <div class="flex-no-shrink w-1/2">
                                                        <label class="text-xl ml-1" for="name">Name:</label><br>
                                                        <input type="text" class="w-full mt-2 mb-4 py-2 px-4 rounded-full" id="name" name="name" value="{{$item->name}}" disabled>
                                                    </div>
                                                    <div class="flex-no-shrink w-1/2">
                                                        <div class="flex justify-between items-center pb-3">
                                                            <label class="text-xl ml-1" for="progress">Progress:</label>
                                                            <div class="modal-close cursor-pointer z-50">
                                                                <output class="px-4 bg-green-500 p-3 rounded-lg text-white hover:bg-green-400 mr-1" for="progress" id="volume{{$item->id}}">{{$item->progres}}%</output>
                                                            </div>
                                                        </div>
                                                        <input type="range" class="w-full mb-4 py-2 rounded-full slider" step="1" oninput="outputUpdate(value, {{$item->id}})" min="0" max="100" value="{{$item->progres}}" id="progress" name="progress" disabled>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between gap-2.5 py-1 w-full">
                                                    <div class="flex-no-shrink w-1/3">
                                                        <label class="text-xl ml-1" for="users">Assigned to:</label><br>
                                                        <select class="w-full mt-2 mb-4 py-2 px-4 rounded-full" name="users" id="users" disabled>
                                                            @foreach($teammembers as $user)
                                                            @if($user->id == $item->assigneduserid)
                                                            <option selected value="{{$user->id}}">{{$user->name}}</option>
                                                            @else
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="flex-no-shrink w-1/3">
                                                        <label class="text-xl ml-1" for="deadline">Deadline:</label><br>
                                                        <input type="date" class="w-full mt-2 mb-4 py-2 px-4 rounded-full" id="deadline" name="deadline" value="{{date('Y-m-d', strtotime($item->deadline))}}" disabled>
                                                    </div>
                                                    <div class="flex-no-shrink w-1/3">
                                                        <label class="text-xl ml-1" for="status">Status:</label><br>
                                                        <select class="w-full mt-2 mb-4 py-2 px-4 rounded-full" name="status" id="status" disabled>
                                                            <option value="0" @if($item->status == 0) selected @endif>To do</option>
                                                            <option value="1" @if($item->status == 1) selected @endif>Working on it</option>
                                                            <option value="2" @if($item->status == 2) selected @endif>Complete</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between gap-2.5 py-1 w-full">
                                                    <div class="flex-no-shrink w-full">
                                                        <label class="text-xl" for="work">Content:</label>
                                                        <textarea rows="5" class="w-full mt-2 py-2 px-4" id="work" name="work" disabled>{{ $item->content }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end pt-2">
                                                    <a class="modal-close{{$item->id}} px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Close</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="p-2 bg-white border-gray-200 flex-no-shrink  w-2/3">
                            <div class=" ounded bg-purple-700 bg-opacity-50 p-2">
                                <div class="flex py-1">
                                    <h3 class="text-xl text-center w-full">Team information</h3>
                                </div>
                                <div class="bg-white p-2 rounded mt-1 border-b border-grey cursor-pointer hover:bg-grey-lighter">
                                    <div class="flex justify-between py-1">
                                        <h4 class="font-black text-lg">{{$teamdata->first()->name}}</h4>
                                        <p onclick="copyToClipboard('{{$teamdata->first()->externalid}}', '{{$teamdata->first()->externalid}}')" class="font-semibold	text-base">{{$teamdata->first()->externalid}}</p>
                                    </div>
                                </div>
                                @foreach($teammembers as $member)
                                <div class="bg-white p-2 rounded mt-1 border-b border-grey cursor-pointer hover:bg-grey-lighter">
                                    <div class="flex justify-between py-1">
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
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    Total worktime
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <?php
                                                    $total = 0;
                                                    ?>
                                                    @foreach($timelist as $time)
                                                    @if($time->userid == $member->id)
                                                    <?php
                                                    $date1 = new DateTime(date('Y-m-d H:i:s', strtotime($time->start)));
                                                    $date2 = new DateTime(date('Y-m-d H:i:s', strtotime($time->stop)));
                                                    $total = $total + ($date2->getTimestamp() - $date1->getTimestamp());
                                                    ?>
                                                    @endif
                                                    @endforeach
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        {{ format_time($total) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>
    function outputUpdate(vol, id) {
        document.querySelector(`#volume${id}`).value = `${vol}%`;
    }
    $(document).ready(function() {
        $('.test').click(function() {
            if ($(this).attr('name')) {
                var name = $(this).attr('name');

                toggleModal()

                // When the user clicks anywhere outside of the modal, close it
                var overlay = document.querySelector(`.modal-overlay${name}`)
                overlay.onclick = function(event) {
                    toggleModal()
                }

                var closemodal = document.querySelectorAll(`.modal-close${name}`)
                for (var i = 0; i < closemodal.length; i++) {
                    closemodal[i].onclick = function(event) {
                        toggleModal()
                    }
                }

                function toggleModal() {
                    var body = document.querySelector('body')
                    var modal = document.querySelector(`.modal${name}`)
                    modal.classList.toggle('opacity-0')
                    modal.classList.toggle('pointer-events-none')

                }
            }
        })
    })

    function copyToClipboard(text, type) {
        var dummy = document.createElement("textarea");
        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);
        swal({
            icon: 'success',
            showConfirmButton: false,
            title: 'Gekopieerd!',
            timer: 2500,
            timerProgressBar: true,
        })
    }
</script>

<?php
function format_time($t, $f = ':') // t = seconds, f = separator 
{
    return sprintf("%01d%s%01d%s", floor($t / 3600), " hours, ", ($t / 60) % 60, " minutes");
}

?>