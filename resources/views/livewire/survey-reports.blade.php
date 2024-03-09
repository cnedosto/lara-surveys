<tbody class="divide-y divide-gray-800">
    @foreach($surveys as $survey)
        <tr>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-0">{{ $survey->name }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ $survey->questions_count }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ $survey->participants() }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                <span class="capitalize inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-inset ring-1
                {{$survey->status() == 'ongoing' ? 'bg-indigo-400/10 text-indigo-400 ring-indigo-400/30' : 'bg-green-500/10 text-green-400 ring-green-500/20'}}">
                {{ $survey->status() }}</span>
            </td>
            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0 flex flex-col gap-y-2">
                <div @click="$dispatch('openSurveyReport', { surveyId: {{$survey->id}} }); openSurveyReportModal = true" class="text-indigo-400 hover:text-indigo-300 cursor-pointer">Show answers</div>
            </td>
        </tr>
    @endforeach
</tbody>