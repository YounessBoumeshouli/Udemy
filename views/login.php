<?php
$title = 'Youdemy - Login';
ob_start();
?>

<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg slide-up">
    <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Welcome Back</h1>
    
    <?php if (isset($error)): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded fade-in" role="alert">
            <p><?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <form action="index.php?action=login" method="POST" class="space-y-6">
        <div class="space-y-2">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input 
                type="text" 
                id="username" 
                name="username" 
                required 
                class="form-input"
                placeholder="Enter your username"
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
                placeholder="Enter your password"
            />
        </div>

        <div class="flex items-center justify-between text-sm">
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    id="remember" 
                    name="remember" 
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                >
                <label for="remember" class="ml-2 block text-gray-700">Remember me</label>
            </div>
            <a href="#" class="text-indigo-600 hover:text-indigo-500 transition-colors duration-300">Forgot password?</a>
        </div>

        <button 
            type="submit" 
            class="w-full py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:-translate-y-1"
        >
            Sign in
        </button>
    </form>

    <div class="mt-6 text-center text-sm">
        <p class="text-gray-600">
            Don't have an account? 
            <a href="index.php?action=register" class="text-indigo-600 hover:text-indigo-500 font-medium transition-colors duration-300">
                Sign up here
            </a>
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'layout.php';
?>
