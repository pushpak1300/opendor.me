<footer class="bg-gray-800">
    <div class="py-12 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <ul class="flex flex-wrap justify-center -mx-4 space-x-2 -sm:mx-6 -lg:mx-8 sm:space-x-4">
            <li>
                <a href="https://plant.treeware.earth/Astrotomic/opendor.me" class="block py-2 px-4 text-base text-gray-300 hover:text-white sm:px-6 lg:px-8">
                    Plant a Tree
                </a>
            </li>
            <li>
                <a href="https://pingping.io/wQwuV01Z" class="block py-2 px-4 text-base text-gray-300 hover:text-white sm:px-6 lg:px-8">
                    Status
                </a>
            </li>
            <li>
                <a href="https://plausible.io/opendor.me" class="block py-2 px-4 text-base text-gray-300 hover:text-white sm:px-6 lg:px-8">
                    Statistics
                </a>
            </li>
        </ul>

        <div class="mt-4 md:flex md:items-center md:justify-between">
            <div class="flex justify-center space-x-6 md:order-2">
                <a href="https://github.com/Astrotomic/opendor.me" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">GitHub</span>
                    <x-fab-github class="w-6 h-6"/>
                </a>
            </div>
            <div class="mt-8 md:mt-0 md:order-1">
                <p class="text-base text-center text-gray-400">
                    <span class="block sm:inline"><a href="{{ url('/') }}" class="hover:text-white">{{ config('app.name') }}</a> &copy; {{ date('Y') }} <a href="https://astrotomic.info" class="hover:text-white">Astrotomic</a>.</span>
                    <span class="block sm:inline">All rights reserved.</span>
                </p>
            </div>
        </div>
    </div>
</footer>
