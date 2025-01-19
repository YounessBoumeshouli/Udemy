<?php
$title = 'Youdemy - Home';
ob_start();
?>
<div class="space-y-8">
    <div class="text-center py-12 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg shadow-lg mb-12">
        <h1 class="text-4xl font-bold text-white mb-4">Welcome to Youdemy</h1>
        <p class="text-lg text-gray-100 mb-8">Discover your next learning adventure</p>
        
        <form action="index.php" method="GET" class="max-w-2xl mx-auto flex gap-4 px-4">
            <input type="hidden" name="action" value="search">
            <input 
                type="text" 
                name="keyword" 
                placeholder="What do you want to learn today?" 
                class="flex-grow p-3 rounded-lg border-2 border-transparent focus:border-indigo-300 focus:ring-2 focus:ring-indigo-200 focus:outline-none transition-all duration-300"
            >
            <button type="submit" class="px-6 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-300 shadow-md">
                Search
            </button>
        </form>
    </div>

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Featured Courses</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($courses as $course): ?>
            
                <a href="index.php?action=course&id=<?=$course->getId()?>" class="block">
                    <div class="course-card group bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 relative overflow-hidden h-full hover:scale-105 transform transition-all duration-300">
                        <div class="p-6 flex flex-col h-full">
                            <h3 class="text-xl font-semibold text-gray-800 mb-3 group-hover:text-indigo-600 transition duration-300">
                                <?php echo htmlspecialchars($course->getTitle()); ?>
                            </h3>
                            <p class="text-gray-600 mb-4 flex-grow">
                                <?php echo htmlspecialchars(substr($course->getDescription(), 0, 100)) . '...'; ?>
                            </p>
                            <div class="inline-flex items-center text-indigo-600 font-medium group-hover:text-indigo-700 transition duration-300">
                                Learn More
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            
            <?php endforeach; ?>
        </div>
    </div>

    <div class="flex justify-between items-center mt-12">
        <?php if ($page > 1): ?>
            <a 
                href="index.php?page=<?php echo $page - 1; ?>" 
                class="px-6 py-3 bg-white text-gray-700 font-medium rounded-lg border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition duration-300 shadow-sm"
            >
                Previous Page
            </a>
        <?php else: ?>
            <div></div>
        <?php endif; ?>
        
        <a 
            href="index.php?page=<?php echo $page + 1; ?>" 
            class="px-6 py-3 bg-white text-gray-700 font-medium rounded-lg border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition duration-300 shadow-sm"
        >
            Next Page
        </a>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'layout.php';
?>
