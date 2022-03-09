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
                    <h1 class="text-2xl">Todo list</h1>
                    <p>Below you can see your todo list!</p>
                </div>
                <div class="flex px-4 pb-8 items-start">
                    <div class="p-6 bg-white border-b border-gray-200 flex-no-shrink  w-1/3">
                        <div class=" rounded bg-red-700 bg-opacity-50 p-2">
                            <div class="flex justify-between py-1">
                                <h3 class="text-xl text-center w-full">To do list</h3>
                            </div>
                            <div class="text-sm mt-2">
                                @foreach($data as $item)
                                @if($item->status == 0)
                                <div class="test bg-white p-2 rounded mt-1 border-b border-grey cursor-pointer hover:bg-grey-lighter" name="{{$item->id}}">
                                    <div class="flex justify-between py-1">
                                        <h4 class="font-black text-lg">{{$item->name}}</h4>
                                        @foreach($teamusers as $user)
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
                                                        <input type="text" class="w-full mt-2 mb-4 py-2 px-4 rounded-full" id="name" name="name" value="{{$item->name}}" required>
                                                    </div>
                                                    <div class="flex-no-shrink w-1/2">
                                                        <div class="flex justify-between items-center pb-3">
                                                            <label class="text-xl ml-1" for="progress">Progress:</label>
                                                            <div class="modal-close cursor-pointer z-50">
                                                                <output class="px-4 bg-green-500 p-3 rounded-lg text-white hover:bg-green-400 mr-1" for="progress" id="volume{{$item->id}}">{{$item->progres}}%</output>
                                                            </div>
                                                        </div>
                                                        <input type="range" class="w-full mb-4 py-2 rounded-full slider" step="1" oninput="outputUpdate(value, {{$item->id}})" min="0" max="100" value="{{$item->progres}}" id="progress" name="progress" required>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between gap-2.5 py-1 w-full">
                                                    <div class="flex-no-shrink w-1/3">
                                                        <label class="text-xl ml-1" for="users">Assigned to:</label><br>
                                                        <select class="w-full mt-2 mb-4 py-2 px-4 rounded-full" name="users" id="users">
                                                            @foreach($teamusers as $user)
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
                                                        <input type="date" class="w-full mt-2 mb-4 py-2 px-4 rounded-full" id="deadline" name="deadline" value="{{date('Y-m-d', strtotime($item->deadline))}}" required>
                                                    </div>
                                                    <div class="flex-no-shrink w-1/3">
                                                        <label class="text-xl ml-1" for="status">Status:</label><br>
                                                        <select class="w-full mt-2 mb-4 py-2 px-4 rounded-full" name="status" id="status">
                                                            <option value="0" @if($item->status == 0) selected @endif>To do</option>
                                                            <option value="1" @if($item->status == 1) selected @endif> Working on it</option>
                                                            <option value="2" @if($item->status == 2) selected @endif>Complete</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between gap-2.5 py-1 w-full">
                                                    <div class="flex-no-shrink w-full">
                                                        <label class="text-xl" for="work">Content:</label>
                                                        <textarea rows="5" class="w-full mt-2 py-2 px-4" id="work" name="work" required>{{ $item->content }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end pt-2">
                                                    <button class="px-4 bg-green-500 p-3 rounded-lg text-white hover:bg-green-400 mr-1" type="submit" value="Edit">Edit</button>
                                                    <a class="modal-close{{$item->id}} px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Close</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                <p class="test mt-3 text-center w-full px-4 bg-red-700 p-3 rounded-lg text-white hover:bg-red-800 mr-1" name="create"><a>Add a item...</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white border-b border-gray-200 flex-no-shrink  w-1/3">
                        <div class=" rounded bg-yellow-600	 bg-opacity-50 p-2">
                            <div class="flex justify-between py-1">
                                <h3 class="text-xl text-center w-full">Working on</h3>
                            </div>
                            <div class="text-sm mt-2">
                                @foreach($data as $item)
                                @if($item->status == 1)
                                <div class="test bg-white p-2 rounded mt-1 border-b border-grey cursor-pointer hover:bg-grey-lighter" name="{{$item->id}}">
                                    <div class="flex justify-between py-1">
                                        <h4 class="font-black text-lg">{{$item->name}}</h4>
                                        @foreach($teamusers as $user)
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
                                                        <input type="text" class="w-full mt-2 mb-4 py-2 px-4 rounded-full" id="name" name="name" value="{{$item->name}}" required>
                                                    </div>
                                                    <div class="flex-no-shrink w-1/2">
                                                        <div class="flex justify-between items-center pb-3">
                                                            <label class="text-xl ml-1" for="progress">Progress:</label>
                                                            <div class="modal-close cursor-pointer z-50">
                                                                <output class="px-4 bg-green-500 p-3 rounded-lg text-white hover:bg-green-400 mr-1" for="progress" id="volume{{$item->id}}">{{$item->progres}}%</output>
                                                            </div>
                                                        </div>
                                                        <input type="range" class="w-full mb-4 py-2 rounded-full slider" step="1" oninput="outputUpdate(value, {{$item->id}})" min="0" max="100" value="{{$item->progres}}" id="progress" name="progress" required>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between gap-2.5 py-1 w-full">
                                                    <div class="flex-no-shrink w-1/3">
                                                        <label class="text-xl ml-1" for="users">Assigned to:</label><br>
                                                        <select class="w-full mt-2 mb-4 py-2 px-4 rounded-full" name="users" id="users">
                                                            @foreach($teamusers as $user)
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
                                                        <input type="date" class="w-full mt-2 mb-4 py-2 px-4 rounded-full" id="deadline" name="deadline" value="{{date('Y-m-d', strtotime($item->deadline))}}" required>
                                                    </div>
                                                    <div class="flex-no-shrink w-1/3">
                                                        <label class="text-xl ml-1" for="status">Status:</label><br>
                                                        <select class="w-full mt-2 mb-4 py-2 px-4 rounded-full" name="status" id="status">
                                                            <option value="0" @if($item->status == 0) selected @endif>To do</option>
                                                            <option value="1" @if($item->status == 1) selected @endif> Working on it</option>
                                                            <option value="2" @if($item->status == 2) selected @endif>Complete</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between gap-2.5 py-1 w-full">
                                                    <div class="flex-no-shrink w-full">
                                                        <label class="text-xl" for="work">Content:</label>
                                                        <textarea rows="5" class="w-full mt-2 py-2 px-4" id="work" name="work" required>{{ $item->content }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end pt-2">
                                                    <button class="px-4 bg-green-500 p-3 rounded-lg text-white hover:bg-green-400 mr-1" type="submit" value="Edit">Edit</button>
                                                    <a class="modal-close{{$item->id}} px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Close</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                <p class="test mt-3 text-center w-full px-4 bg-yellow-700 p-3 rounded-lg text-white hover:bg-yellow-800 mr-1" name="create"><a>Add a item...</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white border-b border-gray-200 flex-no-shrink  w-1/3">
                        <div class=" rounded bg-green-700 bg-opacity-50 p-2">
                            <div class="flex justify-between py-1">
                                <h3 class="text-xl text-center w-full">Complete</h3>
                            </div>
                            <div class="text-sm mt-2">
                                @foreach($data as $item)
                                @if($item->status == 2)
                                <div class="test bg-white p-2 rounded mt-1 border-b border-grey cursor-pointer hover:bg-grey-lighter" name="{{$item->id}}">
                                    <div class="flex justify-between py-1">
                                        <h4 class="font-black text-lg">{{$item->name}}</h4>
                                        @foreach($teamusers as $user)
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
                                                        <input type="text" class="w-full mt-2 mb-4 py-2 px-4 rounded-full" id="name" name="name" value="{{$item->name}}" required>
                                                    </div>
                                                    <div class="flex-no-shrink w-1/2">
                                                        <div class="flex justify-between items-center pb-3">
                                                            <label class="text-xl ml-1" for="progress">Progress:</label>
                                                            <div class="modal-close cursor-pointer z-50">
                                                                <output class="px-4 bg-green-500 p-3 rounded-lg text-white hover:bg-green-400 mr-1" for="progress" id="volume{{$item->id}}">{{$item->progres}}%</output>
                                                            </div>
                                                        </div>
                                                        <input type="range" class="w-full mb-4 py-2 rounded-full slider" step="1" oninput="outputUpdate(value, {{$item->id}})" min="0" max="100" value="{{$item->progres}}" id="progress" name="progress" required>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between gap-2.5 py-1 w-full">
                                                    <div class="flex-no-shrink w-1/3">
                                                        <label class="text-xl ml-1" for="users">Assigned to:</label><br>
                                                        <select class="w-full mt-2 mb-4 py-2 px-4 rounded-full" name="users" id="users">
                                                            @foreach($teamusers as $user)
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
                                                        <input type="date" class="w-full mt-2 mb-4 py-2 px-4 rounded-full" id="deadline" name="deadline" value="{{date('Y-m-d', strtotime($item->deadline))}}" required>
                                                    </div>
                                                    <div class="flex-no-shrink w-1/3">
                                                        <label class="text-xl ml-1" for="status">Status:</label><br>
                                                        <select class="w-full mt-2 mb-4 py-2 px-4 rounded-full" name="status" id="status">
                                                            <option value="0" @if($item->status == 0) selected @endif>To do</option>
                                                            <option value="1" @if($item->status == 1) selected @endif> Working on it</option>
                                                            <option value="2" @if($item->status == 2) selected @endif>Complete</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between gap-2.5 py-1 w-full">
                                                    <div class="flex-no-shrink w-full">
                                                        <label class="text-xl" for="work">Content:</label>
                                                        <textarea rows="5" class="w-full mt-2 py-2 px-4" id="work" name="work" required>{{ $item->content }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end pt-2">
                                                    <button class="px-4 bg-green-500 p-3 rounded-lg text-white hover:bg-green-400 mr-1" type="submit" value="Edit">Edit</button>
                                                    <a class="modal-close{{$item->id}} px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Close</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                <p class="test mt-3 text-center w-full px-4 bg-green-700 p-3 rounded-lg text-white hover:bg-green-800 mr-1" name="create"><a>Add a item...</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<div class="modalcreate opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlaycreate absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-white w-9/12 rounded shadow-lg z-50 overflow-y-auto">

        <div class="modal-closecreate absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
            <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
            </svg>
        </div>
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-3xl font-bold">Maak nieuw item aan</p>
                <div class="modal-closecreate cursor-pointer z-50">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
            </div>
            <form action="{{ route('todo.create', [Auth::user()->team_id]) }}" method="POST" class="w-full">
                @csrf
                <div class="flex justify-between gap-2.5 py-1 w-full">
                    <div class="flex-no-shrink w-1/2">
                        <label class="text-xl ml-1" for="name">Name:</label><br>
                        <input type="text" class="w-full mt-2 mb-4 py-2 px-4 rounded-full" id="name" name="name" required>
                    </div>
                    <div class="flex-no-shrink w-1/2">
                        <div class="flex justify-between items-center pb-3">
                            <label class="text-xl ml-1" for="progress">Progress:</label>
                            <div class="modal-close cursor-pointer z-50">
                                <output class="px-4 bg-green-500 p-3 rounded-lg text-white hover:bg-green-400 mr-1" for="progress" id="volumecreate">0%</output>
                            </div>
                        </div>
                        <input type="range" class="w-full mb-4 py-2 rounded-full slider" oninput="outputUpdate(value, 'create')" min="0" max="100" value="0" id="progress" name="progress" required>
                    </div>
                </div>
                <div class="flex justify-between gap-2.5 py-1 w-full">
                    <div class="flex-no-shrink w-1/3">
                        <label class="text-xl ml-1" for="users">Assigned to:</label><br>
                        <select class="w-full mt-2 mb-4 py-2 px-4 rounded-full" name="users" id="users">
                            @foreach($teamusers as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-no-shrink w-1/3">
                        <label class="text-xl ml-1" for="deadline">Deadline:</label><br>
                        <input type="date" class="w-full mt-2 mb-4 py-2 px-4 rounded-full" id="deadline" name="deadline" required>
                    </div>
                    <div class="flex-no-shrink w-1/3">
                        <label class="text-xl ml-1" for="status">Status:</label><br>
                        <select class="w-full mt-2 mb-4 py-2 px-4 rounded-full" name="status" id="status">
                            <option value="0">To do</option>
                            <option value="1">Working on it</option>
                            <option value="2">Complete</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-between gap-2.5 py-1 w-full">
                    <div class="flex-no-shrink w-full">
                        <label class="text-xl" for="work">Content:</label>
                        <textarea rows="5" class="w-full mt-2 py-2 px-4" id="work" name="work" required></textarea>
                    </div>
                </div>
                <div class="flex justify-end pt-2">
                    <button class="px-4 bg-green-500 p-3 rounded-lg text-white hover:bg-green-400 mr-1" type="submit" value="Create">Create</button>
                    <a class="modal-closecreate px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Close</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php
function secondsToTime($seconds)
{
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%h hours, %i minutes and %s seconds');
}
?>

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
</script>