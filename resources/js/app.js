import Chart from 'chart.js/auto';

window.Chart = Chart;

document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle (Public Site)
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Admin Mobile Sidebar Toggle
    const adminSidebar = document.getElementById('adminSidebar');
    const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
    const mobileSidebarClose = document.getElementById('mobileSidebarClose');
    const mobileSidebarBackdrop = document.getElementById('mobileSidebarBackdrop');

    function openAdminSidebar() {
        if (adminSidebar) adminSidebar.classList.remove('-translate-x-full');
        if (mobileSidebarBackdrop) mobileSidebarBackdrop.classList.remove('hidden');
    }

    function closeAdminSidebar() {
        if (adminSidebar) adminSidebar.classList.add('-translate-x-full');
        if (mobileSidebarBackdrop) mobileSidebarBackdrop.classList.add('hidden');
    }

    if (mobileSidebarToggle) mobileSidebarToggle.addEventListener('click', openAdminSidebar);
    if (mobileSidebarClose) mobileSidebarClose.addEventListener('click', closeAdminSidebar);
    if (mobileSidebarBackdrop) mobileSidebarBackdrop.addEventListener('click', closeAdminSidebar);


    // Initialize Population Chart if canvas exists
    const popCanvas = document.getElementById('populationChart');
    if (popCanvas) {
        // Data should be passed from blade via window variable or data attributes
        // As a fallback, we use some dummy data for preview if actual data isn't provided via a script tag
        const popData = window.villagePopulationData || { male: 1200, female: 1250 };
        
        new Chart(popCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [popData.male, popData.female],
                    backgroundColor: ['#0ea5e9', '#f43f5e'], // sky-500, rose-500
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 20, usePointStyle: true, font: { family: "'Plus Jakarta Sans', sans-serif" } }
                    }
                }
            }
        });
    }

    // Initialize Age Group Chart
    const ageCanvas = document.getElementById('ageGroupChart');
    if (ageCanvas && window.villagePopulationData && window.villagePopulationData.ageGroups) {
        const ageGroups = window.villagePopulationData.ageGroups;
        const labels = Object.keys(ageGroups);
        const data = Object.values(ageGroups);

        new Chart(ageCanvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: data,
                    backgroundColor: '#0284c7', // sky-600
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { font: { family: "'Plus Jakarta Sans', sans-serif" } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: "'Plus Jakarta Sans', sans-serif" } }
                    }
                }
            }
        });
    }

    // Initialize Budget Chart if canvas exists
    const budgetCanvas = document.getElementById('budgetChart');
    if (budgetCanvas) {
        const budgetData = window.villageBudgetData || { income: 1500000000, expense: 1450000000 };
        
        new Chart(budgetCanvas, {
            type: 'bar',
            data: {
                labels: ['Pendapatan', 'Belanja'],
                datasets: [{
                    label: 'Jumlah (Rp)',
                    data: [budgetData.income, budgetData.expense],
                    backgroundColor: ['#10b981', '#f59e0b'], // emerald-500, amber-500
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000000) return 'Rp ' + (value / 1000000000).toFixed(1) + 'M';
                                if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + 'Jt';
                                return value;
                            },
                            font: { family: "'Plus Jakarta Sans', sans-serif" }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: "'Plus Jakarta Sans', sans-serif", weight: 'bold' } }
                    }
                }
            }
        });
    }
});
