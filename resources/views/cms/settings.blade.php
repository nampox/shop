@extends('layouts.cms')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Settings Navigation -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <nav class="space-y-1">
                    <a href="#general" class="settings-nav flex items-center space-x-3 px-4 py-3 rounded-lg bg-blue-50 text-blue-700 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>General</span>
                    </a>
                    <a href="#security" class="settings-nav flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>Security</span>
                    </a>
                    <a href="#notifications" class="settings-nav flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span>Notifications</span>
                    </a>
                    <a href="#appearance" class="settings-nav flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                        <span>Appearance</span>
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Settings Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- General Settings -->
            <div id="general" class="settings-section bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">General Settings</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                        <input type="text" value="{{ config('app.name', 'Shop') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site Description</label>
                        <textarea rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none" placeholder="Enter site description..."></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site URL</label>
                        <input type="url" value="{{ url('/') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Admin Email</label>
                        <input type="email" value="{{ config('mail.from.address', 'admin@example.com') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                    </div>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Maintenance Mode</h3>
                            <p class="text-sm text-gray-500">Put your site in maintenance mode</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    
                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Security Settings -->
            <div id="security" class="settings-section bg-white rounded-xl shadow-sm border border-gray-200 p-6 hidden">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Security Settings</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Two-Factor Authentication</label>
                        <p class="text-sm text-gray-500 mb-4">Add an extra layer of security to your account</p>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                            Enable 2FA
                        </button>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Session Timeout</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                            <option>15 minutes</option>
                            <option>30 minutes</option>
                            <option>1 hour</option>
                            <option>2 hours</option>
                        </select>
                    </div>
                    
                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Settings navigation
    document.querySelectorAll('.settings-nav').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Update active state
            document.querySelectorAll('.settings-nav').forEach(nav => {
                nav.classList.remove('bg-blue-50', 'text-blue-700', 'font-medium');
                nav.classList.add('text-gray-700');
            });
            this.classList.add('bg-blue-50', 'text-blue-700', 'font-medium');
            this.classList.remove('text-gray-700');
            
            // Show/hide sections
            const target = this.getAttribute('href');
            document.querySelectorAll('.settings-section').forEach(section => {
                section.classList.add('hidden');
            });
            document.querySelector(target).classList.remove('hidden');
        });
    });
</script>
@endpush
@endsection

