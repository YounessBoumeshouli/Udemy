<?php
$title = 'Youdemy - Add Course';
ob_start();
?>

<h1>Add New Course</h1>

<form action="index.php?action=add_course" method="POST">
    <input type="hidden" value="null">
<input type="hidden" name="selected_tags" id="selected-tags" value="">

    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
    </div>
    <div>
        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" required>
            <?php
            foreach ($categories as $cat ) {            
            ?>
            <option value="<?=$cat->getId()?>"><?=$cat->getName()?></option>
            <?php
            }
            ?>
        </select>
    </div>
    <div>
        <label for="content_type">Content Type:</label>
        <select id="content_type" name="content_type" required>
            <option value="video">Video</option>
            <option value="document">Document</option>
        </select>
    </div>
    <div>
        <label for="document_url">Content URL:</label>
        <input type="url" id="content_url" name="document_url" required>
    </div>
    <div class=" w-screen flex items-center justify-center flex-wrap">
    <?php foreach ($tags as $tag): ?>
                <div class="tag-button w-full max-w-[150px] h-[70px] bg-gray-800 rounded-[20px] flex items-center justify-start backdrop-blur-md transition-transform duration-500 hover:scale-105 cursor-pointer ml-4" id="tag-<?= $tag->getId() ?>" data-id="<?= $tag->getId() ?>">
                    <div class="w-[50px] h-[50px] ml-2.5 rounded-[10px] bg-gradient-to-br from-gray-300 via-gray-400 to-indigo-400 hover:from-indigo-400 hover:to-red-700 transition duration-500"></div>
                    <div class="ml-2.5 text-white font-sans w-[calc(100%-90px)]">
                        <p class="text-lg font-bold"><?= $tag->getTitle() ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <div>
        <input type="submit" value="Add Course" class="button">
    </div>
    <input type="hidden" name="teacher_id" value="<?=$_SESSION['user']["id_user"]?>">
</form>
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
       
    </script>
<?php
$content = ob_get_clean();
include 'views/layout.php';
?>

