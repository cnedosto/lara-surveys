<div>
    <h2 class="text-4xl font-semibold leading-9 mb-6 text-center">Update a survey</h2>
    <form wire:submit.prevent="updateSurvey" @submit="openUpdateSurveyModal = false">
        <x-form-input wire:model="surveyName" label="Survey name" :required="true" class="col-span-6 sm:col-span-3 mt-2"/>

        @foreach($questions as $index => $question)
            <div class="mt-4 flex items-end" key="{{$index}}">
                <x-form-input wire:model="questions.{{$index}}.question_text" label="Question {{$index + 1}}" :required="true" class="grow"/>
                <button wire:click.prevent="removeQuestion({{$index}})" class="mt-2 ml-2 bg-red-500 text-white px-2 py-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </button>
            </div>
        @endforeach

        <div class="mt-4">
            <button wire:click.prevent="addQuestion" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">Add Question</button>
        </div>

        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="flex justify-between mt-4">
                <span class="inline-flex rounded-md shadow-sm">
                    <button wire:click="deleteSurvey; openUpdateSurveyModal = false" type="button" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition duration-150 ease-in-out">
                        Delete Survey
                    </button>
                </span>
                <span class="inline-flex rounded-md shadow-sm">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Update Survey
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>
