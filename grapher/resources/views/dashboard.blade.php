<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent leading-tight">
            📊 Sales Analytics Dashboard
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Key Metrics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Sales Card -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-8 text-white transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-semibold uppercase tracking-wide">Total Sales</p>
                            <h3 class="text-4xl font-bold mt-2">${{ number_format($totalSales, 0) }}</h3>
                            <p class="text-blue-100 text-xs mt-2">Year to date</p>
                        </div>
                        <div class="text-6xl opacity-20">💰</div>
                    </div>
                </div>

                <!-- Average Sales Card -->
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg p-8 text-white transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-semibold uppercase tracking-wide">Average Sales</p>
                            <h3 class="text-4xl font-bold mt-2">${{ number_format($avgSales, 0) }}</h3>
                            <p class="text-emerald-100 text-xs mt-2">Per period</p>
                        </div>
                        <div class="text-6xl opacity-20">📈</div>
                    </div>
                </div>

                <!-- Peak Sales Card -->
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-8 text-white transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-semibold uppercase tracking-wide">Peak Sales</p>
                            <h3 class="text-4xl font-bold mt-2">${{ number_format($maxSales, 0) }}</h3>
                            <p class="text-orange-100 text-xs mt-2">Highest month</p>
                        </div>
                        <div class="text-6xl opacity-20">🚀</div>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Sales Trend Chart -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden border border-slate-200 dark:border-slate-700">
                    <div class="px-8 py-6 bg-gradient-to-r from-purple-50 to-blue-50 dark:from-slate-700 dark:to-slate-600 border-b border-slate-200 dark:border-slate-600">
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                            <span class="text-2xl">📊</span> Sales Trend
                        </h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300 mt-1">Monthly sales performance</p>
                    </div>
                    <div class="p-8">
                        <div style="position: relative; height: 300px;">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Category Distribution Chart -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden border border-slate-200 dark:border-slate-700">
                    <div class="px-8 py-6 bg-gradient-to-r from-pink-50 to-rose-50 dark:from-slate-700 dark:to-slate-600 border-b border-slate-200 dark:border-slate-600">
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                            <span class="text-2xl">🎯</span> Category Distribution
                        </h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300 mt-1">Sales by product category</p>
                    </div>
                    <div class="p-8">
                        <div style="position: relative; height: 300px;">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Cumulative Sales Chart -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden border border-slate-200 dark:border-slate-700">
                    <div class="px-8 py-6 bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-slate-700 dark:to-slate-600 border-b border-slate-200 dark:border-slate-600">
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                            <span class="text-2xl">📈</span> Growth Analysis
                        </h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300 mt-1">Cumulative sales growth</p>
                    </div>
                    <div class="p-8">
                        <div style="position: relative; height: 300px;">
                            <canvas id="growthChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Sales Comparison Chart -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden border border-slate-200 dark:border-slate-700">
                    <div class="px-8 py-6 bg-gradient-to-r from-violet-50 to-purple-50 dark:from-slate-700 dark:to-slate-600 border-b border-slate-200 dark:border-slate-600">
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                            <span class="text-2xl">💹</span> Sales Comparison
                        </h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300 mt-1">Month-over-month comparison</p>
                    </div>
                    <div class="p-8">
                        <div style="position: relative; height: 300px;">
                            <canvas id="comparisonChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const labels = @json($labels);
            const salesData = @json($data);
            const categories = @json($categories);
            const categoryData = @json($categoryData);

            // Color schemes
            const purpleGradient = {
                light: 'rgba(168, 85, 247, 0.1)',
                main: 'rgb(168, 85, 247)',
                dark: 'rgb(126, 34, 206)'
            };

            const blueGradient = {
                light: 'rgba(59, 130, 246, 0.1)',
                main: 'rgb(59, 130, 246)',
                dark: 'rgb(29, 78, 216)'
            };

            const emeraldGradient = {
                light: 'rgba(16, 185, 129, 0.1)',
                main: 'rgb(16, 185, 129)',
                dark: 'rgb(4, 120, 87)'
            };

            const colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#FFA07A', '#98D8C8'];

            // 1. Trend Chart - Line Chart with Gradient
            const ctxTrend = document.getElementById('trendChart').getContext('2d');
            const trendGradient = ctxTrend.createLinearGradient(0, 0, 0, 300);
            trendGradient.addColorStop(0, 'rgba(168, 85, 247, 0.4)');
            trendGradient.addColorStop(1, 'rgba(168, 85, 247, 0.01)');

            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Monthly Sales',
                        data: salesData,
                        borderColor: purpleGradient.main,
                        backgroundColor: trendGradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 6,
                        pointBackgroundColor: purpleGradient.main,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: { size: 13, weight: 'bold' }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { drawBorder: false, color: 'rgba(0,0,0,0.05)' },
                            ticks: { font: { size: 11 } }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });

            // 2. Category Distribution - Doughnut Chart
            const ctxCategory = document.getElementById('categoryChart').getContext('2d');
            new Chart(ctxCategory, {
                type: 'doughnut',
                data: {
                    labels: categories,
                    datasets: [{
                        data: categoryData,
                        backgroundColor: colors,
                        borderColor: '#fff',
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: { size: 12, weight: '500' }
                            }
                        }
                    }
                }
            });

            // 3. Growth Chart - Area Chart
            const cumulativeData = salesData.map((val, idx) => {
                return salesData.slice(0, idx + 1).reduce((a, b) => a + b, 0);
            });

            const ctxGrowth = document.getElementById('growthChart').getContext('2d');
            const growthGradient = ctxGrowth.createLinearGradient(0, 0, 0, 300);
            growthGradient.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
            growthGradient.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

            new Chart(ctxGrowth, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Cumulative Sales',
                        data: cumulativeData,
                        borderColor: emeraldGradient.main,
                        backgroundColor: growthGradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: emeraldGradient.dark,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: { size: 13, weight: 'bold' }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { drawBorder: false, color: 'rgba(0,0,0,0.05)' },
                            ticks: { font: { size: 11 } }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });

            // 4. Comparison Chart - Bar Chart
            const comparisonData = salesData.map(val => val * (0.8 + Math.random() * 0.4));

            const ctxComparison = document.getElementById('comparisonChart').getContext('2d');
            new Chart(ctxComparison, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Current Period',
                            data: salesData,
                            backgroundColor: 'rgba(59, 130, 246, 0.8)',
                            borderColor: 'rgb(29, 78, 216)',
                            borderWidth: 1,
                            borderRadius: 8
                        },
                        {
                            label: 'Previous Period',
                            data: comparisonData,
                            backgroundColor: 'rgba(168, 85, 247, 0.8)',
                            borderColor: 'rgb(126, 34, 206)',
                            borderWidth: 1,
                            borderRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: { size: 12, weight: 'bold' }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { drawBorder: false, color: 'rgba(0,0,0,0.05)' },
                            ticks: { font: { size: 11 } }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
