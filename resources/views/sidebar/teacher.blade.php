<!-- Sidebar Navigation -->
<div class="flex flex-col gap-2 overflow-y-auto pb-6">


    <a href="{{ route('dashboard.teacher') }}" wire:navigate
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('dashboard.teacher')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div
            class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('dashboard.teacher') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-secondary-400/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard w-h h-5">
                <rect width="7" height="9" x="3" y="3" rx="1" />
                <rect width="7" height="5" x="14" y="3" rx="1" />
                <rect width="7" height="9" x="14" y="12" rx="1" />
                <rect width="7" height="5" x="3" y="16" rx="1" />
            </svg>
        </div>
        <span class="{{ request()->routeIs('dashboard.teacher') ? 'font-semibold' : 'font-medium' }}">Dashboard</span>
        @if (request()->routeIs('dashboard.teacher'))
            <span class="sr-only">active</span>
        @endif
    </a>

    <a href="{{ route('exams') }} " wire:navigate
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('exams*') || request()->routeIs('teacher.exams*')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div
            class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('exams*') || request()->routeIs('teacher.exams*')
                ? 'bg-white/20'
                : 'bg-gray-100 group-hover:bg-secondary-400/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-pencil-ruler-icon lucide-pencil-ruler w-5 h-5">
                <path d="M13 7 8.7 2.7a2.41 2.41 0 0 0-3.4 0L2.7 5.3a2.41 2.41 0 0 0 0 3.4L7 13" />
                <path d="m8 6 2-2" />
                <path d="m18 16 2-2" />
                <path d="m17 11 4.3 4.3c.94.94.94 2.46 0 3.4l-2.6 2.6c-.94.94-2.46.94-3.4 0L11 17" />
                <path
                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                <path d="m15 5 4 4" />
            </svg>
        </div>
        <span
            class="{{ request()->routeIs('exams*') || request()->routeIs('teacher.exams*') ? 'font-semibold' : 'font-medium' }}">Exams</span>
        @if (request()->routeIs('exams*') || request()->routeIs('teacher.exams*'))
            <span class="sr-only">active</span>
        @endif
    </a>

    <a href="{{ route('teacher.classrooms') }} " wire:navigate
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('classrooms*') || request()->routeIs('teacher.classrooms*')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div
            class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('classrooms*') || request()->routeIs('teacher.classrooms*')
                ? 'bg-white/20'
                : 'bg-gray-100 group-hover:bg-secondary-400/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-school-icon lucide-school w-5 h-5">
                <path d="M14 21v-3a2 2 0 0 0-4 0v3" />
                <path d="M18 5v16" />
                <path d="m4 6 7.106-3.79a2 2 0 0 1 1.788 0L20 6" />
                <path
                    d="m6 11-3.52 2.147a1 1 0 0 0-.48.854V19a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a1 1 0 0 0-.48-.853L18 11" />
                <path d="M6 5v16" />
                <circle cx="12" cy="9" r="2" />
            </svg>
        </div>
        <span
            class="{{ request()->routeIs('classrooms*') || request()->routeIs('teacher.classrooms*') ? 'font-semibold' : 'font-medium' }}">Classrooms</span>
        @if (request()->routeIs('classrooms*') || request()->routeIs('teacher.classrooms*'))
            <span class="sr-only">active</span>
        @endif
    </a>





</div>
