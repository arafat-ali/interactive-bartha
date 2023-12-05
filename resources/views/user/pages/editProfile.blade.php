@extends('user.layouts.default')
@section('content')

@if($errors->any())
    <ul>
    @forEach($errors->all() as $error)
        <li>{{$error}}</li>
    @endforEach
    </ul>
@endif

<main
      class="container max-w-xl mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen">
      <!-- Profile Edit Form -->

      <form action="/user/profile/edit" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="space-y-12">
          <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-xl font-semibold leading-7 text-gray-900">
              Edit Profile
            </h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">
              This information will be displayed publicly so be careful what you
              share.
            </p>

            <div class="mt-10 border-b border-gray-900/10 pb-12">

              <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="col-span-full mt-10 pb-10">
                    <label
                      for="photo"
                      class="block text-sm font-medium leading-6 text-gray-900"
                      >Photo</label
                    >
                    <div class="mt-2 flex items-center gap-x-3">
                      <input
                        class="hidden"
                        type="file"
                        name="avatar"
                        id="avatar" />
                      <img
                        class="h-32 w-32 rounded-full"
                        src="{{$data->getFirstMediaUrl() != null ? $data->getFirstMediaUrl() : 'https://avatars.githubusercontent.com/u/32349150?v=4'}}"
                        alt="Ahmed Shamim Hasan Shaon" />
                      <label for="avatar">
                        <div
                          class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                          Change
                        </div>
                      </label>
                    </div>
                  </div>

                <div class="sm:col-span-3">
                  <label
                    for="first-name"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >First name</label
                  >
                  <div class="mt-2">
                    <input
                      type="text"
                      name="firstName"
                      id="first-name"
                      autocomplete="given-name"
                      value="{{$data->firstName ?? ''}}"
                      class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                  </div>
                </div>

                <div class="sm:col-span-3">
                  <label
                    for="last-name"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >Last name</label
                  >
                  <div class="mt-2">
                    <input
                      type="text"
                      name="lastName"
                      id="last-name"
                      value="{{$data->lastName ?? ''}}"
                      autocomplete="family-name"
                      class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                  </div>
                </div>

                <div class="col-span-full">
                  <label
                    for="email"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >Email address</label
                  >
                  <div class="mt-2">
                    <input
                      id="email"
                      name="email"
                      type="email"
                      autocomplete="email"
                      value="{{$data->email ?? ''}}"
                      disabled
                      class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                  </div>
                </div>

                <div class="col-span-full">
                  <label
                    for="password"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >Password</label
                  >
                  <div class="mt-2">
                    <input
                      type="password"
                      name="password"
                      id="password"
                      autocomplete="password"
                      placeholder="••••••••"
                      class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                  </div>
                    @if($errors->has('password'))
                    <div class="text-red-600 text-right">{{$errors->first('password')}}</div>
                    @endif
                </div>

                <div class="col-span-full">
                    <label
                        for="confirmPassword"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Confirm Password</label
                    >
                    <div class="mt-2">
                        <input
                        type="password"
                        name="confirmPassword"
                        id="confirmPassword"
                        autocomplete="password"
                        placeholder="••••••••"
                        class="{{$errors->has('confirmPassword') ? 'ring-red-300':'ring-gray-300'}} block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                    </div>
                    @if($errors->has('confirmPassword'))
                    <div class="text-red-600 text-right">{{$errors->first('confirmPassword')}}</div>
                    @endif
                </div>
              </div>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
              <div class="col-span-full">
                <label
                  for="bio"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >Bio</label
                >
                <div class="mt-2">
                  <textarea
                    id="bio"
                    name="bio"
                    rows="3"
                    class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6"
                    >
                    {{$data->bio ?? ''}}
                    </textarea
                  >
                </div>
                <p class="mt-3 text-sm leading-6 text-gray-600">
                  Write a few sentences about yourself.
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
          <button
            type="button"
            class="text-sm font-semibold leading-6 text-gray-900">
            Cancel
          </button>
          <button
            type="submit"
            class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
            Save
          </button>
        </div>
      </form>
      <!-- /Profile Edit Form -->
    </main>

@stop
