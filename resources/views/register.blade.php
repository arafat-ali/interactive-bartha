@extends('layouts.auth')
@section('content')
{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            <li>{{ $errors->has('lastName') }}</li>
        </ul>
    </div>
@endif --}}
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <a
        href="./index.html"
        class="text-center text-6xl font-bold text-gray-900"
        ><h1>Barta</h1></a
      >
      <h1
        class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
        Create a new account
      </h1>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" action="/register" method="POST">
        @csrf

        <!-- First Name -->
        <div>
          <label
            for="first_name"
            class="block text-sm font-medium leading-6 text-gray-900 after:content-['*'] after:ml-0.5 after:text-red-500"
            >First Name</label
          >
          <div class="mt-2">
            <input
              id="first_name"
              name="firstName"
              type="text"
              autocomplete="first_name"
              placeholder="Muhammad"
              required
              class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6"
              value="{{old('firstName')}}"
              />
          </div>
        </div>

        <!-- Last Name -->
        <div>
            <label
                for="last_name"
                class="block text-sm font-medium leading-6 text-gray-900 after:content-['*'] after:ml-0.5 after:text-red-500"
                >Last Name</label
            >
            <div class="mt-2">
                <input
                id="last_name"
                name="lastName"
                type="text"
                autocomplete="last_name"
                placeholder="Alp Arslan"
                required
                class="{{$errors->has('lastName') ? 'ring-red-300':'ring-gray-300'}} block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6"
                value="{{old('lastName')}}"
                />
                @if($errors->has('lastName'))
                    <div class="text-red-600 text-right">{{$errors->first('lastName')}}</div>
                @endif
            </div>
        </div>

        <!-- Email -->
        <div>
          <label
            for="email"
            class="block text-sm font-medium leading-6 text-gray-900 after:content-['*'] after:ml-0.5 after:text-red-500"
            >Email address</label
          >
          <div class="mt-2">
            <input
              id="email"
              name="email"
              type="email"
              autocomplete="email"
              placeholder="alp.arslan@mail.com"
              required
              class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6"
              value="{{old('email')}}"
              />
          </div>
        </div>

        <!-- Password -->
        <div>
          <label
            for="password"
            class="block text-sm font-medium leading-6 text-gray-900 after:content-['*'] after:ml-0.5 after:text-red-500"
            >Password</label
          >
          <div class="mt-2">
            <input
              id="password"
              name="password"
              type="password"
              autocomplete="current-password"
              placeholder="••••••••"
              required
              class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
            <label
              for="password"
              class="block text-sm font-medium leading-6 text-gray-900 after:content-['*'] after:ml-0.5 after:text-red-500"
              >Confirm Password</label
            >
            <div class="mt-2">
              <input
                id="password"
                name="confirmPassword"
                type="password"
                autocomplete="current-password"
                placeholder="••••••••"
                required
                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
            </div>
        </div>

        <div>
          <button
            type="submit"
            class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
            Register
          </button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Already a member?
        <a
          href="/login"
          class="font-semibold leading-6 text-black hover:text-black"
          >Sign In</a
        >
      </p>
    </div>
</div>

@stop
