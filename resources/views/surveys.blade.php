@extends('layouts.app')

@section('content')
<div class="bg-gray-900">
  <div class="mx-auto">
    <div class="bg-gray-900 py-10">
      <div class="px-4 sm:px-6 lg:px-8">
        <div x-data="{openCreateSurveyModal: false}" class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="text-3xl font-semibold leading-6 text-white">Surveys</h1>
            <p class="mt-4 text-sm text-gray-300">A list of all the surveys in your account.</p>
          </div>
          <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            @if(auth()->user() && auth()->user()->role === 'admin')
              <button @click="openCreateSurveyModal = true" @close-modal.window="openCreateSurveyModal = false" type="button" class="block rounded-md bg-indigo-500 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Create survey</button>
            @endif
          </div>
          <x-modal-create-survey />
        </div>
        <div class="m-8 flow-root">
          <div x-data="{openUpdateSurveyModal: false}" class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div x-data="{openAnswerSurveyModal: false}" class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
              <table class="min-w-full divide-y divide-gray-700">
                <thead>
                  <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-0">Survey name</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Number of questions</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Number of participants</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Status</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                      <span class="sr-only">Edit</span>
                    </th>
                  </tr>
                </thead>
                  @livewire('survey-list')
              </table>
              <x-modal-answer-survey />
              <x-modal-update-survey />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection