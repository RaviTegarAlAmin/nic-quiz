<!-- Sidebar Navigation -->
<div class="flex flex-col gap-2 overflow-y-auto pb-6">


    <a href="{{ route('dashboard.teacher') }}" wire:navigate
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('dashboard.teacher')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('dashboard.teacher')
                ? 'bg-white/20'
                : 'bg-gray-100 group-hover:bg-secondary-400/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"
                aria-hidden="true">
                <path
                    d="M15.5 2A1.5 1.5 0 0 0 14 3.5v13a1.5 1.5 0 0 0 1.5 1.5h1a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 16.5 2h-1ZM9.5 6A1.5 1.5 0 0 0 8 7.5v9A1.5 1.5 0 0 0 9.5 18h1a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 10.5 6h-1ZM3.5 10A1.5 1.5 0 0 0 2 11.5v5A1.5 1.5 0 0 0 3.5 18h1A1.5 1.5 0 0 0 6 16.5v-5A1.5 1.5 0 0 0 4.5 10h-1Z" />
            </svg>
        </div>
        <span class="{{ request()->routeIs('dashboard.teacher') ? 'font-semibold' : 'font-medium' }}">Dashboard</span>
        @if(request()->routeIs('dashboard.teacher'))
            <span class="sr-only">active</span>
        @endif
    </a>

    <a href="{{ route('exams') }} " wire:navigate
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('exams*') || request()->routeIs('teacher.exams*')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('exams*') || request()->routeIs('teacher.exams*')
                ? 'bg-white/20'
                : 'bg-gray-100 group-hover:bg-secondary-400/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"
                aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 0 0 1.33 0l1.713-3.293a.783.783 0 0 1 .642-.413 41.102 41.102 0 0 0 3.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0 0 10 2ZM6.75 6a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Zm0 2.5a.75.75 0 0 0 0 1.5h3.5a.75.75 0 0 0 0-1.5h-3.5Z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        <span class="{{ request()->routeIs('exams*') || request()->routeIs('teacher.exams*') ? 'font-semibold' : 'font-medium' }}">Exams</span>
        @if(request()->routeIs('exams*') || request()->routeIs('teacher.exams*'))
            <span class="sr-only">active</span>
        @endif
    </a>

    <a href="#"
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('grades*')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('grades*')
                ? 'bg-white/20'
                : 'bg-gray-100 group-hover:bg-secondary-400/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"
                aria-hidden="true">
                <path
                    d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
            </svg>
        </div>
        <span class="{{ request()->routeIs('grades*') ? 'font-semibold' : 'font-medium' }}">Grades</span>
        @if(request()->routeIs('grades*'))
            <span class="sr-only">active</span>
        @endif
    </a>

    <a href="#"
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('classrooms*')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('classrooms*')
                ? 'bg-white/20'
                : 'bg-gray-100 group-hover:bg-secondary-400/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"
                aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M10 2a6 6 0 0 0-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 0 0 .515 1.076 32.91 32.91 0 0 0 3.256.508 3.5 3.5 0 0 0 6.972 0 32.903 32.903 0 0 0 3.256-.508.75.75 0 0 0 .515-1.076A11.448 11.448 0 0 1 16 8a6 6 0 0 0-6-6ZM8.05 14.943a33.54 33.54 0 0 0 3.9 0 2 2 0 0 1-3.9 0Z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        <span class="{{ request()->routeIs('classrooms*') ? 'font-semibold' : 'font-medium' }}">Class</span>
        @if(request()->routeIs('classrooms*'))
            <span class="sr-only">active</span>
        @endif
    </a>

</div>
