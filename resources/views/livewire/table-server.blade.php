<main class="flex-1 overflow-x-hidden overflow-y-auto bg-indigo-100">
    <div class="container mx-auto w-3/4 px-6 py-8">
        <div class="flex flex-col mt-8 ">
            <div class=" py-2 overflow-x-auto sm:-mx-6 sm:px-2 lg:-mx-20">

                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8" wire:poll.5s>

                    <!-- component -->
                    <div
                        class="container mx-auto mt-20 grid grid-cols-1 gap-8 md:grid-cols-1 xl:grid-cols-3"
                    >
                        @foreach ($servers as $index => $server)

                            <div class="bg-white shadow-xl rounded-lg py-3">
                                <div class="photo-wrapper p-2 ">
{{--                                    <img class="w-32 h-32 rounded-full mx-auto" src="https://www.gravatar.com/avatar/2acfb745ecf9d4dccb3364752d17f65f?s=260&d=mp" alt="John Doe">--}}
                                </div>
                                <div class="p-2">
                                    <h3 class="text-center text-xl text-gray-900 font-bold leading-8">{{$server->server_id}}</h3>


                                    <table class="text-lg my-3">
                                        <tbody>
                                        <tr>
                                            <td class="px-2 py-2 c font-semibold">IP</td>
                                            <td class="px-2 py-2">{{$server->server_ip}}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-2 text-gray-500 font-semibold">Last Call</td>
                                            <td class="px-2 py-2">{{$server->updated_at }}</td>
                                        </tr>
                                        @if(round(now()->floatDiffInSeconds($server->updated_at) ) < 300 && ($tasks->where('id_server',$server->server_id)->count()) > 0)

                                        <tr>
                                            <td class="px-2 py-2 text-gray-800 text-xl font-bold">Status</td>
                                            <td class="text-center px-2 py-2 rounded bg-green-200 rounded-full text-2xl font-bold">Active</td>
                                        </tr>
                                            @elseif(round(now()->floatDiffInSeconds($server->updated_at)) >= 300 && ($tasks->where('id_server',$server->server_id)->count()) == 0)
                                        <tr>
                                            <td class="px-2 py-2 text-gray-800 text-xl font-bold">Status</td>
                                            <td class="text-center px-2 py-2 rounded bg-gray-600 rounded-full text-2xl font-bold">Idle</td>
                                        </tr>
                                        @elseif(round(now()->floatDiffInSeconds($server->updated_at)) >= 300 && ($tasks->where('id_server',$server->server_id)->count()) > 0)
                                            <tr>
                                                <td class="px-2 py-2 text-gray-800 text-xl font-bold">Status</td>
                                                <td class="text-center px-2 py-2 rounded bg-red-600 rounded-full text-2xl font-bold">Warning</td>
                                            </tr>
                                        @endif

                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        @endforeach
{{--                        <div>--}}
{{--                            <div class="rounded-lg overflow-hidden">--}}
{{--                                <div class="relative overflow-hidden pb-60">--}}
{{--                                    <img--}}
{{--                                        class="absolute h-full w-full object-cover object-center"--}}
{{--                                        src="https://collect.criggzdesign.com/wp-content/uploads/2020/07/5c77d8a62417e4405611bb42_3k-color-1-scaled.jpg"--}}
{{--                                        alt=""--}}
{{--                                    />--}}
{{--                                </div>--}}
{{--                                <div class="relative bg-blue-200">--}}
{{--                                    <div class="py-10 px-8">--}}
{{--                                        <h3 class="text-2xl font-bold">Notepad</h3>--}}
{{--                                        <div class="text-gray-600 text-sm font-medium flex mb-4 mt-2">--}}
{{--                                            <p>Provided by&nbsp;</p>--}}
{{--                                            <a--}}
{{--                                                href="https://www.ls.graphics/"--}}
{{--                                                class="hover:text-black transition duration-300 ease-in-out"--}}
{{--                                            >LS Graphics</a--}}
{{--                                            >--}}
{{--                                        </div>--}}
{{--                                        <p class="leading-7">--}}
{{--                                            High quality notepad mockup in a huge resolution and with--}}
{{--                                            changeable everything.--}}
{{--                                        </p>--}}
{{--                                        <div class="mt-10 flex justify-between items-center">--}}
{{--                                            <div>--}}
{{--                                                <img--}}
{{--                                                    src="https://collect.criggzdesign.com/wp-content/uploads/2020/07/Ps.svg"--}}
{{--                                                    alt=""--}}
{{--                                                    class="w-6"--}}
{{--                                                />--}}
{{--                                            </div>--}}
{{--                                            <a--}}
{{--                                                href="https://collect.criggzdesign.com/index.php/resources/mockups/notepad/"--}}
{{--                                                class="flex items-center"--}}
{{--                                            >--}}
{{--                                                <p class="mr-4">Read more</p>--}}
{{--                                                <svg--}}
{{--                                                    xmlns="http://www.w3.org/2000/svg"--}}
{{--                                                    width="14.125"--}}
{{--                                                    height="13.358"--}}
{{--                                                    viewBox="0 0 14.125 13.358"--}}
{{--                                                >--}}
{{--                                                    <g transform="translate(-3 -3.293)">--}}
{{--                                                        <path--}}
{{--                                                            id="Path_7"--}}
{{--                                                            data-name="Path 7"--}}
{{--                                                            d="M14.189,10.739H3V9.2H14.189L9.361,4.378l1.085-1.085,6.679,6.679-6.679,6.679L9.361,15.566Z"--}}
{{--                                                            fill="#1d1d1d"--}}
{{--                                                            fill-rule="evenodd"--}}
{{--                                                        ></path>--}}
{{--                                                    </g>--}}
{{--                                                </svg>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    </div>






                </div>
            </div>
        </div>
    </div>
</main>
