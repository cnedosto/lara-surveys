@extends('layouts.app')

@section('content')
<div class="bg-gray-900">
  <div class="mx-auto">
    <div class="bg-gray-900 py-10">
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="text-3xl font-semibold leading-6 text-white">Surveys reports</h1>
            <p class="mt-4 text-sm text-gray-300">A list of all the surveys in your team and their answers.</p>
          </div>
        </div>
        <div x-data="{openSurveyReportModal: false}" class="mt-8 flow-root">
          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
              <table class="min-w-full divide-y divide-gray-700">
                <thead>
                  <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-0">Survey name</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Number of questions</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Number of participants</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Status</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                      <span class="sr-only">Show answers</span>
                    </th>
                  </tr>
                </thead>
                  @livewire('survey-reports')
              </table>
            </div>
          </div>
          <x-modal-survey-report />
        </div>
      </div>
    </div>
  </div>
</div>
@endsection