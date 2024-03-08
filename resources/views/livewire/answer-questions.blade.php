<form wire:submit.prevent="submitAnswers">
<h3 class="text-center text-2xl font-semibold">{{ $surveyName }}</h3>
    @foreach($questions as $question)
        <div class="mt-8">
            <label class="text-xl font-semibold">{{ $question->question_text }}</label>
            <div class="flex justify-between mt-4">
            @foreach($question->answerOptions as $option)
                <div class="flex flex-col items-center justify-center">
                    <input type="radio" wire:model="submittedAnswers.{{ $question->id }}" value="{{ $option->id }}">
                    <label>{{ $option->option_text }}</label>
                </div>
            @endforeach
            </div>
        </div>
    @endforeach
        <div class="mt-8 border-t border-gray-200 pt-4">
            <div class="flex justify-end">
                <span class="inline-flex rounded-md shadow-sm">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Submit
                    </button>
                </span>
            </div>
        </div>
</form>