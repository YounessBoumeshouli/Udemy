<?php
$title = 'Youdemy - ' . htmlspecialchars($course->getTitle());
ob_start();
?>

<div class="max-w-6xl mx-auto">
    <!-- Course Header Section -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden slide-up mb-8">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-12 text-white">
            <h1 class="text-4xl font-bold mb-4"><?php echo htmlspecialchars($course->getTitle()); ?></h1>
            <div class="flex items-center space-x-4 text-sm">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    8 hours of content
                </span>
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Certificate of completion
                </span>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Course Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                <div class="prose max-w-none">
                    <h2 class="text-2xl font-semibold mb-4">About this course</h2>
                    <p class="text-gray-600 leading-relaxed mb-8">
                        <?php echo htmlspecialchars($course->getDescription()); ?>
                    </p>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-xl font-semibold mb-4">What you'll learn</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Comprehensive understanding of the subject</span>
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Practical examples and exercises</span>
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Real-world applications</span>
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Lifetime access to course materials</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Column - Course Content -->
        <div class="lg:col-span-2">
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student'): ?>
                <?php if (!$course->checkCourse($_SESSION['user']["id_user"],$courseId)): ?>
                    <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Ready to Start Learning?</h3>
                        <p class="text-gray-600 mb-6">Enroll now to access all course materials and start your learning journey.</p>
                        <a href="index.php?action=enroll&id=<?php echo $course->getId(); ?>" 
                           class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:-translate-y-1">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Enroll in this course
                        </a>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                        <div class="bg-gray-800 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-gray-300 font-medium">Course Content</span>
                            </div>
                            <button onclick="toggleFullscreen()" class="text-gray-300 hover:text-white text-sm font-medium flex items-center transition-colors duration-200">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                </svg>
                                Toggle Fullscreen
                            </button>
                        </div>
                        <div class="aspect-w-16 aspect-h-9 bg-black">
                            <iframe 
                                src="<?=$course->getUrl()?>" 
                                title="<?php echo htmlspecialchars($course->getTitle()); ?>"
                                class="w-full h-[700px]"
                                allowfullscreen
                                loading="lazy"
                                style="border: none;">
                            </iframe>
                        </div>
                    </div>
                <?php endif; ?>
            <?php elseif (!isset($_SESSION['user'])): ?>
                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <div class="max-w-md mx-auto">
                        <svg class="w-16 h-16 text-indigo-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Sign in to Access Course</h3>
                        <p class="text-gray-600 mb-6">Please log in to your account to access this course content.</p>
                        <a href="index.php?action=login" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                            Sign in to continue
                        </a>
                    </div>
                </div>
            <?php elseif (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'teacher'||'admin'): ?>
                <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                    <div class="bg-gray-800 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-gray-300 font-medium">Course Preview</span>
                        </div>
                        <button onclick="toggleFullscreen()" class="text-gray-300 hover:text-white text-sm font-medium flex items-center transition-colors duration-200">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                            Toggle Fullscreen
                        </button>
                    </div>
                    <div class="aspect-w-16 aspect-h-9 bg-black">
                        <iframe 
                            src="<?=$course->getUrl()?>" 
                            title="<?php echo htmlspecialchars($course->getTitle()); ?>"
                            class="w-full h-[700px]"
                            allowfullscreen
                            loading="lazy"
                            style="border: none;">
                        </iframe>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function toggleFullscreen() {
    const iframe = document.querySelector('iframe');
    if (!document.fullscreenElement) {
        if (iframe.requestFullscreen) {
            iframe.requestFullscreen();
        } else if (iframe.webkitRequestFullscreen) {
            iframe.webkitRequestFullscreen();
        } else if (iframe.msRequestFullscreen) {
            iframe.msRequestFullscreen();
        }
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}
</script>

<?php
$content = ob_get_clean();
include 'layout.php';
?>
