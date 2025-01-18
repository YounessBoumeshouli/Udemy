<?php
$title = 'Youdemy - Admin Dashboard';
ob_start();
var_dump($pendinCourses);
?>

<div class="min-h-screen bg-gray-100">
    <!-- Top Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm font-medium">Total Users</h3>
            <p class="text-3xl font-bold text-red-600"><?=$statistics['total_teachers']+$statistics['total_students']?></p>
            <div class="mt-2 text-sm text-gray-600">
                <span class="text-green-500">↑ 12%</span> this month
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm font-medium">Active Teachers</h3>
            <p class="text-3xl font-bold text-red-600"><?=$statistics['total_teachers']?></p>
            <div class="mt-2 text-sm text-gray-600">
                <span class="text-green-500">↑ 8%</span> this month
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm font-medium">Total Courses</h3>
            <p class="text-3xl font-bold text-red-600"><?=$statistics['total_courses']?></p>
            <div class="mt-2 text-sm text-gray-600">
                <span class="text-green-500">↑ 15%</span> this month
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm font-medium">Active Students</h3>
            <p class="text-3xl font-bold text-red-600"><?=$statistics['total_students']?></p>
            <div class="mt-2 text-sm text-gray-600">
                <span class="text-green-500">↑ 20%</span> this month
            </div>
        </div>
    </div>

    <!-- User Approval Requests -->
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="p-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold">Teacher Approval Requests</h2>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-4 px-4">User</th>
                            <th class="pb-4 px-4">Email</th>
                            <th class="pb-4 px-4">Role</th>
                            <th class="pb-4 px-4">Date</th>
                            <th class="pb-4 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($listTeachers as $user){ ?>
                      

                        <tr class="border-b">
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full mr-3"></div>
                                    <?= htmlspecialchars($user->getUsername()) ?>
                                </div>
                            </td>
                            <td class="py-4 px-4"><?= htmlspecialchars($user->getEmail()) ?></td>
                            <td class="py-4 px-4"><?= htmlspecialchars($user->getRole()) ?></td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded"><?=$user->getStatus()?></span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex gap-2">
                                <a href="index.php?action=accept&id_user=<?=$user->getId()?>">
                                    <button class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                        Approve
                                    </button></a>
                                    <a href="index.php?action=suspend&id_user=<?=$user->getId()?>">

                                    <button class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                        Suspend
                                    </button></a>
                                   <a href="index.php?action=delete&id_user=<?=$user->getId()?>">
                                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700" >
                                        Delete
                                    </button></a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Course Approval Requests -->
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="p-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold">Course Approval Requests</h2>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-4 px-4">Course</th>
                            <th class="pb-4 px-4">Description</th>
                            <th class="pb-4 px-4">Category</th>
                            <th class="pb-4 px-4">Date</th>
                            <th class="pb-4 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    foreach ($pendinCourses as $course) {                    
                        ?>
                        <tr class="border-b">
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <img src="https://via.placeholder.com/120x80" alt="Course" class="w-20 h-14 object-cover rounded mr-3">
                                    <div>
                                        <p class="font-medium"><?=$course->getTitle()?></p>
                                        <p class="text-sm text-gray-500">15 hours</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4"><?=$course->getDescription()?></td>
                            <td class="py-4 px-4"><?=$course->getStatus()?></td>
                            <td class="py-4 px-4">2024-01-14</td>
                            <td class="py-4 px-4">
                                <div class="flex gap-2">
                                    <a href="index.php?action=acceptCourse&id=<?=$course->getId()?>"><button class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                        Approve
                                    </button></a>
                                    <a href="index.php?action=banCourse&id=<?=$course->getId()?>"><button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Reject
                                    </button></a>
                                </div>
                            </td>
                        </tr>
                        <?php
                        }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Categories and Tags Management -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Categories -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 border-b flex justify-between items-center">
                <h2 class="text-xl font-bold">Categories</h2>
                <button onclick="document.getElementById('addCategoryModal').classList.remove('hidden')" 
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Add Category
                </button>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="pb-4 px-4">Name</th>
                                <th class="pb-4 px-4">Courses</th>
                                <th class="pb-4 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($categories as $category) {
                                ?>
                            <tr class="border-b">
                                <td class="py-4 px-4"><?=$category->getName()?></td>
                                <td class="py-4 px-4"><?=$category->getId()?></td>
                                <td class="py-4 px-4">
                                    <a href="index.php?action=delete"><button class="text-red-600 hover:text-red-800">view</button></a>
                                </td>
                            </tr>
                            <?php
                        }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tags -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 border-b flex justify-between items-center">
                <h2 class="text-xl font-bold">Tags</h2>
                <button onclick="document.getElementById('addTagModal').classList.remove('hidden')" 
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Add Tag
                </button>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="pb-4 px-4">Name</th>
                                <th class="pb-4 px-4">Uses</th>
                                <th class="pb-4 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($tags as $tag) {
                            
                            ?>
                            <tr class="border-b">
                                <td class="py-4 px-4"><?=$tag->getTitle()?></td>
                                <td class="py-4 px-4">here number of Courses</td>
                                <td class="py-4 px-4">
                                    <a href="index.php?action=deleteTag&id=<?=$tag->getId()?>">
                                    <button class="text-red-600 hover:text-red-800">Delete</button></a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- User Management -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-4 border-b">
            <h2 class="text-xl font-bold">User Management</h2>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-4 px-4">User</th>
                            <th class="pb-4 px-4">Email</th>
                            <th class="pb-4 px-4">Role</th>
                            <th class="pb-4 px-4">Status</th>
                            <th class="pb-4 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listUsers as $user): ?>
                        <tr class="border-b">
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full mr-3"></div>
                                    <?= htmlspecialchars($user["username"]) ?>
                                </div>
                            </td>
                            <td class="py-4 px-4"><?= htmlspecialchars($user["email"]) ?></td>
                            <td class="py-4 px-4"><?= htmlspecialchars($user["role"]) ?></td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded">Active</span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex gap-2">
                                    <button class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                        Approve
                                    </button>
                                    <button class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                        Suspend
                                    </button>
                                   <a href="index.php?action=delete&id_user=<?=$user["id_user"]?>">
                                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700" >
                                        Delete
                                    </button></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg w-96">
            <h3 class="text-xl font-bold mb-4">Add Category</h3>
            <form action="index.php?action=add_category" method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" for="categoryName">Category Name</label>
                    <input type="text" id="categoryName" name="name" 
                           class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-red-600">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" 
                            onclick="this.closest('#addCategoryModal').classList.add('hidden')"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Add Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Tag Modal -->
    <div id="addTagModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg w-96">
            <h3 class="text-xl font-bold mb-4">Add Tag</h3>
            <form action="index.php?action=add_tag" method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" for="tagName">Tag Name</label>
                    <input type="text" id="tagName" name="name" 
                           class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-red-600">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" 
                            onclick="this.closest('#addTagModal').classList.add('hidden')"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Add Tag
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'views/layout.php';
?>