<div>
    <x-header>Dashboard Siswa</x-header>

    <div class=" grid lg:grid-cols-5 grid-cols-2">

        {{-- Exam Status Card --}}

        <div class=" lg:col-span-3 col-span-2 flex flex-col">

            <livewire:student.dashboard.exam-status-cards :activeExams="$activeExams" :finishedExams="$finishedExams">

            </livewire:student.dashboard.exam-status-cards>

            {{-- Average Scores --}}

            <div class=" pr-3 mt-3">
                <livewire:student.dashboard.average-scores :averageScores="$averageScores"
                    :finishedExams="count($finishedExams)"></livewire:student.dashboard.average-scores>
            </div>
        </div>

        <div class=" col-span-2 flex flex-col">

            <div class=" mb-2  h-64">
                {{-- Active Exam List --}}

                <livewire:student.dashboard.active-exams :activeExams="$activeExams">

                </livewire:student.dashboard.active-exams>

            </div>

            <div class=" mt-20 h-64">

                <livewire:student.dashboard.latest-scores :latestScores="$latestScores"></livewire:student.dashboard.latest-scores>

            </div>

        </div>

    </div>



</div>
