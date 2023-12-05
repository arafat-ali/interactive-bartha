@extends('user.layouts.default')
@section('content')

<main class="container max-w-2xl mx-auto space-y-8 mt-8 px-2 min-h-screen">
    <!-- Cover Container -->
    @foreach ($data as $user)


    <section class="bg-white border-2 p-6 border-gray-800 rounded-xl min-h-[300px] space-y-8 flex items-center flex-col justify-center">
      <!-- Profile Info -->
      <div class="w-full flex flex-wrap justify-center space-x-8">
        <!-- Avatar -->
        <div class="max-w-[40%]">
          <img
            class="w-32 h-32 rounded-lg border-2 border-gray-800"
            src="https://avatars.githubusercontent.com/u/32349150?v=4"
            alt="Ahmed Shamim" />
<!--            <span class="bottom-2 right-4 absolute w-3.5 h-3.5 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full"></span>-->
        </div>
        <!-- /Avatar -->

        <!-- User Meta -->
        <div class="max-w-[40%]">
          <a href="{{route('profile', $user->uuid)}}" class="font-bold md:text-2xl">{{$user->firstName . ' ' .$user->lastName }}</a>
          <p class="text-gray-700">{{$user->bio}}</p>
        </div>
        <!-- / User Meta -->
      </div>
      <!-- /Profile Info -->

      <!-- Profile Stats -->
      <div
        class="flex flex-row gap-16 justify-center text-center items-center">
        <!-- Total Posts Count -->
        <div class="flex flex-col justify-center items-center">
          <h4 class="sm:text-xl font-bold">{{$user->posts->count()}}</h4>
          <p class="text-gray-600">Posts</p>
        </div>

        <!-- Total Comments Count -->
        <div class="flex flex-col justify-center items-center">
          <h4 class="sm:text-xl font-bold">{{$user->comments->count()}}</h4>
          <p class="text-gray-600">Comments</p>
        </div>
      </div>
      <!-- /Profile Stats -->
    </section>
    @endforeach
</main>

@stop
