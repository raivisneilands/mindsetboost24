<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo / Brand -->
            <div class="flex-shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-600">
                    Admin Panel
                </a>
            </div>

            <!-- Nav Links -->
            <div class="hidden md:flex space-x-6 items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('admin.dashboard') ? 'underline' : '' }}">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('admin.products.*') ? 'underline' : '' }}">Products</a>
                <a href="{{ route('admin.categories.index') }}" class="text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('admin.categories.*') ? 'underline' : '' }}">Categories</a>
            </div>

            <!-- User Dropdown -->
            <div class="relative">
                <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 focus:outline-none" onclick="document.getElementById('dropdown-menu').classList.toggle('hidden')">
                    <span>{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="dropdown-menu" class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg hidden z-50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    // Close dropdown if clicked outside
    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('dropdown-menu');
        if (!e.target.closest('button') && !e.target.closest('#dropdown-menu')) {
            dropdown.classList.add('hidden');
        }
    });
</script>
