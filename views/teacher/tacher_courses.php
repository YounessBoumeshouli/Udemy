<?php
$title = 'Teacher Courses';
ob_start();
?>

<!-- Main Content -->
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">My Courses</h1>
        <a href="index.php?action=add_course" class="button bg-indigo-600 hover:bg-indigo-700 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Course
        </a>
    </div>

    <!-- Course Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($courses as $course): ?>
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                <div class="relative">
                  
                    <div class="absolute top-4 right-4 flex gap-2">
                        <!-- Edit Button -->
                        <button onclick="openEditModal(<?php echo $course->getId(); ?>)" 
                                class="bg-white p-2 rounded-full shadow-lg hover:bg-gray-100 transition-colors duration-300">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <!-- Delete Button -->
                        <button onclick="openDeleteModal(<?php echo $course->getId(); ?>)" 
                                class="bg-white p-2 rounded-full shadow-lg hover:bg-gray-100 transition-colors duration-300">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        <?php echo htmlspecialchars($course->getTitle()); ?>
                    </h3>
                    <p class="text-gray-600 mb-4">
                        <?php echo htmlspecialchars(substr($course->getDescription(), 0, 100)) . '...'; ?>
                    </p>
                    <div class="flex justify-between items-center">
                       
                       
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4 animate-modal-pop">
        <div class="text-center">
            <svg class="mx-auto mb-4 w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 mb-4">Delete Course</h3>
            <p class="text-gray-500 mb-6">Are you sure you want to delete this course? This action cannot be undone.</p>
            <input type="hidden" id="deleteModalCourseId" value="">
            <div class="flex justify-center gap-4">
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-300">
                    Cancel
                </button>
                <button onclick="deleteCourse()" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Course Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-2xl w-full mx-4 animate-modal-pop">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">Edit Course</h3>
        <form id="editCourseForm" action="index.php?action=edite_course" method="post"  class="space-y-6">
            <input type="hidden" id="editModalCourseId" value="">
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Course Title</label>
                <input type="text" id="title" name="title" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <input type="hidden" id="id" name="id" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>
            
            
            <div>
        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" required>
        <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat->getId() ?>" 
                <?php echo ($course->getCategory() == $cat->getId()) ? 'selected' : ''; ?>>
            <?= $cat->getName() ?>
        </option>
    <?php endforeach; ?>
</select>
    </div>
    <div class="flex   items-center justify-center flex-wrap">
            <?php foreach ($tags as $tag): ?>
                <div class="tag-button w-full max-w-[120px] h-[50px] bg-gray-800 rounded-[15px] flex items-center justify-start backdrop-blur-md transition-transform duration-500 hover:scale-105 cursor-pointer ml-4" id="tag-<?= $tag->getId() ?>" data-id="<?= $tag->getId() ?>">
                    <div class="w-[30px] h-[30px] ml-2.5 rounded-[6px] bg-gradient-to-br from-gray-300 via-gray-400 to-indigo-400 hover:from-indigo-400 hover:to-red-700 transition duration-500"></div>
                    <div class="ml-2.5 text-white font-sans w-[calc(100%-70px)]">
                        <p class="text-lg font-bold"><?= $tag->getTitle() ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Course URL</label>
                <input type="text" id="image" name="image" accept="image/*"  value="<?=$course->getUrl()?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
         
            
            <div class="flex justify-end gap-4 mt-8">
                <button type="button" onclick="closeEditModal()" 
                        class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-300">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-300">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .animate-modal-pop {
        animation: modalPop 0.3s ease-out;
    }
    @keyframes modalPop {
        0% {
            transform: scale(0.9);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>
<script>
        const selectedTags = new Set();

        document.querySelectorAll('.tag-button').forEach(button => {
            button.addEventListener('click', () => {
                const tagId = button.dataset.id;

                // Toggle selection
                if (selectedTags.has(tagId)) {
                    selectedTags.delete(tagId);
                    button.classList.remove('bg-blue-500'); // Example visual feedback
                } else {
                    selectedTags.add(tagId);
                    button.classList.add('bg-blue-500'); // Example visual feedback
                }

                // Update the hidden input field
                document.getElementById('selected-tags').value = Array.from(selectedTags).join(',');
                console.log("Selected Tags:", document.getElementById('selected-tags').value);
            });
        });

        // Ensure the hidden input is updated before form submission
        document.querySelector('form').addEventListener('submit', function (event) {
            document.getElementById('selected-tags').value = Array.from(selectedTags).join(',');
            console.log("Form submitted with selected tags:", document.getElementById('selected-tags').value);
        });

        // Image Upload Script
       

    // Modal Management
    function openDeleteModal(courseId) {
        document.getElementById('deleteModalCourseId').value = courseId;
        console.log(courseId)
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }

    function openEditModal(courseId) {
        document.getElementById('editModalCourseId').value = courseId;
        // Fetch course data and populate form
        fetch(`index.php?action=get_course&id=${courseId}`)
            .then(response => response.json())
            .then(course => {
                console.log(course)
                document.getElementById('title').value = course.title;
                document.getElementById('description').value = course.description;
                document.getElementById('id').value = course.id;
                document.getElementById('category_id').value = course.category;
                selectedTags.clear();
                course.tags.forEach(tag => {
                    id = `tag-${tag.tagId}`
                    document.getElementById(id).click();
                    console.log(tag.tagId);

                });

            });
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }

    function deleteCourse() {
        const courseId = document.getElementById('deleteModalCourseId').value;
        window.location.href = `index.php?action=deleteCourse&id=${courseId}`;
        console.log(courseId)
    }

    

    // Close modals when clicking outside
    window.onclick = function(event) {
        const deleteModal = document.getElementById('deleteModal');
        const editModal = document.getElementById('editModal');
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
        if (event.target === editModal) {
            closeEditModal();
        }
    }
</script>

<?php
$content = ob_get_clean();
include 'views/layout.php';
?>
