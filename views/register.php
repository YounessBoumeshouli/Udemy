<?php
$title = 'Youdemy - Register';
ob_start();
?>

<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg slide-up">
    <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Create Account</h1>
    
    <form action="index.php?action=register" method="POST" class="space-y-6">
        <div class="space-y-2">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input 
                type="text" 
                id="username" 
                name="username" 
                required 
                class="form-input"
                placeholder="Choose a username"
            />
        </div>

        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                required 
                class="form-input"
                placeholder="Enter your email"
            />
        </div>

        <div class="space-y-2">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                required 
                class="form-input"
                placeholder="Choose a strong password"
            />
            <p class="text-xs text-gray-500">Password must be at least 8 characters long</p>
        </div>

        <div class="space-y-2">
            <label for="role" class="block text-sm font-medium text-gray-700">I want to</label>
            <select 
                id="role" 
                name="role" 
                required 
                class="form-input form-select"
            >
                <option value="student">Learn on Youdemy</option>
                <option value="teacher">Teach on Youdemy</option>
            </select>
        </div>
        <input type="hidden" name="status" value="SAFE">
        <div class="space-y-4">
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    id="terms" 
                    name="terms" 
                    required
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                >
                <label for="terms" class="ml-2 block text-sm text-gray-700">
                    I agree to the 
                    <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms of Service</a>
                    and
                    <a href="#" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                </label>
            </div>

            <button 
                type="submit" 
                class="w-full py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:-translate-y-1"
            >
                Create Account
            </button>
        </div>
    </form>

    <div class="mt-6 text-center text-sm">
        <p class="text-gray-600">
            Already have an account? 
            <a href="index.php?action=login" class="text-indigo-600 hover:text-indigo-500 font-medium transition-colors duration-300">
                Sign in here
            </a>
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'layout.php';
?>
