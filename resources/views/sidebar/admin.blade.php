<!-- Sidebar Navigation -->
<div class="flex flex-col gap-2 overflow-y-auto pb-6">


    <a href="{{ route('admin.dashboard') }}" wire:navigate
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('admin.dashboard')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div
            class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-secondary-400/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard w-h h-5">
                <rect width="7" height="9" x="3" y="3" rx="1" />
                <rect width="7" height="5" x="14" y="3" rx="1" />
                <rect width="7" height="9" x="14" y="12" rx="1" />
                <rect width="7" height="5" x="3" y="16" rx="1" />
            </svg>
        </div>
        <span class="{{ request()->routeIs('admin.dashboard') ? 'font-semibold' : 'font-medium' }}">Dashboard</span>
        @if (request()->routeIs('admin.dashboard'))
            <span class="sr-only">active</span>
        @endif
    </a>

    <a href="{{ route('admin.classrooms.index') }} " wire:navigate
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('classrooms*') || request()->routeIs('admin.classrooms*')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div
            class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('classrooms*') || request()->routeIs('admin.classrooms*')
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
            class="{{ request()->routeIs('classrooms*') || request()->routeIs('admin.classrooms*') ? 'font-semibold' : 'font-medium' }}">Classrooms</span>
        @if (request()->routeIs('classrooms*') || request()->routeIs('admin.classrooms*'))
            <span class="sr-only">active</span>
        @endif
    </a>

    <a href="{{ route('admin.students.index') }}"
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('students*')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div
            class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('students*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-secondary-400/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-graduation-cap-icon lucide-graduation-cap w-5 h-5">
                <path
                    d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z" />
                <path d="M22 10v6" />
                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5" />
            </svg>
        </div>
        <span class="{{ request()->routeIs('students*') ? 'font-semibold' : 'font-medium' }}">Students</span>
        @if (request()->routeIs('students*'))
            <span class="sr-only">active</span>
        @endif
    </a>

    <a href="{{ route('admin.teachers.index') }}"
        class="flex items-center rounded-lg gap-3 px-4 py-3 text-sm font-medium transition-all duration-200
        {{ request()->routeIs('teachers*')
            ? 'bg-gradient-to-r from-secondary-400 to-secondary-300 text-white shadow-md'
            : 'text-gray-600 hover:bg-gradient-to-r hover:from-secondary-400/10 hover:to-secondary-300/10 hover:text-secondary-400' }}
        group">
        <div
            class="p-2 rounded-lg transition-colors
            {{ request()->routeIs('teachers*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-secondary-400/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-users-icon lucide-users w-5 h-5">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                <circle cx="9" cy="7" r="4" />
            </svg>
        </div>
        <span class="{{ request()->routeIs('teachers*') ? 'font-semibold' : 'font-medium' }}">Teachers</span>
        @if (request()->routeIs('teachers*'))
            <span class="sr-only">active</span>
        @endif
    </a>

</div>
