<div>

    {{-- Average Scores Card Stats --}}

    <div class=" grid md:grid-cols-3 grid-cols-1 gap-3">


        <div class=" md:col-span-2 col-span-3 flex justify-start w-full gap-2">
            <x-ui.detail-card
                class="!py-1  border-gray-400 border-l-4 hover:shadow-sm overflow-hidden w-full flex items-center">

                <div>
                    <h6 class=" text-sm underline text-gray-600 mr-2 z-20">
                        Ujian Dinilai
                    </h6>
                    <p class=" text-xl relative z-20">
                        {{ $gradedExams ?? 0 }} <span class=" text-xs text-gray-500">Dari</span>
                        {{ $finishedExams ?? 0 }}
                    </p>
                </div>
            </x-ui.detail-card>
            <x-ui.detail-card
                class="!py-1  border-gray-400 border-l-4 hover:shadow-sm overflow-hidden w-full flex items-center">

                <div>
                    <h6 class=" text-sm underline text-gray-600 mr-2 z-20">
                        Tertinggi
                    </h6>
                    <p class=" text-xl relative z-20">
                        {{ round($averageScores[$maxIndex]['average'], 2) ?? 0 }}
                    </p>
                </div>
                <div
                    class="text-white border-2 border-success-500 rounded-xl w-12 py-0 my-auto text-center text-[10px] bg-success-600  font-bold z-20">
                    {{ $averageScores[$maxIndex]['code'] ?? 'N/A' }}
                </div>



            </x-ui.detail-card>
            <x-ui.detail-card
                class="!py-1  border-gray-400 border-l-4 hover:shadow-sm overflow-hidden w-full flex items-center">

                <div>
                    <h6 class=" text-sm underline text-gray-600 mr-2 z-20">
                        Terendah
                    </h6>
                    <p class=" text-xl relative z-20">
                        {{ round($averageScores[$minIndex]['average'], 2) ?? 0 }}
                    </p>
                </div>
                <div
                    class="text-white border-2 border-warning-500 rounded-xl w-12 py-0 my-auto text-center text-[10px] bg-warning-600  font-bold z-20">
                    {{ $averageScores[$minIndex]['code'] ?? 'N/A' }}
                </div>



            </x-ui.detail-card>

        </div>
        <div class=" md:col-span-1 col-span-3">
            <x-ui.detail-card
                class="!py-2 !bg-primary-500 border-gray-400/80 border-l-4 border-l-gray-400 hover:shadow-sm overflow-hidden">

                <div class=" flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-astroid-icon lucide-astroid text-primary-700">
                        <path
                            d="M12.983 21.186a1 1 0 0 1-1.966 0 10 10 0 0 0-8.203-8.203 1 1 0 0 1 0-1.966 10 10 0 0 0 8.203-8.203 1 1 0 0 1 1.966 0 10 10 0 0 0 8.203 8.203 1 1 0 0 1 0 1.966 10 10 0 0 0-8.203 8.203" />
                    </svg>
                    <div class=" -mt-2">
                        <h6 class=" text-sm underline text-gray-600">
                            Rata-Rata
                        </h6>
                        <p class=" text-2xl">
                            {{ $averageTotal ?? 0 }}
                        </p>
                    </div>
                </div>
            </x-ui.detail-card>

        </div>
        <x-ui.detail-card
            class=" relative overflow-hidden col-span-3 mb-2 flex gap-2 border-gray-400/80 text-gray-600 md:text-left text-center !text-lg border-l-4 bg-warning-600/70 hover:shadow-sm font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-chart-bar-icon lucide-chart-bar text-gray-700">
                <path d="M3 3v16a2 2 0 0 0 2 2h16" />
                <path d="M7 16h8" />
                <path d="M7 11h12" />
                <path d="M7 6h3" />
            </svg>
            Rata-Rata Mata Pelajaran
            <div
                class="absolute -right-20 -top-4 bg-white border-2 border-success-300 w-36 h-36 rounded-full opacity-30">
                &nbsp;
            </div>
        </x-ui.detail-card>
    </div>

    {{-- Chart --}}

    <x-card class="h-96 mb-3 border border-l-4 border-b-8 border-gray-400">
        <div class="relative h-full w-full">
            <canvas id="averageScoreChart"></canvas>
        </div>
    </x-card>

    @script
        <script>
            const datasets = @json(collect($averageScores)->pluck('average'));

            new Chart(document.getElementById('averageScoreChart'), {
                type: 'bar',
                data: {
                    labels: @json(collect($averageScores)->pluck('name')),
                    datasets: [{
                        label: 'Rata-Rata',
                        data: datasets,
                        backgroundColor: datasets.map(v => v >= 75 ? '#6546E0' : '#EBAA8A'),
                        borderColor: '#E5E7EB',
                        borderRadius: 10,
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: false
                        }
                    }
                }
            });
        </script>
    @endscript


</div>
