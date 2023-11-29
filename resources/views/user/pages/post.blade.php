@extends('user.layouts.default')

@section('extra-head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.1.1/flowbite.min.css"  rel="stylesheet" />
@stop


@section('extra-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.1.1/flowbite.min.js"></script>
@stop

@section('content')

<main class="container max-w-xl mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen">
      <!-- Single post -->
      <section
        id="newsfeed"
        class="space-y-6">
        <article
          class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
          <!-- Barta Card Top -->
          <header>
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <!-- User Avatar -->
                <div class="flex-shrink-0">
                    <img
                    class="h-10 w-10 rounded-full object-cover"
                    src="{{ $post->firstName == auth()->user()->firstName ? 'https://avatars.githubusercontent.com/u/32349150?v=4':'https://avatars.githubusercontent.com/u/61485238'}}"
                    alt="Al Nahian" />
                </div>
                <!-- /User Avatar -->

                <!-- User Info -->
                <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                  <a
                    href="/user/profile/{{$post->userUuid}}"
                    class="hover:underline font-semibold line-clamp-1">
                    {{$post->firstName . ' ' . $post->lastName}}
                  </a>

                  <a
                    href="/user/profile/{{$post->userUuid}}"
                    class="hover:underline text-sm text-gray-500 line-clamp-1">
                    {{'@'.explode("@", $post->email)[0]}}
                  </a>
                </div>
                <!-- /User Info -->
              </div>

              <!-- Card Action Dropdown -->
              @if(auth()->user()->id == $post->userId)
              <div class="flex flex-shrink-0 self-center" x-data="{ open: false }">
                <div class="relative inline-block text-left">
                  <div>
                    <button
                      @click="open = !open"
                      type="button"
                      class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600"
                      id="menu-0-button">
                      <span class="sr-only">Open options</span>
                      <svg
                        class="h-5 w-5"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        aria-hidden="true">
                        <path
                          d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z"></path>
                      </svg>
                    </button>
                  </div>
                  <!-- Dropdown menu -->
                  <div
                        x-show="open"
                        @click.away="open = false"
                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu"
                        aria-orientation="vertical"
                        aria-labelledby="user-menu-button"
                        tabindex="-1">
                    <a
                        href="/user/post/edit/{{$post->uuid}}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-0"
                    >Edit</a>
                    <a
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-1"
                        data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                    >Delete</a>
                  </div>

                  {{-- Confirmation Modal Start--}}

                  <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <div class="p-4 md:p-5 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this product?</h3>
                                    <form action="/user/post/delete/{{$post->uuid}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button data-modal-hide="popup-modal" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                                            Yes, I'm sure
                                        </button>
                                        <button data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Confirmation Modal End--}}
                </div>

              </div>
              @endif
              <!-- /Card Action Dropdown -->
            </div>
          </header>

          <!-- Content -->
          <div class="py-4 text-gray-700 font-normal">
            <p>
              {{$post->title}}
            </p>
          </div>

          <!-- Date Created & View Stat -->
          <div class="flex items-center gap-2 text-gray-500 text-xs my-2">
            <span class="">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</span>
            <span class="">•</span>
            <span>{{$post->views}} views</span>
          </div>

          <hr class="my-6" />

          <!-- Barta Create Comment Form -->
          <form action="{{route('create-comment', $post->uuid)}}" method="POST">
            @csrf
            <!-- Create Comment Card Top -->
            <div>
              <div class="flex items-start space-x-3">
                <!-- User Avatar -->
                 <div class="flex-shrink-0">
                    <img
                      class="h-10 w-10 rounded-full object-cover"
                      src="https://avatars.githubusercontent.com/u/831997"
                      alt="Ahmed Shamim" />
                  </div>
                <!-- /User Avatar -->

                <!-- Auto Resizing Comment Box -->
                <div class="text-gray-700 font-normal w-full">
                  <textarea
                    x-data="{
                          resize () {
                              $el.style.height = '0px';
                              $el.style.height = $el.scrollHeight + 'px'
                          }
                      }"
                    x-init="resize()"
                    @input="resize()"
                    type="text"
                    name="title"
                    placeholder="Write a comment..."
                    class="flex w-full h-auto min-h-[40px] px-3 py-2 text-sm bg-gray-100 focus:bg-white border border-sm rounded-lg border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-1 focus:ring-offset-0 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900"></textarea>
                </div>
              </div>
            </div>

            <!-- Create Comment Card Bottom -->
            <div>
              <!-- Card Bottom Action Buttons -->
              <div class="flex items-center justify-end">
                <button
                  type="submit"
                  class="mt-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
                  Comment
                </button>
              </div>
              <!-- /Card Bottom Action Buttons -->
            </div>
            <!-- /Create Comment Card Bottom -->
          </form>
          <!-- /Barta Create Comment Form -->

        </article>

        <hr />

        <div class="flex flex-col space-y-6">
          <h1 class="text-lg font-semibold"> {{sizeof($post->comments)!==0 ? 'Comments('. sizeOf($post->comments).')' : ''}}</h1>

          <!-- Barta User Comments Container -->
          <article class=" {{sizeOf($post->comments)>0 ? 'border-2 border-black px-4 py-2 sm:px-6 ' : ''}} bg-white  rounded-lg shadow mx-auto max-w-none  min-w-full divide-y">
            <!-- Comments -->

            @foreach($post->comments as $comment)
            <div class="py-4">
              <!-- Barta User Comments Top -->
              <header>
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    <!-- User Avatar -->
                    <div class="flex-shrink-0">
                      <img
                              class="h-10 w-10 rounded-full object-cover"
                              src="https://avatars.githubusercontent.com/u/61485238"
                              alt="Al Nahian" />
                    </div>
                    <!-- /User Avatar -->
                    <!-- User Info -->
                    <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                      <a
                        href="profile.html"
                        class="hover:underline font-semibold line-clamp-1">
                        {{$comment->firstName . ' ' . $comment->lastName}}
                      </a>

                      <a
                        href="profile.html"
                        class="hover:underline text-sm text-gray-500 line-clamp-1">
                        {{'@'.explode("@", $comment->email)[0]}}
                      </a>
                    </div>
                    <!-- /User Info -->
                  </div>
                </div>
              </header>

              <!-- Content -->
              <div class="py-4 text-gray-700 font-normal">
                <p>{{$comment->title}}</p>
              </div>

              <!-- Date Created -->
              <div class="flex items-center gap-2 text-gray-500 text-xs">
                <span class="">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans(['parts'=>1, 'short'=>true])}}</span>
              </div>
            </div>

            @endforeach

            <!-- /Comments -->
          </article>
          <!-- /Barta User Comments -->
        </div>
      </section>
    </main>
@stop
