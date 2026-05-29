<x-app-layout>
    <div class="py-12 bg-[#F9FAFB] dark:bg-[#0B0F1A] min-h-screen antialiased transition-colors duration-300">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10">
                <a href="{{ route('admin.dashboard') }}"
                    class="group inline-flex items-center text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest hover:text-indigo-500 transition-colors">
                    <svg class="w-3 h-3 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to  
                </a>
                <div class="flex justify-between items-end mt-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">System Analytics
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Real-time visualization of complaint
                            trends and agency distributions.</p>
                    </div>
                    <div class="hidden md:block">
                        <span
                            class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-[10px] font-bold uppercase tracking-widest rounded-full border border-indigo-100 dark:border-indigo-800">
                            Auto-refreshing
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @php
                    $totalVolume = array_sum($statusData);

                    // FIX: access by index
                    $pendingCount = $statusData[0] ?? 0;
                    $viewedCount = $statusData[1] ?? 0;
                    $resolvedCount = $statusData[2] ?? 0;

                    $resolutionRate = $totalVolume > 0 ? round(($resolvedCount / $totalVolume) * 100) : 0;

                    $activeQueue = $pendingCount + $viewedCount;

                    $metrics = [
                        [
                            'label' => 'Total Volume',
                            'value' => number_format($totalVolume),
                            'color' => 'text-gray-900 dark:text-white',
                        ],
                        [
                            'label' => 'Resolution Rate',
                            'value' => $resolutionRate . '%',
                            'color' => 'text-emerald-500',
                        ],
                        [
                            'label' => 'Active Queue',
                            'value' => number_format($activeQueue),
                            'color' => 'text-amber-500',
                        ],
                    ];
                @endphp
                @foreach ($metrics as $metric)
                    <div
                        class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-5 rounded-2xl shadow-sm">
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">
                            {{ $metric['label'] }}</p>
                        <p class="text-2xl font-semibold mt-1 {{ $metric['color'] }}">{{ $metric['value'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <div
                    class="lg:col-span-1 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-8 rounded-3xl shadow-sm flex flex-col">
                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-tight">Case
                            Distribution</h3>
                        <p class="text-xs text-gray-500 mt-1">Breakdown by current status</p>
                    </div>
                    <div class="relative flex-grow flex items-center justify-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <div
                    class="lg:col-span-2 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-8 rounded-3xl shadow-sm">
                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-tight">
                            Performance Trend</h3>
                        <p class="text-xs text-gray-500 mt-1">Monthly inquiry volume over time</p>
                    </div>
                    <div class="h-[300px]">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-8 rounded-3xl shadow-sm">
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-tight">Agency
                        Complaint Volume</h3>
                    <p class="text-xs text-gray-500 mt-1">Comparison of total complaints received per agency</p>
                </div>
                <div class="h-[400px]">
                    <canvas id="departmentChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const isDark = document.documentElement.classList.contains('dark');
        const labelColor = isDark ? '#64748b' : '#94a3b8';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.03)' : 'rgba(0, 0, 0, 0.03)';

        // Brand Colors (Emerald Green)
        const primaryGreen = '#10B981'; // Emerald 500
        const darkGreen = '#059669'; // Emerald 600
        const lightGreen = 'rgba(16, 185, 129, 0.15)';

        // Pre-parse the data
        const statusDataRaw = @json($statusData);
        const trendMonths = @json($months);
        const trendCounts = @json($monthlyCounts);
        const departmentLabels = @json($departmentData['labels']);
        const departmentCounts = @json($departmentData['counts']);

        const predictionMonths = @json($predictionMonths);
        const predictionCounts = @json($predictionCounts);

        Chart.defaults.color = labelColor;
        Chart.defaults.font.family = "'Plus Jakarta Sans', 'Inter', sans-serif";

        // 1. Status Doughnut
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Viewed', 'Resolved'],
                    datasets: [{
                        data: Object.values(statusDataRaw),
                        // Amber for Pending, Emerald 400 for Viewed, Emerald 600 for Resolved
                        backgroundColor: ['#F59E0B', '#34D399', '#059669'],
                        borderWidth: 0,
                        hoverOffset: 20,
                        borderRadius: 10,
                        spacing: 5
                    }]
                },
                options: {
                    cutout: '82%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 30,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: {
                                    size: 11,
                                    weight: '600'
                                }
                            }
                        }
                    }
                }
            });
        }

        const trendCanvas = document.getElementById('trendChart');
        if (trendCanvas) {
            const trendCtx = trendCanvas.getContext('2d');
            const trendGradient = trendCtx.createLinearGradient(0, 0, 0, 400);
            trendGradient.addColorStop(0, lightGreen);
            trendGradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

            // Merge labels: historical + prediction months
            const allLabels = [...trendMonths, ...predictionMonths];

            // Historical dataset: real values + null padding for prediction slots
            const historicalData = [
                ...trendCounts,
                ...Array(predictionMonths.length).fill(null)
            ];

            // Prediction dataset: null padding for historical slots + bridge point + predictions
            // The bridge point repeats the last historical value so the dotted line connects smoothly
            const predictionData = [
                ...Array(trendCounts.length - 1).fill(null),
                trendCounts[trendCounts.length - 1], // bridge/anchor point
                ...predictionCounts
            ];

            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: allLabels,
                    datasets: [{
                            label: 'Inquiries',
                            data: historicalData,
                            borderColor: primaryGreen,
                            borderWidth: 3,
                            fill: true,
                            backgroundColor: trendGradient,
                            tension: 0.4,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: primaryGreen,
                            pointBorderColor: '#fff',
                            spanGaps: false
                        },
                        {
                            label: 'Predicted',
                            data: predictionData,
                            borderColor: primaryGreen,
                            borderWidth: 2,
                            borderDash: [6, 4], // dotted line
                            fill: false,
                            tension: 0.4,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: primaryGreen,
                            pointBorderWidth: 2,
                            spanGaps: true // draws through the null padding
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: 10,
                            grid: {
                                color: gridColor
                            },
                            border: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                usePointStyle: true,
                                generateLabels(chart) {
                                    return [{
                                            text: 'Inquiries',
                                            strokeStyle: primaryGreen,
                                            fillStyle: primaryGreen,
                                            pointStyle: 'circle'
                                        },
                                        {
                                            text: 'Predicted',
                                            strokeStyle: primaryGreen,
                                            fillStyle: 'transparent',
                                            pointStyle: 'circle',
                                            lineDash: [6, 4]
                                        }
                                    ];
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label(ctx) {
                                    if (ctx.datasetIndex === 1 && ctx.dataIndex >= trendCounts.length) {
                                        return `Predicted: ${ctx.parsed.y}`;
                                    }
                                    return `Inquiries: ${ctx.parsed.y}`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // 3. Department Horizontal Bar Chart
        const departmentCtx = document.getElementById('departmentChart');
        if (departmentCtx) {
            new Chart(departmentCtx, {
                type: 'bar',
                data: {
                    labels: departmentLabels,
                    datasets: [{
                        label: 'Total Complaints',
                        data: departmentCounts,
                        backgroundColor: primaryGreen,
                        borderRadius: 6,
                        barThickness: 24,
                        hoverBackgroundColor: darkGreen,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: isDark ? '#064e3b' : '#fff', // Dark emerald bg for tooltips
                            titleColor: isDark ? '#fff' : '#064e3b',
                            padding: 12,
                            cornerRadius: 12,
                            borderWidth: 1,
                            borderColor: isDark ? '#065f46' : '#e2e8f0'
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                color: gridColor
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: '600',
                                    size: 11
                                },
                                padding: 10
                            }
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>
