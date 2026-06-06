<!-- Sidebar Navigation -->
<div class="flex flex-col gap-2 overflow-y-auto pb-6">


    <a href="{{ route('student.dashboard') }}" wire:navigate
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('student.dashboard')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div
            class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('student.dashboard') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-secondary-400/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard w-h h-5">
                <rect width="7" height="9" x="3" y="3" rx="1" />
                <rect width="7" height="5" x="14" y="3" rx="1" />
                <rect width="7" height="9" x="14" y="12" rx="1" />
                <rect width="7" height="5" x="3" y="16" rx="1" />
            </svg>
        </div>
        <span class="{{ request()->routeIs('student.dashboard') ? 'font-semibold' : 'font-medium' }}">Dashboard</span>
        @if (request()->routeIs('student.dashboard'))
            <span class="sr-only">active</span>
        @endif
    </a>

    <a href="{{ route('student.exams.index') }} " wire:navigate
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('exams*') || request()->routeIs('student.exams*')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div
            class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('exams*') || request()->routeIs('student.exams*')
                ? 'bg-white/20'
                : 'bg-gray-100 group-hover:bg-secondary-400/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-book-open-check-icon lucide-book-open-check">
                <path d="M12 21V7" />
                <path d="m16 12 2 2 4-4" />
                <path
                    d="M22 6V4a1 1 0 0 0-1-1h-5a4 4 0 0 0-4 4 4 4 0 0 0-4-4H3a1 1 0 0 0-1 1v13a1 1 0 0 0 1 1h6a3 3 0 0 1 3 3 3 3 0 0 1 3-3h6a1 1 0 0 0 1-1v-1.3" />
            </svg>
        </div>
        <span
            class="{{ request()->routeIs('exams*') || request()->routeIs('student.exams*') ? 'font-semibold' : 'font-medium' }}">Exams</span>
        @if (request()->routeIs('exams*') || request()->routeIs('student.exams*'))
            <span class="sr-only">active</span>
        @endif

    </a>

    <a href="{{ route('student.grades.index') }} " wire:navigate
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('grades*') || request()->routeIs('student.grades*')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div
            class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('grades*') || request()->routeIs('student.grades*')
                ? 'bg-white/20'
                : 'bg-gray-100 group-hover:bg-secondary-400/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-file-chart-column-icon lucide-file-chart-column">
                <path
                    d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                <path d="M8 18v-1" />
                <path d="M12 18v-6" />
                <path d="M16 18v-3" />
            </svg>
        </div>
        <span
            class="{{ request()->routeIs('grades*') || request()->routeIs('student.grades*') ? 'font-semibold' : 'font-medium' }}">Grades</span>
        @if (request()->routeIs('grades*') || request()->routeIs('student.grades*'))
            <span class="sr-only">active</span>
        @endif
    </a>


    <a href="{{ route('student.classrooms.index') }} " wire:navigate
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('classrooms*') || request()->routeIs('student.classrooms*')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div
            class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('classrooms*') || request()->routeIs('student.classrooms*')
                ? 'bg-white/20'
                : 'bg-gray-100 group-hover:bg-secondary-400/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-graduation-cap-icon lucide-graduation-cap">
                <path
                    d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z" />
                <path d="M22 10v6" />
                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5" />
            </svg>
        </div>
        <span
            class="{{ request()->routeIs('classrooms*') || request()->routeIs('student.classrooms*') ? 'font-semibold' : 'font-medium' }}">Classroom</span>
        @if (request()->routeIs('classrooms*') || request()->routeIs('student.classrooms*'))
            <span class="sr-only">active</span>
        @endif
    </a>

</div>
